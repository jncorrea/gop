<?php 
    extract($_POST);
	include("../static/clase_mysql.php");
	include("../static/site_config.php");
	session_start();
	$admin=$_SESSION['id'];
	$bd= $_POST['bd'];

	$miconexion = new clase_mysql;
	$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
	$val="";
	$col="";
	$val[0]=$admin;
	$col[0]="id_user";
	for ($i=1; $i <= count($_POST)-1; $i++) {
			$col[$i]=array_keys($_POST)[$i-1];			
	}
	for ($i=1; $i <= count($_POST)-1; $i++) {
			$val[$i]=array_values($_POST)[$i-1];			
	}
   	$sql=$miconexion->ingresar_sql($bd,$col,$val);
   	if($miconexion->consulta($sql)){
		echo '<script>
            location.href = "perfil.php?op=canchas";
            $container = $("#container_notify_ok").notify();    
            create("default", { title:" Notificaci&oacute;n", text:"Partido Creado con &eacute;xito"});
            </script>';
	}else{
		echo '<script>
            $container = $("#container_notify_bad").notify();   
            create("default", { title:"Alerta", text:"Error al Crear el Cancha <br> Por favor intente nuevamente."}); 
        </script>';
	}
?>