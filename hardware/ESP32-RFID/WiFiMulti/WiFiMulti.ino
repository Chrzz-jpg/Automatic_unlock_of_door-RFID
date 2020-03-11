/*
 *  This sketch trys to Connect to the best AP based on a given list
 *
 */

#include <WiFi.h>
#include <WiFiMulti.h>

#include <LiquidCrystal.h>

LiquidCrystal lcd(22,23,5,18,19,21);

WiFiMulti wifiMulti;

void setup()
{
    Serial.begin(115200);
    delay(10);
    lcd.begin(16, 2);
    lcd.clear();
    lcd.setCursor(0,0);
    delay(10);

    WiFi.setAutoConnect (true);
    WiFi.setAutoReconnect (true);

    wifiMulti.addAP("Ap dos meninos", "capadocia");
    wifiMulti.addAP("Servidor", "12345678");
    wifiMulti.addAP("eduram", "0123456789");

    Serial.println("Connecting Wifi...");
    lcd.print("Conectando WiFi ");
    if(wifiMulti.run() == WL_CONNECTED) {
        Serial.println("");
        Serial.println("WiFi connected");
        Serial.println("IP address: ");
        Serial.println(WiFi.localIP());
        Serial.println(WiFi.SSID());
        lcd.clear();
        lcd.setCursor(0,0);
        lcd.print("WiFi Conectado! ");
        lcd.setCursor(0,1);
        lcd.print(WiFi.SSID());
    }
}

void loop()
{
    uint8_t WL_status = WiFi.status();

    Serial.println(WL_status);

    if (WL_status != WL_CONNECTED || WL_status == 6) {

            WiFi.disconnect();
            Serial.println("WiFi not connected!");

            lcd.clear();
            lcd.setCursor(0,0);
            lcd.print("      WiFi      ");
            lcd.setCursor(0,1);
            lcd.print(" Nao Conectado! ");

            delay(2000);

            ESP.restart();

            Serial.println("Connecting Wifi...");
            lcd.clear();
            lcd.setCursor(0,0);
            lcd.print("Conectando WiFi ");


      
            if(wifiMulti.run() == WL_CONNECTED) {
                Serial.println("");
                Serial.println("WiFi connected");
                Serial.println("IP address: ");
                Serial.println(WiFi.localIP());
                Serial.println(WiFi.SSID());

                lcd.clear();
                lcd.setCursor(0,0);
                lcd.print("WiFi Conectado! ");
                lcd.setCursor(0,1);
                lcd.print(WiFi.SSID());
                
            }
            else {
                Serial.println("WiFi disconnected!");

                lcd.clear();
                lcd.setCursor(0,0);
                lcd.print("      WiFi      ");
                lcd.setCursor(0,1);
                lcd.print(" Disconectado!  ");
                
                delay(1000);
                
                //WiFi.disconnect();
            }  
            
    }
    
}
