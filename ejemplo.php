<?php
extract($_GET);





if (@$mensaje==1) {
	
	//echo ' jAlert("This is a custom alert box", "Alert Dialog");';
	//echo "<script>location.href='index.php'</script>";
}


?>

<html>
	<head>
		<script type="text/javascript" src="assets/lib/alertify.js"></script>
		<link rel="stylesheet" href="assets/themes/alertify.core.css" />
		<link rel="stylesheet" href="assets/themes/alertify.default.css" />
		<title>EJEMPLO - ALERTIFY.JS</title>



		<script>
		
			function alerta(){
				//un alert
				alertify.alert("<b>Por favor Iniciar Sesion, para continuar..", function () {
					location.href = 'index.php';
				});
			}
			
			
			
			function error(){
				alertify.error("<b>Por favor Iniciar Sesion, para continuar.."); 
				return false; 
			}
		</script>
	</head>
	<body>
		<p align="center">
			<br />
			<input type="button" value="Alerta" onClick="alerta()" /> <br />
			<input type="button" value="Notificacion error" onClick="error()" /><br /><br />
			<a href="http://blog.reaccionestudio.com/" target="_blank">BLOG REACCI&Oacute;N ESTUDIO</a>
		</p>

<?php

switch($_GET['mensaje']) {
case '1':

		echo "<script language='javascript'> alertify.alert('<b>Por favor Iniciar Sesion, para continuar..', function () {
					location.href = 'index.php';
				});
</script>";

    //echo '<script language="javascript">alert("Por favor, Ingrese un usuario y contraseña correctos");</script> ';
break;
					
	default:
	break;
	}

		?>
	</body>
</html>