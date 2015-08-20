<?php
	//comprobamos que sea una petición ajax
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{
    extract($_POST);	
	@$bd = $_POST['bd'];
    @$num= (count($_POST)+1);
    session_start();
	include("../static/clase_mysql.php");
	include("../static/site_config.php");	
	@$miconexion = new clase_mysql;
	@$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
	for ($i=1; $i <=count($_POST); $i++) {
		@$list[$i-1] = utf8_decode(array_values($_POST)[$i]);
	    @$columnas[$i-1]= array_keys($_POST)[$i];
	}
	if($bd=='centros_deportivos'){
		@$carpeta = "../perfiles/images/centros/".$list[0];
		@$nom_img = "/centro.";
		@$nombre_archivo = $_FILES['foto_centro']['name'];
		@$tipo_archivo = $_FILES['foto_centro']['type'];
		@$input_img = $_FILES['foto_centro']['tmp_name'];
	}
	@$tipo = split('image/', $tipo_archivo);	
	if (@$nombre_archivo == "") {
		$sql=$miconexion->sql_actualizar($bd,$list,$columnas);
		echo '<script>
				$container = $("#container_notify_ok").notify();	
				create("default", { title:" Notificaci&oacute;n", text:"'.$sql.'<br> '.count($list).'"}); 
	    	</script>';
		/*if($miconexion->consulta($sql)){
	    	echo '<script>
				$container = $("#container_notify_ok").notify();	
				create("default", { title:" Notificaci&oacute;n", text:"Su centro deportivo se ha modificado con &eacute;xito"}); 
				document.location.href = "perfil.php?op=canchas&id='.$list[0].'";
	    	</script>';
	    }else{
	    	echo '<script>
				$container = $("#container_notify_bad").notify();	
				create("default", { title:"Alerta", text:"Error al guardar <br> Por favor intente nuevamente. 1"}); 
	    	</script>';
	    }*/
	}else{
		if ((strpos($tipo_archivo, "gif") || strpos($tipo_archivo, "jpeg") || strpos($tipo_archivo, "jpg") || strpos($tipo_archivo, "png"))) {			
			$list[count($_POST)] = $nom_img.$tipo[1];
			$columnas[count($_POST)] = array_keys($_FILES)[0];
			$sql=$miconexion->sql_actualizar($bd,$list,$columnas);
		    if($miconexion->consulta($sql)){
				if (!file_exists($carpeta)) {
				    mkdir($carpeta, 0777);
				}
				if (move_uploaded_file($input_img,$carpeta.$nom_img.$tipo[1])){  
			    }else{ 
			        echo '<script>
							$container = $("#container_notify_bad").notify();	
							create("default", { title:"Alerta", text:"Error al guardar <br> Por favor intente nuevamente. 2"}); 
				    	</script>';
			    }
		    	echo '<script>
		    			document.location.href = "perfil.php?op=canchas&id='.$list[0].'";
		    		 </script>';			    	
		    }else{
		    	echo '<script>
					$container = $("#container_notify_bad").notify();	
					create("default", { title:"Alerta", text:"Error al guardar <br> Por favor intente nuevamente. 3"}); 
		    	</script>';
		    }
		}else{
			echo '<script>
					$container = $("#container_notify_bad").notify();	
					create("default", { title:"Alerta", text:"La imagen debe tener alguna de las siguientes extensiones: <br> .gif .jpg .png .jpeg <br> Por favor intente nuevamente."}); 
		    	</script>';
		}
	}
}else{
    throw new Exception("Error Processing Request", 1);   
}
?>