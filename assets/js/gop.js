$(document).ready(main);
 	 
function main(){
	$('.navbar-inverse .navbar-nav li').click(function(){
		$('li').removeClass("active");
		$('.icon').remove();
		$(this).addClass("active");
		$('li.active a').append("<div class='icon'></div>");
	});
	//variables globales
	var searchBoxes = $(".text");
	var inputusuario = $("#usuario");
	var requsuario = $("#req-usuario");
	var inputPassword1 = $("#password1");
	var reqPassword1 = $("#req-password1");
	var inputPassword2 = $("#password2");
	var reqPassword2 = $("#req-password2");
	var inputEmail = $("#email");
	var reqEmail = $("#req-email");

	//funciones de validacion
	function validateusuario(){
		//NO cumple longitud minima
		if(inputusuario.val().length < 4){
			requsuario.addClass("error");
			inputusuario.addClass("error");
			return false;
		}
		//SI longitud pero NO solo caracteres A-z
		else if(!inputusuario.val().match(/^[0-9a-zA-Z]+$/)){
			requsuario.addClass("error");
			inputusuario.addClass("error");
			return false;
		}
		// SI longitud, SI caracteres A-z
		else{
			requsuario.removeClass("error");
			inputusuario.removeClass("error");
			return true;
		}
	}
	function validatePassword1(){
		//NO tiene minimo de 5 caracteres o mas de 12 caracteres
		if(inputPassword1.val().length < 5 || inputPassword1.val().length > 14){
			reqPassword1.addClass("error");
			inputPassword1.addClass("error");
			return false;
		}
		// SI longitud, NO VALIDO numeros y letras
		
		// SI rellenado, SI email valido
		else{
			reqPassword1.removeClass("error");
			inputPassword1.removeClass("error");
			return true;
		}
	}
	function validatePassword2(){
		//NO son iguales las password
		if(inputPassword1.val() != inputPassword2.val()){
			reqPassword2.addClass("error");
			inputPassword2.addClass("error");
			return false;
		}
		// SI son iguales
		else{
			reqPassword2.removeClass("error");
			inputPassword2.removeClass("error");
			return true;
		}
	}
	function validateEmail(){
		//NO hay nada escrito
		if(inputEmail.val().length == 0){
			reqEmail.addClass("error");
			inputEmail.addClass("error");
			return false;
		}
		// SI escrito, NO VALIDO email
		else if(!inputEmail.val().match(/^[^\s()<>@,;:\/]+@\w[\w\.-]+\.[a-z]{2,}$/i)){
			reqEmail.addClass("error");
			inputEmail.addClass("error");
			return false;
		}
		// SI rellenado, SI email valido
		else{
			reqEmail.removeClass("error");
			inputEmail.removeClass("error");
			return true;
		}
	}

	
	//controlamos la validacion en los distintos eventos
	// Perdida de foco
	inputusuario.blur(validateusuario);
	inputEmail.blur(validateEmail);
	inputPassword1.blur(validatePassword1);  
	inputPassword2.blur(validatePassword2); 
	
	// Pulsacion de tecla
	inputusuario.keyup(validateusuario);
	inputPassword1.keyup(validatePassword1);
	inputPassword2.keyup(validatePassword2);
	
	// Envio de formulario
	$("#form1").submit(function(){
		if(validateusuario() & validatePassword1() & validatePassword2() & validateEmail())
			return true;
		else
			return false;
	});
	
	//controlamos el foco / perdida de foco para los input text
	searchBoxes.focus(function(){
		$(this).addClass("active");
	});
	searchBoxes.blur(function(){
		$(this).removeClass("active");  
	});
};

function cerrar(){
	$('#signup').click(function(){
    	$('#login-page').modal('show');
    	$('#myModal').modal('hide');
    });
    $('#change').click(function(){
    	$('#changePass').modal('show');
    	$('#myModal').modal('hide');
    });
    return false;
};



