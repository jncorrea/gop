<?php
include("../static/site_config.php");
include("../static/clase_mysql.php");
$miconexion = new clase_mysql;
$miconexion->conectar($db_name,$db_host, $db_user,$db_password);


//Recibimos los datos enviados desde el formulario
$email= $_POST['user'];
$password= $_POST['pass'];
$password_registrada=md5($password);


if(isset($email)){

	//Inicio de variables de sesión
	session_start();
	$_SESSION["ultimoAcceso"]= date("Y-n-j H:i:s");
	//Consultar si los datos son están guardados en la base de datos
	//$consulta= "SELECT * FROM miembros WHERE pass='$password_registrada' AND (email='$email' OR user='$email')"; 
	
	$miconexion->consulta("SELECT * FROM miembros WHERE pass='$password_registrada' AND (email='$email' OR user='$email')");
    $fila = $miconexion->consulta_lista();

	//$resultado= mysql_query($consulta,$miconexion->conectar($db_name,$db_host, $db_user,$db_password)) or die (mysql_error());
	//$fila=mysql_fetch_array($resultado);
	
	//OPCIÓN 1: Si el usuario NO existe o los datos son INCORRRECTOS
	// si el user i ngresado es igual a EMAIL o USER
	$mensaje=1;

	$cont = $miconexion->numregistros();
	
	if ($cont==0) {
		echo "Usuario o Contrase&ntilde;a Inv&aacute;lido";
		echo "<script>document.getElementById('formulario_login').reset();</script>";
	}else{
		//Definimos las variables de sesión y redirigimos a la página de usuario
		$_SESSION['email'] = $fila[0];
		$_SESSION['user'] = $fila[2];
		if($miconexion->consulta("update miembros set estado=1 where email = '".$_SESSION['email']."'")){
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