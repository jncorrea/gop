<?php
include("../static/site_config.php"); 
include ("../static/clase_mysql.php");
$miconexion = new clase_mysql;
$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
session_start();

if($_SESSION['email']){	
   	$miconexion->consulta("update miembros set estado=0 where email = '".$_SESSION['email']."'");  
	session_destroy();
	header("location:../index.php");
}
else{
	header("location:../index.php");
}
?>