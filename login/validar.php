
<?php


include("../static/site_config.php");
include("../static/clase_mysql.php");
$miconexion = new clase_mysql;
$miconexion->conectar($db_name,$db_host, $db_user,$db_password);


//Recibimos los datos enviados desde el formulario
$email= $_POST['user'];
$password= $_POST['pass'];


if(isset($email)){

	
	//Inicio de variables de sesión
	  session_start();
	
	//Consultar si los datos son están guardados en la base de datos
	$consulta= "SELECT * FROM miembros WHERE email='$email' AND pass='$password'"; 
	$resultado= mysql_query($consulta,$miconexion->conectar($db_name,$db_host, $db_user,$db_password)) or die (mysql_error());
	$fila=mysql_fetch_array($resultado);
	
	//OPCIÓN 1: Si el usuario NO existe o los datos son INCORRRECTOS
	$mensaje=1;
	if (!$fila['EMAIL']){ 

		
		/*echo "<p>Los datos introducidos no son correctos</p>";
		echo "<script>location.href='../login.php#myModal1'</script>";

		echo ' <script language="javascript">alert("Por favor, Ingrese usuario y contraseña");</script> ';
*/
		header("Location: ../index.php?mensaje=$mensaje");
	}
	//OPCIÓN 2: Usuario logueado correctamente
	else{
		//Definimos las variables de sesión y redirigimos a la página de usuario
		$_SESSION['email'] = $fila['EMAIL'];
		$_SESSION['usuario'] = $fila['NOMBRES'];
	
		header("Location: ../perfiles/perfil.php");

		}
}
else{
	header("location: ../login.php#myModal");
	echo "<script>location.href='../index.php#myModal1'</script>";

		echo ' <script language="javascript">alert("Por favor, Ingrese usuario y contraseña");</script> ';

		  	
}




		


?>