<?php 
extract($_POST);
	include("../static/clase_mysql.php");
	include("../static/site_config.php");
	$miconexion = new clase_mysql;
	$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
	$lista="";
	for ($i=0; $i <count($_POST); $i++) {
			echo array_values($_POST)[$i];
			echo array_keys($_POST)[$i];
	}

 ?>