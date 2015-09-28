<?php
include("../static/site_config.php");
include("../static/clase_mysql.php");
date_default_timezone_set('America/Guayaquil');
$miconexion = new clase_mysql;
$miconexion->conectar($db_name,$db_host, $db_user,$db_password);


//Recibimos los datos enviados desde el formulario
$email= $_POST['user'];
$password= $_POST['pass'];
$password_registrada=md5($password);


if(isset($email)){

	//Inicio de variables de sesión
	session_start();
	$_SESSION["ultimoAcceso"]= date("Y-m-d H:i:s", time());
	//Consultar si los datos son están guardados en la base de datos

	$miconexion->consulta("SELECT * FROM usuarios WHERE pass='$password_registrada' AND (email='$email' OR user='$email')");
    $fila = $miconexion->consulta_lista();

	//OPCIÓN 1: Si el usuario NO existe o los datos son INCORRRECTOS
	// si el user i ngresado es igual a EMAIL o USER
	$mensaje=1;

	$cont = $miconexion->numregistros();
	
	if ($cont==0) {
		echo "Usuario o Contrase&ntilde;a Inv&aacute;lido";
		echo "<script>document.getElementById('formulario_login').reset();</script>";
	}else{
		//Definimos las variables de sesión y redirigimos a la página de usuario
		$_SESSION['id'] = $fila[0];
		$_SESSION['email'] = $fila[1];
		$_SESSION['user'] = $fila[3];
		$_SESSION['logeado'] = 'SI';
		if($miconexion->consulta("update usuarios set estado=1, acceso = '".date("Y-m-d H:i:s", time())."' where id_user = '".$_SESSION['id']."'")){
		  	echo "<script> location.href='perfiles/perfil.php' </script>";			
		}else{
			echo "Ocurrio un error al iniciar Sesi&oacute;n";
		}
	}
}else{
	echo "Usuario o Contrase&ntilde;a Inv&aacute;lido"; 
	echo "<script>document.getElementById('formulario_login').reset();</script>";	
}

?>