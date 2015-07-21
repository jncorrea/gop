<?php 
    extract($_POST);
	include("../static/clase_mysql.php");
	include("../static/site_config.php");

	$bd= $_POST['bd'];
	$miconexion = new clase_mysql;
	$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
	$lista="";
	$list;
	for ($i=0; $i <count($_POST)-2; $i++) {
			$lista[$i]=array_values($_POST)[$i];
	}	
    $sql=$miconexion->sql_ingresar($bd,$lista);
    $insert;
    if($miconexion->consulta($sql)){
    	$miconexion->consulta("select MAX(id_partido) AS id FROM partidos");
    	$id=$miconexion->consulta_lista();
    	$miconexion->consulta("select email FROM grupos_miembros where id_grupo='".array_values($_POST)[0]."'");
    	for ($i=0; $i < $miconexion->numregistros(); $i++) { 
    		$list=$miconexion->consulta_lista();
    		if ($list[0]==$_POST['email']) {
    			$insert[$i]="insert into convocatoria values ('','".$list[0]."','".$id[0]."','','','1')";
    		}else{
    			$insert[$i]="insert into convocatoria values ('','".$list[0]."','".$id[0]."','','','0')";
    		}
    	}
    	
    	for ($i=0; $i < count($insert); $i++) { 
    		//echo $insert[$i];
    		$miconexion->consulta($insert[$i]);
    	}
    	echo ' <script language="javascript">alert ("Su Partido ha sido creado con \u00e9xito");</script> ';
		echo "<script>location.href='../perfiles/perfil.php?op=alineacion&id=$id[0]'</script>";
	}else{
		echo ' <script language="javascript">alert("No se ha podido crear el partido, Intente nuevamente");</script> ';
	}
?>