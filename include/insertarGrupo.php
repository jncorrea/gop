<?php 
	session_start();
    extract($_POST);
	include("../static/clase_mysql.php");
	include("../static/site_config.php");
	$miconexion = new clase_mysql;
	$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
	$lista="";
	for ($i=1; $i <count($_POST); $i++) {
			$lista[$i-1]=utf8_decode(array_values($_POST)[$i]);
	}
	$lista[2]='';
	date_default_timezone_set('America/Guayaquil');
	$lista[3]=date("Y-m-d H:i:s", time());
	$lista[4]=date("Y-m-d H:i:s", time());
	$sql = $miconexion->sql_ingresar($_POST['bd'],$lista);
    if ($miconexion->consulta($sql)) {
	echo '<script>
			$container = $("#container_notify").notify();    
            create("default", { color:"background:rgba(16,122,43,0.8);", enlace:"#" ,title:"Notificaci&oacute;n", text:"Grupo Creado con &eacute;xito <br> Miralo en tus Grupos.", imagen:"../assets/img/check.png"});
    	</script>';
    }else{
    	echo '<script>
			$container = $("#container_notify").notify();  
            create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Error al Crear el Grupo <br> Por favor intente nuevamente.", imagen:"../assets/img/alert.png"});  
    	</script>';
    }
    $miconexion->consulta("select id_grupo from grupos where nombre_grupo='$lista[1]'");
    $grupo=$miconexion->consulta_lista();
    if ($miconexion->consulta("insert into user_grupo values
								('', '".$grupo[0]."','".$_SESSION['id']."','".date("Y-m-d H:i:s", time())."','1')")) {
	echo '<script>
			$("#menu_izquierdo").load("menu.php");
    		location = "perfil.php?op=grupos&id='.$grupo[0].'";
    	</script>';
    }
?>