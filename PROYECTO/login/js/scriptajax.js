function cargaSendMail(){
	
    $("#c_enviar").attr("disabled", true);

    $(".c_error").remove();

    var filter=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
	
	
    var s_email = $('#c_mail').val();
    var s_name = $('#c_name').val();
	var s_ape = $('#c_ape').val(); 
	var c_cedula = $('#c_cedula').val();     
    var s_msg = $('#c_msg').val();
	

    if (filter.test(s_email)){
    sendMail = "true";
    } else{
    $('#c_mail').after("<span class='c_error' id='c_error_mail'>Ingrese correo v\u00e1lido.</span>");
	 //aplicamos color de borde si el se encontro algun error en el envio
	$('#contactform').css("border-color","#e74c3c");	
    sendMail = "false";
    }
    if (s_name.length == 0 ){
    $('#c_name').after( "<span class='c_error' id='c_error_name'>Ingrese su nombre.</span>" );
    var sendMail = "false";
    }
	  if (s_ape.length == 0 ){
    $('#c_ape').after( "<span class='c_error' id='c_error_name'>Ingrese su apellido.</span>" );
    var sendMail = "false";
    }

	 if (c_cedula.length == 0 ){
    $('#c_cedula').after( "<span class='c_error' id='c_error_name'>Por favor ingrese su C\u00e9dula de Identidad.</span>" );
    var sendMail = "false";
	
    }
	 if (c_cedula.length < 6 ){
    $('#c_cedula').after( "<span class='c_error' id='c_error_name'>El n\u00famero de d\u00edgitos de la c\u00e9dula debe ser mayor a 6.</span>" );
    var sendMail = "false";
	
    }

    if (s_msg.length == 0 ){
    $('#c_msg').after( "<span class='c_error' id='c_error_msg'>Ingrese mensaje.</span>" );
    var sendMail = "false";
    }

   
    if(sendMail == "true"){
	
     var datos = {

             "nombre" : $('#c_name').val(),
			 
			  "apellido" : $('#c_ape').val(),
			 
			  "email" : $('#c_mail').val(),

             "cedula" : $('#c_cedula').val(),

             "mensaje" : $('#c_msg').val()

     };

     $.ajax({

             data:  datos,
             // hacemos referencia al archivo ControllerUser.php
             url:   '../../controller/ControllerUser.php',

             type:  'post',

             beforeSend: function () {
			 //aplicamos color de borde si el envio es exitoso
					$('#contactform').css("border-color","#25A25A");

                     $("#c_enviar").val("Enviando...");

             },

             success:  function (response) {

                    $('form')[0].reset();  
                    $("#c_enviar").val("Enviar");
                    $("#c_information p").html(response);
                    $("#c_information").fadeIn('slow').fadeOut(12500);
				    $("#c_enviar").removeAttr("disabled");
               


             }

     });

} else{
    $("#c_enviar").removeAttr("disabled");
}

}

/*impide clic derecho y crtl-v*/
document.oncontextmenu = function(){return false}	 //
function validar(e) {	 //
  tecla = (document.all) ? e.keyCode : e.which;	 //
  //return  !(tecla==86 && e.ctrlKey);	 //
  return !(e.keyCode==86 && e.ctrlKey);	 //
} //
	
/*solo letras*/
 function val(e) {
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla==8) return true;
	patron =/[A-Za-z\sáéíóú]/;
    te = String.fromCharCode(tecla);
    return patron.test(te);
}

//*** Este Codigo permite Validar que sea un campo Numerico
    function Solo_Numerico(variable){
        Numer=parseInt(variable);
        if (isNaN(Numer)){
            return "";
        }
        return Numer;
    }
    function ValNumero(Control){
        Control.value=Solo_Numerico(Control.value);
    }
    //*** Fin del Codigo para Validar que sea un campo Numerico
	
	
	
	/*limita caracteres en campo texto*/

// número máximo de caracteres
var limite = 140;

$(document).ready(function()
{

    // cada vez que se deja de presionar una tecla
    $("#c_msg").keyup(function(e)
    {

        // obtenemos el texto que está escrito en el textarea
        var box = $(this).val();

        // calculamos el porcentaje entre el texto ingresado y el límite
        var value = (box.length *100) / limite;

        // obtenemos cuántos caracteres quedan
        var resta = limite - box.length;

        // si aún no se llegó al límite
        if(box.length <= limite)
        {

            // modificamos el texto que muestra la cantidad de caracteres que restan
            $('#divContador').html(resta);

            // modificamos el ancho de la barra
            $('#divProgreso').animate({
                "width": value+'%',
            }, 1);

            // si no se llegó al 50%, hacemos que la barra sea de color verde
            if (value < 50) {
                $('#divProgreso').removeClass();
                $('#divProgreso').addClass('verde');
            }
            else if (value < 85) { // si no se llegó al 85% que sea amarilla
                $('#divProgreso').removeClass();
                $('#divProgreso').addClass('amarillo');
            }
            else { // si se superó el 85% que sea roja
                $('#divProgreso').removeClass();
                $('#divProgreso').addClass('rojo');
            };
        }
        else // si se llegó al límite no permitimos ingresar más caracteres
        {
            // evitamos que ingrese más caracteres
            e.preventDefault();
        }               
    });
});