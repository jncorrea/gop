<?php 
    extract($_POST);
	include("../static/clase_mysql.php");
	include("../static/site_config.php");
	@$bd= $_POST['bd'];
	@$miconexion = new clase_mysql;
	@$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
	@$lista="";
	for ($i=0; $i <count($_POST)-1; $i++) {
		$columnas[$i]= array_keys($_POST)[$i];
		if ($i == 3) {
        	$lista[$i]=date("Y-m-d",strtotime(array_values($_POST)[$i]));
        }else{
			$lista[$i]=utf8_decode(array_values($_POST)[$i]);            
        }
	}
    $sql=$miconexion->sql_actualizar1($bd,$lista,$columnas);
    if($miconexion->consulta($sql)){
	    echo '<script>
            $container = $("#container_notify_ok").notify();    
            create("default", { title:" Notificaci&oacute;n", text:"Partido Modificado con &eacute;xito"});
			$("#col_editar_evento").load("editar_evento.php?op=editar_evento&id=<?php echo $lista[0]; ?>");
        </script>';
	}else{
		echo '<script>
            $container = $("#container_notify_bad").notify();   
            create("default", { title:" Notificaci&oacute;n", text:"'.$sql.'"}); 
        </script>';
	}
?>