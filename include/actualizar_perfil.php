<?php
	//comprobamos que sea una petición ajax
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{
    extract($_POST);
	@$nombre_archivo = $_FILES['avatar']['name'];
	@$tipo_archivo = $_FILES['avatar']['type']; 
    $bd="usuarios";
    $num= (count($_POST)+1);
	include("../static/clase_mysql.php");
	include("../static/site_config.php");	
	$tipo = split('image/', $tipo_archivo);
	$miconexion = new clase_mysql;
	$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
	for ($i=0; $i <count($_POST); $i++) {
		if ($i==4) {	    
		    @$list[$i]=date("Y-m-d",strtotime(array_values($_POST)[$i]));
		    @$columnas[$i]= array_keys($_POST)[$i];
		}else{
			@$list[$i] = utf8_decode(array_values($_POST)[$i]);
		    @$columnas[$i]= array_keys($_POST)[$i];
		}
	}
	if (@$_FILES['avatar']['name'] == "") {
		$sql=$miconexion->sql_actualizar($bd,$list,$columnas);
	    if($miconexion->consulta($sql)){
	    	echo '<script>
				$container = $("#container_notify_ok").notify();	
				create("default", { title:" Notificaci&oacute;n", text:"Perfil modificado con &eacute;xito"}); 
				$("#col_perfil").load("configurar.php");
	    	</script>';
	    }else{
	    	echo '<script>
				$container = $("#container_notify_bad").notify();	
				create("default", { title:"Alerta", text:"Error al Actualizar el Perfil <br> Por favor intente nuevamente."}); 
	    	</script>';
	    }
	}else{
		if ((strpos($tipo_archivo, "gif") || strpos($tipo_archivo, "jpeg") || strpos($tipo_archivo, "jpg") || strpos($tipo_archivo, "png"))) {			
			$list[count($_POST)] = "user.".$tipo[1];
			$columnas[count($_POST)] = array_keys($_FILES)[0];
			$carpeta = "../perfiles/images/".$list[0];
			if (!file_exists($carpeta)) {
			    mkdir($carpeta, 0777);
			}
			if (move_uploaded_file($_FILES['avatar']['tmp_name'],"../perfiles/images/".$list[0]."/user.".$tipo[1])){  
			    $sql=$miconexion->sql_actualizar($bd,$list,$columnas);
			    if($miconexion->consulta($sql)){
			    	echo '<script>
				    		$container = $("#container_notify_ok").notify();	
							create("default", { title:" Notificaci&oacute;n", text:"Perfil modificado con &eacute;xito"});
			    			document.location.href = document.location.href;
			    		 </script>';			    	
			    }else{
			    	echo '<script>
						$container = $("#container_notify_bad").notify();	
						create("default", { title:" Notificaci&oacute;n", text:"Error al Actualizar el Perfil <br> Por favor intente nuevamente."}); 
			    	</script>';
			    }
		    }else{ 
		        echo '<script>
						$container = $("#container_notify_bad").notify();	
						create("default", { title:" Notificaci&oacute;n", text:"Error al Actualizar el Perfil <br> Por favor intente nuevamente."}); 
			    	</script>';
		    }
		}else{
			echo '<script>
					$container = $("#container_notify_bad").notify();	
					create("default", { title:" Notificaci&oacute;n", text:"Su avatar debe tener alguna de las siguientes extensiones: <br> .gif .jpg .png .jpeg <br> Por favor intente nuevamente."}); 
		    	</script>';
		}
	}
}else{
    throw new Exception("Error Processing Request", 1);   
}
?>