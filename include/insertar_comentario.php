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
	$sql=$miconexion->sql_ingresar($_POST['bd'],$lista);
    
    if($miconexion->consulta($sql)){
    	echo '<script>
			$container = $("#container_notify_ok").notify();	
			create("default", { title:" Notificaci&oacute;n", text:"Comentario Publicado con &eacute;xito"}); 
    	</script>';
    }else{
    	echo '<script>
			$container = $("#container_notify_bad").notify();	
			create("default", { title:" Notificaci&oacute;n", text:"Error al Publicar Comentario <br> Por favor intente nuevamente."}); 
    	</script>';
    }
    
   ?>