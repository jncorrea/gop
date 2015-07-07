<?php 
    extract($_POST);
	include("../static/clase_mysql.php");
	include("../static/site_config.php");
	$bd= $_POST['bd'];
	$miconexion = new clase_mysql;
	$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
	$lista="";

	for ($i=0; $i <4; $i++) {
			$lista[$i]=array_values($_POST)[$i];
			$columnas[$i]= array_keys($_POST)[$i];
	}
	if (@!$_POST['estado']) {
		//echo "no existe";
		$lista[4]=0;
		$columnas[4]='estado';
		# code...
	}else{
		//echo "si existe";
		$lista[4]=1;
		$columnas[4]='estado';

	}
	
	for ($i=5; $i <9; $i++) {
			$lista[$i]=array_values($_POST)[$i-1];
			$columnas[$i]= array_keys($_POST)[$i-1];
	}
	if (@$_POST['estado']) {
		//echo "no existe";
		$lista[9]=array_values($_POST)[8];
			$columnas[9]= array_keys($_POST)[8];
		# code...
	}


    $sql=$miconexion->sql_actualizar1($bd,$lista,$columnas);
   // echo "valor de sql".$sql;
    if($miconexion->consulta($sql)){
		echo ' <script language="javascript">alert ("Su Partido ha sido modificado \u00e9xito");</script> ';
		echo "<script>location.href='../perfiles/perfil.php'</script>";
	}else{
		echo ' <script language="javascript">alert("No se ha podido modificar el partido, Intente nuevamente");</script> ';
		//echo "<script>location.href='../perfiles/perfil.php?op=eventos'</script>";

	}
?>