<?php 
    extract($_POST);
	include("../static/clase_mysql.php");
	include("../static/site_config.php");
	$miconexion = new clase_mysql;
	$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
	$lista="";
	for ($i=2; $i <count($_POST); $i++) {
			$lista[$i-2]=array_values($_POST)[$i];
	}
    $miconexion->consulta("insert into ".$_POST['bd']." values('".$lista[0]."','".$lista[1]."','0')");  
    echo '<script>alert("Usuario invitado")</script>';
    echo "<script>location.href='../perfiles/perfil.php?op=grupos&id=".$lista[1]."'</script>";
?>