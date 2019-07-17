$(document).ready(function() {
//Inicia o documento com os forms escondidos
    $('#formAdd').hide();
    $('#formRem').hide();
    $('#formUp').hide();

// Funções acionadas ao clicar no btn "addUser"
$('#addUser').click(function(){
    $('#formRem').hide();
    $('#formUp').hide();
    $('.btnAdd').removeClass('btn-light');
    $('.btnAdd').addClass('btn-success');
    $('.btnRem').removeClass('btn-success');
    $('.btnRem').addClass('btn-light');
    $('.btnUp').removeClass('btn-success');
    $('.btnUp').addClass('btn-light');
    $('#formAdd').toggle();
    
});

// Funções acionadas ao clicar no btn "remUser"
$('#remUser').click(function(){
    $('#formUp').hide();
    $('#formAdd').hide();
    $('.btnRem').removeClass('btn-light');
    $('.btnRem').addClass('btn-success');
    $('.btnAdd').removeClass('btn-success');
    $('.btnAdd').addClass('btn-light');
    $('.btnUp').removeClass('btn-success');
    $('.btnUp').addClass('btn-light');
    $('#formRem').toggle();
 
});

// Funções acionadas ao clicar no btn "upUser"
$('#upUser').click(function(){
    $('#formAdd').hide();
    $('#formRem').hide();
    $('.btnUp').removeClass('btn-light');
    $('.btnUp').addClass('btn-success');
    $('.btnAdd').removeClass('btn-success');
    $('.btnAdd').addClass('btn-light');
    $('.btnRem').removeClass('btn-success');
    $('.btnRem').addClass('btn-light');
    $('#formUp').toggle();

});

//Eventos acionados ao dar submit no form "formAdd"
$('#formAdd').submit(function(e){
    e.preventDefault();
    let form =  $(this);
    $.ajax({
        method: 'POST',
        url: 'http://localhost:9001/backend/api/users',
        dataType: 'json',
        data: form.serialize()
    }).success(function(result){
            $('#formAdd')[0].reset(); 
            console.log(result);
    })}
)

//Eventos acionados ao dar submit no form "formRem"
$('#formRem').submit(function(e){
    e.preventDefault();
    let form =  $(this);
    $.ajax({
        method: 'DELETE',
        url: 'http://localhost:9001/backend/api/users',
        dataType: 'json',
        data: form.serialize()
    }).success(function(result){
        $('#formRem')[0].reset(); 
        console.log(result);
    })}
)

//Eventos acionados ao dar submit no form "formUp"
$('#formUp').submit(function(e){
    e.preventDefault();
    let form =  $(this);
    $.ajax({
        method: 'PUT',
        url: 'http://localhost:9001/backend/api/users',
        dataType: 'json',
        data: form.serialize()
    }).success(function(result){
        $('#formUp')[0].reset();
        console.log(result);
    })}
)

//Cor ao fundo do input clicado
$('input[type=text]').focus(function(){
    // alert('Focus');
    $(this).css('background', 'rgba(0,255,0,0.3)');
});

$('input[type=text]').blur(function(){
    $(this).css('background', 'white');
});


});