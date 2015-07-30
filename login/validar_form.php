<?php

function validatePassword1($password1){
	//NO tiene minimo de 5 caracteres o mas de 12 caracteres
	if(strlen($password1) < 5 || strlen($password1) > 12)
		return false;
	// SI longitud, NO VALIDO numeros y letras
	else if(!preg_match("/^[0-9a-zA-Z]+$/", $password1))
		return false;
	// SI rellenado, SI email valido
	else
		return true;
}

function validateUsuario($usuario){
	//NO tiene minimo de 5 caracteres o mas de 12 caracteres
	if(!preg_match("/^[0-9a-zA-Z]+$/", $usuario))
		return false;
	// SI longitud, SI caracteres A-z
	else
		return true;
}

function validatePassword2($password1, $password2){
	//NO coinciden
	if($password1 != $password2)
		return false;
	else
		return true;
}

function validateEmail($email){
	//NO hay nada escrito
	if(strlen($email) == 0)
		return false;
	// SI escrito, NO VALIDO email
	else if(!filter_var($_POST['email'], FILTER_SANITIZE_EMAIL))
		return false;
	// SI rellenado, SI email valido
	else
		return true;
}

//Comprobacion de datos
//variables valores por defecto

$password1 = "";
$password2 = "";
$email = "";
$emailValue = "";


error_reporting(0);
extract($_POST); //extraer todos los valores del metodo post del formulario de ingresar


$pass1= $_POST['password1'];
$user= $_POST['email'];
$n_user= $_POST['usuario'];
//echo "valor de usuario".$n_user;
//almaceno en un array los valores recogidos del formulario
$informacion = array($pass1, $pass2, $user);

//Validacion de datos enviados
if(isset($_POST['send'])){
	
	if(!validatePassword1($_POST['password1'])){		
		$password1 = "error";
		echo '<script>alert("Por favor, ingrese una contraseña válida");</script> ';
	}
	if(!validatePassword2($_POST['password1'], $_POST['password2'])){
		$password2 = "error";
		echo '<script>alert("Las contraseñas deben ser iguales");</script> ';
	}
	if(!validateEmail($_POST['email'])){
		$email = "error";
		echo '<script>alert("Por favor, ingrese datos correctos");</script> ';
	}
	if(!validateUsuario($_POST['usuario'])){
		$usuario = "error";
		echo '<script>alert("El usuario debe contener solo letras y números");</script> ';
	}
	
	
	//Guardamos valores para que no tenga que reescribirlos	
	$emailValue = $_POST['email'];
	
	//Comprobamos si todo ha ido bien
	if($password1 != "error" && $password2 != "error" && $email != "error" && $usuario != "error"){
		$status = 1;
		$password_encriptada=md5($pass1);
		echo "valor de password encriptada ".$password_encriptada;
		header("Location: include/insertar.php?user=$user&pass1=$password_encriptada&nombre=$n_user");
	}

}
?>