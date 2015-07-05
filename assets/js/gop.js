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
	var inputUsername = $("#username");
	var reqUsername = $("#req-username");
	var inputPassword1 = $("#password1");
	var reqPassword1 = $("#req-password1");
	var inputPassword2 = $("#password2");
	var reqPassword2 = $("#req-password2");
	var inputEmail = $("#email");
	var reqEmail = $("#req-email");

	//funciones de validacion
	function validateUsername(){
		//NO cumple longitud minima
		if(inputUsername.val().length < 4){
			reqUsername.addClass("error");
			inputUsername.addClass("error");
			return false;
		}
		//SI longitud pero NO solo caracteres A-z
		else if(!inputUsername.val().match(/^[a-zA-Z]+$/)){
			reqUsername.addClass("error");
			inputUsername.addClass("error");
			return false;
		}
		// SI longitud, SI caracteres A-z
		else{
			reqUsername.removeClass("error");
			inputUsername.removeClass("error");
			return true;
		}
	}
	function validatePassword1(){
		//NO tiene minimo de 5 caracteres o mas de 12 caracteres
		if(inputPassword1.val().length < 5 || inputPassword1.val().length > 12){
			reqPassword1.addClass("error");
			inputPassword1.addClass("error");
			return false;
		}
		// SI longitud, NO VALIDO numeros y letras
		else if(!inputPassword1.val().match(/^[0-9a-zA-Z]+$/)){
			reqPassword1.addClass("error");
			inputPassword1.addClass("error");
			return false;
		}
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
	inputUsername.blur(validateUsername);
	inputEmail.blur(validateEmail);
	inputPassword1.blur(validatePassword1);  
	inputPassword2.blur(validatePassword2);  
	
	// Pulsacion de tecla
	inputUsername.keyup(validateUsername);
	inputPassword1.keyup(validatePassword1);
	inputPassword2.keyup(validatePassword2);
	
	// Envio de formulario
	$("#form1").submit(function(){
		if(validateUsername() & validatePassword1() & validatePassword2() & validateEmail())
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

function initialize() {
	var myLatlng = new google.maps.LatLng(-2.524406, -78.929772);
	var mapOptions = {
		zoom: 7,
		center: myLatlng,
		styles: [{"stylers":[{"hue":"#ff1a00"},{"invert_lightness":true},{"saturation":-100},{"lightness":33},{"gamma":0.5}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#2D333C"}]}]
	}
	var map = new google.maps.Map(document.getElementById('map'), mapOptions);
	//var marcador = new google.maps.LatLng({{a.latitud}}, {{a.longitud}});
	var marcador = new google.maps.LatLng(-2.845979, -79.154102);
	var marker = new google.maps.Marker({
		position: marcador,
		map: map,
		title: 'cancha',
		icon:'assets/img/google.png'
	});
	google.maps.event.addListener(marker, 'click', function(){
        var popup = new google.maps.InfoWindow();
        popup.setContent(note);
        popup.open(map, this);
	})
}
google.maps.event.addDomListener(window, 'load', initialize);

function cerrar(){
	$('#signup').click(function(){
    	$('#login-page').modal('show');
    	$('#myModal').modal('hide');
    	return false;
    });
};

