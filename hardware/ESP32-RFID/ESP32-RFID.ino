#include <MFRC522.h> //biblioteca responsável pela comunicação com o módulo RFID-RC522
#include <SPI.h> //biblioteca para comunicação do barramento SPI
#include <ArduinoJson.h> // biblioteca para comunicação json 
#include <string.h> // biblioteca 
//#include <WiFi.h>  // biblioteca
#include <WiFiMulti.h> // biblioteca
#include <HTTPClient.h> // biblioteca

/* ===============  DEFINE PINOS RFID  ============== */
#define SS_PIN    21
#define RST_PIN   22 

#define SIZE_BUFFER     18
#define MAX_SIZE_BLOCK  16

/* ===============  DEFINE PINOS OLED  ============== */
// #define pinVerde     12
// #define pinVermelho  32

/* ===============  DEFINE PINO TRAVA  ============== */
#define TRAVA 32

// Definicoes pino modulo RC522
MFRC522 mfrc522(SS_PIN, RST_PIN); 

/* ===============      FUNCOES      ============== */
void Unlock();                    // Função para Destravar 
void TaskWiFi( void *parameter );  // Tarefa WiFi
void TaskRFID( void *parameter ); // Tarefa RFID

/* ===============    VARIAVEIS     ============== */
TaskHandle_t TaskWiFi_t, TaskRFID_t;

MFRC522::MIFARE_Key key;   //esse objeto 'chave' é utilizado para autenticação
MFRC522::StatusCode status;    //código de status de retorno da autenticação
DynamicJsonDocument jsonBuffer(1024); 

String firmware_v = "v1.1";
String ID = "";
const char* ssid = "labmidia";
const char* password = "labmidia2013";
byte nuidPICC[4];     // Init array that will store new NUID
bool New_tag = false;
bool WiFi_connected = false;

//faz o controle do temporizador (interrupção por tempo)
hw_timer_t *timer = NULL; 
 
//função que o temporizador irá chamar, para reiniciar o ESP32
void IRAM_ATTR resetModule(){
ets_printf("(watchdog) reiniciar\n"); //imprime no log
esp_restart(); //reinicia o chip
}
 
//função que o configura o temporizador
void configureWatchdog()
{
timer = timerBegin(0, 80, true); //timerID 0, div 80
//timer, callback, interrupção de borda
timerAttachInterrupt(timer, &resetModule, true);
//timer, tempo (us), repetição
timerAlarmWrite(timer, 5000000, true);
timerAlarmEnable(timer); //habilita a interrupção //enable interrupt
}

/* ===============      SETUP       ============== */
void setup() {

  pinMode(TRAVA, OUTPUT);                               // define o pino de acionamento da trava
 
  configureWatchdog();

 // Inicia a serial
  Serial.begin(115200);
  SPI.begin(); // Init SPI bus
  Serial.println("Iniciando Sistema...");
  Serial.println("LAC - " + firmware_v);
  
// Inicia MFRC522
mfrc522.PCD_Init();
//mfrc522.PCD_SetAntennaGain(rfid.RxGain_min);             // Configura leitor para Potência minima
 
// Inicializa tarefa WiFi
xTaskCreatePinnedToCore(TaskWiFi, "TaskWiFi", 16384, NULL, 1, &TaskWiFi_t, 0);  //Task Function, Task name for humans, Stack size, ... , Priority, Task name, Core number

delay(500);                                           // Delay para tarefa inicializar


 while (!WiFi_connected) {                             // Aguarda conexão com rede WiFi
    delay(100);
     Serial.println("Iniciando WIFI...");
  }

  
  // Inicializa tarefa RFID
  xTaskCreatePinnedToCore(TaskRFID, "TaskRFID", 16384, NULL, 1, &TaskRFID_t, 0); //Task Function, Task name for humans, Stack size, ... , Priority, Task name, Core number

  delay(500);                                           // Delay para tarefa inicializar


}

void loop() 
{
 
 //reseta o temporizador (alimenta o watchdog)
    timerWrite(timer, 0); 
    
    if (WiFi_connected &&  New_tag ) {  
    // Se está autenticado e NÃO conectado a rede WiFi
    for (byte i = 0; i < 4; i++) {
        Serial.printf(" %02X", nuidPICC[i]);
  
      }
      Serial.print("\n");
    HTTPClient http;

        Serial.print("[HTTP] begin...\n");
        // configure traged server and url


        http.begin("http://192.168.0.102:9001/api/esp");
       


         Serial.print("[HTTP] POST...\n");
        // start connection and send HTTP header
        http.addHeader("Content-Type", " application/x-www-form-urlencoded");
    
    char _post[20];
         sprintf( _post,"tagId=%02X%02X%02X%02X",nuidPICC[0],nuidPICC[1],nuidPICC[2],nuidPICC[3]);

        int httpCode = http.POST( _post);

        // httpCode will be negative on error
        if(httpCode > 0) {
            // HTTP header has been send and Server response header has been handled
            Serial.printf("[HTTP] POST... code: %d\n", httpCode);
              
//            String payload = http.getString();
//                Serial.println(payload);

//            const size_t capacity = JSON_OBJECT_SIZE(3) + JSON_ARRAY_SIZE(2) + 60;
          const size_t capacity = JSON_ARRAY_SIZE(5) + 5*JSON_OBJECT_SIZE(3);
             DynamicJsonDocument doc(capacity);
//
//
               DeserializationError error = deserializeJson(doc, http.getString());
              if (error) {
                Serial.print(F("deserializeJson() failed: "));
                Serial.println(error.c_str());
//                return;
              }
           
         
            if(doc["acess"].as<bool>()){
              
              Serial.println(F("Response:"));
               Serial.println(doc["acess"].as<bool>());
               Serial.println(doc["nome"].as<char*>());
               Unlock() ;
              
              }
            // file found at server
            if(httpCode == HTTP_CODE_OK) {
                

                String payload = http.getString();
                Serial.println(payload);
            }
        } else {
            Serial.printf("[HTTP] GET... failed, error: %s\n", http.errorToString(httpCode).c_str());
        }

        http.end();
    }

    New_tag = false;
//    delay(1000);

       

  }
     


/* ===============   FUNCAO DESTRAVAR   ============== */
void Unlock() {
  
    digitalWrite(TRAVA, HIGH);
    delay(500);
    digitalWrite(TRAVA, LOW);
    New_tag = false;

}

void TaskWiFi( void *parameter ) {

  (void) parameter;

  bool flagWiFi_connected = WiFi_connected;

  WiFi.mode(WIFI_STA); // STA (conecta-se em alguem), AP (é conectado por alguem)

  for (;;) {
    WiFi.begin(ssid, password);
    for (int i = 0; i < 10; i++) {

      if (WiFi_connected != flagWiFi_connected) {
        flagWiFi_connected = WiFi_connected;
        Serial.println("<WiFi> Disconnected");
      }

      if (WiFi.status() != WL_CONNECTED) { // WL_CONNECTED é um define de WiFi.h
        WiFi_connected = false;
        vTaskDelay(500);
      } else {

        WiFi_connected = true;
        while (WiFi.status() == WL_CONNECTED) {
          if (WiFi_connected != flagWiFi_connected) {
            flagWiFi_connected = WiFi_connected;
            Serial.println("<WiFi> Connected");
          }
          vTaskDelay(500);
        }
      }
    }
  }
}

/* ===============     TAREFA RFID     ============== */
void TaskRFID( void *parameter ) {

  (void) parameter;

  for (byte i = 0; i < 6; i++) {
    key.keyByte[i] = 0xFF;
  }

  for (;;) {
    vTaskDelay(100);
    // Reset the loop if no new card present on the sensor/reader. This saves the entire process when idle.
    if ( ! mfrc522.PICC_IsNewCardPresent())
      continue;

    // Verify if the NUID has been readed
    if ( ! mfrc522.PICC_ReadCardSerial())
      continue;

    //USE_SERIAL.print(F("<RFID> PICC type: "));
    MFRC522::PICC_Type piccType = mfrc522.PICC_GetType(mfrc522.uid.sak);
    //USE_SERIAL.println(rfid.PICC_GetTypeName(piccType));

    // Check is the PICC of Classic MIFARE type
    if (piccType != MFRC522::PICC_TYPE_MIFARE_MINI &&
        piccType != MFRC522::PICC_TYPE_MIFARE_1K &&
        piccType != MFRC522::PICC_TYPE_MIFARE_4K) {
      // USE_SERIAL.println(F("<RFID> Your tag is not of type MIFARE Classic."));
      continue;
    }

   
    if (!New_tag) {
  
      // Store NUID into nuidPICC array
      for (byte i = 0; i < 4; i++) {
        nuidPICC[i] = mfrc522.uid.uidByte[i];
//        Serial.printf(" %02X", nuidPICC[i]);
      }
	  New_tag = true;
//      Serial.print("\n");
    }
   
    // Halt PICC
    mfrc522.PICC_HaltA();

    // Stop encryption on PCD
    mfrc522.PCD_StopCrypto1();
  }
}
