<?php
	//comprobamos que sea una petición ajax
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{
    extract($_POST);	
	@$bd = $_POST['bd'];
	include("../static/clase_mysql.php");
	include("../static/site_config.php");	
	@$miconexion = new clase_mysql;
	@$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
	$fecha_nac="";
	// ok 
	if ($bd=='usuarios') {
		for ($i=1; $i <count($_POST); $i++) {		
			if ($i<=4) {
				@$list[$i-1] = utf8_decode(array_values($_POST)[$i]);
			    @$columnas[$i-1]= array_keys($_POST)[$i];  
			}
			if ($i>4 and $i<8) {
				$fecha_nac=array_values($_POST)[$i]."/".$fecha_nac;			
			}
			if ($i>=8) {
				@$list[$i-3] = utf8_decode(array_values($_POST)[$i]);
			    @$columnas[$i-3]= array_keys($_POST)[$i];		    
			}		
		}
		$fecha_nac=date("Y-m-d",strtotime($fecha_nac));
		
		@$list[4]=$fecha_nac;
		@$columnas[4]= array_keys($_POST)[5];
	}else if ($bd=='centros_deportivos'){
		for ($i=1; $i <count($_POST); $i++) {
			@$list[$i-1] = utf8_decode(array_values($_POST)[$i]);
		    @$columnas[$i-1]= array_keys($_POST)[$i];
		}
	}else{
		for ($i=1; $i <count($_POST); $i++) {
			if ($i==5) {	    
			    @$list[$i-1]=date("Y-m-d",strtotime(array_values($_POST)[$i]));
			    @$columnas[$i-1]= array_keys($_POST)[$i];
			}else{
				@$list[$i-1] = utf8_decode(array_values($_POST)[$i]);
			    @$columnas[$i-1]= array_keys($_POST)[$i];
			}			
		}
	}
	if ($bd=='usuarios') {
		@$carpeta = "../perfiles/images/".$list[0];
		@$nom_img = "/user.";
		@$nombre_archivo = $_FILES['avatar']['name'];
		@$tipo_archivo = $_FILES['avatar']['type'];
		@$input_img = $_FILES['avatar']['tmp_name'];
	}elseif($bd=='grupos'){
		@$carpeta = "../perfiles/images/grupos/".$list[0];
		@$nom_img = "/logo.";
		@$nombre_archivo = $_FILES['logo']['name'];
		@$tipo_archivo = $_FILES['logo']['type'];
		@$input_img = $_FILES['logo']['tmp_name'];
	}else if($bd=='centros_deportivos'){
		@$carpeta = "../perfiles/images/centros/".$list[0];
		@$nom_img = "/centro.";
		@$nombre_archivo = $_FILES['foto_centro']['name'];
		@$tipo_archivo = $_FILES['foto_centro']['type'];
		@$input_img = $_FILES['foto_centro']['tmp_name'];
	}
	@$tipo = split('image/', $tipo_archivo);	
	if (@$nombre_archivo == "") {
		$sql=$miconexion->sql_actualizar($bd,$list,$columnas);
	    if($miconexion->consulta($sql)){
	    	echo '<script>
				$container = $("#container_notify_ok").notify();	
				create("default", { title:" Notificaci&oacute;n", text:"Se ha guardado con &eacute;xito"}); 
				$("#col_perfil").load("configurar.php");
	    	</script>';
	    }else{
	    	echo '<script>
				$container = $("#container_notify_bad").notify();	
				create("default", { title:"Alerta", text:"Error al Actualizar <br> Por favor intente nuevamente."}); 
	    	</script>';
	    }
	}else{
		if ((strpos($tipo_archivo, "gif") || strpos($tipo_archivo, "jpeg") || strpos($tipo_archivo, "jpg") || strpos($tipo_archivo, "png"))) {			
			
			if ($bd=='usuarios') {
				$list[count($_POST)-3] = $nom_img.$tipo[1];
				$columnas[count($_POST)-3] = array_keys($_FILES)[0];
			}else{
				$list[count($_POST)-1] = $nom_img.$tipo[1];
				$columnas[count($_POST)-1] = array_keys($_FILES)[0];
			}
			
			if (!file_exists($carpeta)) {
			    mkdir($carpeta, 0777);
			}
			if (move_uploaded_file($input_img,$carpeta.$nom_img.$tipo[1])){  
			    $sql=$miconexion->sql_actualizar($bd,$list,$columnas);
			    if($miconexion->consulta($sql)){
			    	echo '<script>
			    			document.location.href = document.location.href;
			    		 </script>';			    	
			    }else{
			    	echo '<script>
						$container = $("#container_notify_bad").notify();	
						create("default", { title:" Alerta", text:"Error al Actualizar <br> Por favor intente nuevamente."}); 
			    	</script>';
			    }
		    }else{ 
		        echo '<script>
						$container = $("#container_notify_bad").notify();	
						create("default", { title:" Alerta", text:"Error al Actualizar <br> Por favor intente nuevamente."}); 
			    	</script>';
		    }
		}else{
			echo '<script>
					$container = $("#container_notify_bad").notify();	
					create("default", { title:" Alerta", text:"La imagen debe tener alguna de las siguientes extensiones: <br> .gif .jpg .png .jpeg <br> Por favor intente nuevamente."}); 
		    	</script>';
		}
	}
}else{
    throw new Exception("Error Processing Request", 1);   
}
?>