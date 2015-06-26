<?php 
    extract($_GET);
    
	include("../static/clase_mysql.php");
	include("../static/site_config.php");
	$miconexion = new clase_mysql;
	$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
	$nick = $_POST["grupo"];
	$miconexion->consulta("select nombre_grupo from grupos where nombre_grupo=".$nick);
	if( $miconexion->numregistros() > 0)
        echo 0;
    else
        echo 1;
?>