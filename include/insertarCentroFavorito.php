<?php 
    extract($_POST);
    date_default_timezone_set('America/Guayaquil');
	include("../static/clase_mysql.php");
	include("../static/site_config.php");
	$miconexion = new clase_mysql;
	$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
	session_start();

	$lista="";
	for ($i=0; $i <count($_POST); $i++) {
			$lista[$i]=utf8_decode(array_values($_POST)[$i]);
			

	}
	
	$miconexion->consulta("select id_centro from centros_deportivos where (centro_deportivo = '".array_values($_POST)[0]."' )");
	$flag=$miconexion->consulta_lista();

	if ($flag>0) {
			if($miconexion->consulta("insert into centros_favoritos values ('','".array_values($_POST)[1]."','".$_SESSION["id"]."')")){
	    echo '<script>
	        
	        document.getElementById("centro_favorito").onclick = function() {
	          actualizar_notificacion("9","'.array_values($_POST)[1].'","'.$_SESSION["id"].'");
	        };
	        $container = $("#container_notify").notify();    
            create("default", { color:"background:rgba(16,122,43,0.8);", enlace:"#" ,title:"Notificaci&oacute;n", text:"Haz indicado el centro <br> deportivo como favorito.", imagen:"../assets/img/check.png"});
	        $("#col_perfil").load("configurar.php?opcion=favoritos");
	        
	        </script>';
	    }else{
	        echo '<script> 
	        $container = $("#container_notify").notify();  
            create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Por favor Seleccione un centro", imagen:"../assets/img/alert.png"}); 
	        </script>';
	    }

	}else{
		echo '<script>
				$container = $("#container_notify").notify();  
            	create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Por favor Seleccione un centro", imagen:"../assets/img/alert.png"}); 
	    	</script>';
	}

	

	
	

	
?>

