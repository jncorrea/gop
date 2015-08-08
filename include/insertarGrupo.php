<?php 
    extract($_POST);
	include("../static/clase_mysql.php");
	include("../static/site_config.php");
	$miconexion = new clase_mysql;
	$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
	$lista="";
	for ($i=1; $i <count($_POST); $i++) {
			$lista[$i-1]=utf8_decode(array_values($_POST)[$i]);
	}
	$sql = $miconexion->sql_ingresar($_POST['bd'],$lista);
    if ($miconexion->consulta($sql)) {
	echo '<script>
			$container = $("#container_notify_ok").notify();	
			create("default", { title:" Notificaci&oacute;n", text:"Grupo Creado con &eacute;xito <br> Miralo en tus Grupos.."});
    	</script>';
    }else{
    	echo '<script>
			$container = $("#container_notify_bad").notify();	
			create("default", { title:"Alerta", text:"Error al Crear el Grupo <br> Por favor intente nuevamente."}); 
    	</script>';
    }
    $miconexion->consulta("select id_grupo from grupos where nombre_grupo='$lista[0]'");
    $grupo=$miconexion->consulta_lista();
    if ($miconexion->consulta("insert into grupos_miembros values('".$lista[1]."','".$grupo[0]."','1')")) {
	echo '<script>
			$("#menu_izquierdo").load("menu.php");
    		location = "perfil.php?op=grupos&id='.$grupo[0].'";
    	</script>';
    }
?>