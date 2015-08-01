<?php 
    extract($_POST);
	include("../static/clase_mysql.php");
	include("../static/site_config.php");

	$bd= $_POST['bd'];


	$miconexion = new clase_mysql;
	$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
	$lista="";
	for ($i=0; $i <count($_POST)-1; $i++) {
			$lista[$i]=array_values($_POST)[$i];
	}
	
    $sql=$miconexion->sql_ingresar($bd,$lista);
	if($miconexion->consulta($sql)){
		echo '<script>alert("Cancha registrada.!");</script> ';
		header("Location: ../perfiles/perfil.php?op=canchas");
    }else{
		echo '<script>alert("Ups.! Algo ocurri&oacute;.. Por favor intente nuevamente");</script>';
		header("Location: ../perfiles/perfil.php?op=canchas");

    }  

?>