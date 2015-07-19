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
			$columnas[$i]= array_keys($_POST)[$i];
	}
    $sql=$miconexion->sql_actualizar1($bd,$lista,$columnas);
    if($miconexion->consulta($sql)){
		echo ' <script language="javascript">alert ("Su Partido ha sido modificado \u00e9xito");</script> ';
		echo "<script>location.href='../perfiles/perfil.php?op=editar_evento&id=$lista[0]'</script>";
	}else{
		echo ' <script language="javascript">alert("No se ha podido modificar el partido, Intente nuevamente");</script> ';
		echo "<script>location.href='../perfiles/perfil.php?op=editar_evento&id=$lista[0]'</script>";

	}
?>