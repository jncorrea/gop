<?php 
    extract($_POST);
	include("../static/clase_mysql.php");
	include("../static/site_config.php");
	$miconexion = new clase_mysql;
	$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
	$lista="";
	for ($i=1; $i <count($_POST); $i++) {
			$lista[$i-1]=array_values($_POST)[$i];
	}
	$sql = $miconexion->sql_ingresar($_POST['bd'],$lista);
    $miconexion->consulta($sql);
    echo '<script>alert("Grupo Creado")</script>';
    echo "<script>location.href='../perfiles/perfil.php'</script>";
?>