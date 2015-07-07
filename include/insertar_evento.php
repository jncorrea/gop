<?php 
    extract($_POST);
	include("../static/clase_mysql.php");
	include("../static/site_config.php");

	$bd= $_POST['bd'];
	$miconexion = new clase_mysql;
	$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
	$lista="";
	for ($i=0; $i <count($_POST)-2; $i++) {
			$lista[$i]=array_values($_POST)[$i];	}
	
    $sql=$miconexion->sql_ingresar($bd,$lista);
    
    if($miconexion->consulta($sql)){
    	$miconexion->consulta("SELECT MAX(id_partido) AS id FROM partidos");
    	$id=$miconexion->consulta_lista();
    	$miconexion->consulta("insert into convocatoria values ('','".$_POST['email']."','".$id[0]."','','')");
    	echo ' <script language="javascript">alert ("Su Partido ha sido creado con \u00e9xito");</script> ';
		echo "<script>location.href='../perfiles/perfil.php'</script>";
	}else{
		echo ' <script language="javascript">alert("No se ha podido crear el partido, Intente nuevamente");</script> ';
	}
?>