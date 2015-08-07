<?php 
    extract($_POST);
	include("../static/clase_mysql.php");
	include("../static/site_config.php");
	@$bd= $_POST['bd'];
	@$miconexion = new clase_mysql;
	@$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
	@$lista="";
	for ($i=0; $i <count($_POST)-1; $i++) {
			$lista[$i]=utf8_decode(array_values($_POST)[$i]);
			$columnas[$i]= array_keys($_POST)[$i];
	}
    $sql=$miconexion->sql_actualizar($bd,$lista,$columnas);
    //echo "SQL: ".$sql;
    if($miconexion->consulta($sql)){
	    echo '<script>
            $container = $("#container_notify_ok").notify();    
            create("default", { title:" Notificaci&oacute;n", text:"Cancha se ha modificado con &eacute;xito"});
			$("#col_cancha").load("perfil.php?op=canchas&id=<?php echo $lista[0]; ?>");

        </script>';
	}else{
		echo '<script>
            $container = $("#container_notify_bad").notify();   
            create("default", { title:" Notificaci&oacute;n", text:"Error al Modificar Cancha <br> Por favor intente nuevamente."}); 
        </script>';
	}
?>