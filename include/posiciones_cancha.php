<?php 
extract($_POST);
	include("../static/clase_mysql.php");
	include("../static/site_config.php");
	$miconexion = new clase_mysql;
	$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
	$lista;
	$valores;
	$columnas;
	global $sql;
	for ($i=1; $i <count($_POST); $i++) {
		$lista[$i-1] = array_values($_POST)[$i];
	}
	$x=0;
	for ($j=0; $j < count($lista); $j=$j+2) { 
		$valores[$x] = $lista[$j];
	}
	$x=0;	
	for ($j=1; $j < count($lista); $j=$j+2) { 
		$valores[$x] =  $lista[$j];
	}
	for ($i=0; $i < count($valores); $i++) { 
		if ($valores[$i]=="undefined"){
		}else{
			$sql[$i] = "update convocatoria set posicion='".$valores[$i]."' where email ='".$columnas[$i]."' and id_partido ='".array_values($_POST)[0]."'";
		}
	}
	for ($i=0; $i < count($sql); $i++) { 
		echo $sql[$i];
	}

 ?>