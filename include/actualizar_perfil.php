<?php
	//comprobamos que sea una petición ajax
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{
    extract($_POST);	
	@$bd = $_POST['bd'];
	if (@$bd=='1') {
		@$bd="centros_deportivos";
	}
	include("../static/clase_mysql.php");
	include("../static/site_config.php");	
	@$miconexion = new clase_mysql;
	@$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
	$fecha_nac="";
	$c=count($_POST);
	$a="";
	$k=0;
	$estado_actual=0;
	
	if ($bd=='usuarios') {
		
		$c=count($_POST);
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

	
		for ($i=0; $i <$c ; $i++) { //se utiliza para guardar el estado en 0 cuando el usuario no ha seleccionado el check		
		if (array_keys($_POST)[$i]=="disponible") {
			$k=1;
		 }
		}
		if ($k==0) { //Significa que no se ha marcado la casilla de notificaciones por lo tanto no existe valor
			$estado_actual=1;
			$miconexion->consulta("update usuarios set disponible='0' where user = '".$list[1]."'");
			
		}
			

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
	$contt=0;
	$bandera=0;//esta variable se utiliza para validar cuando hayan cambios entre los dato guardados y la informacion que se guarda desde perfil
	if (@$bd == "usuarios") {
		$miconexion->consulta("select email, user, nombres, apellidos, nacimiento, sexo, posicion, celular, telefono, disponible from usuarios where user= '".$list[1]."'");
	}else if(@$bd == "üsuarios"){
		$miconexion->consulta("select *from centros_deportivos where id_centro= '".$list[0]."'");
	}
	
	$contt = $miconexion->numcampos();

	$info_registrada=$miconexion->consulta_lista();

	for ($i=0; $i <count($list); $i++) {
		if ($info_registrada[$i]!=($list[$i])) {
			$bandera++;
		}
	}
	if ($estado_actual==1 and $k==0 ) { //validamos si el estado de disponibilidad cambio de 1 a 0 la bandera se suma
		$bandera++;
	}
	
	    	
	if ($bd=='usuarios') {
		@$carpeta = "../perfiles/images/".$list[1];
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

		if ($bd=='usuarios') {
			$sql=$miconexion->sql_actualizar_perfil($bd,$list,$columnas);
		}else{
			$sql=$miconexion->sql_actualizar($bd,$list,$columnas);
		}
		
		if ($bandera>0) {
			if($miconexion->consulta($sql)){
		    	echo '<script>
					$container = $("#container_notify").notify();    
	            	create("default", { color:"background:rgba(16,122,43,0.8);", enlace:"#" ,title:"Notificaci&oacute;n", text:"Se ha guardado con &eacute;xito &#9786;", imagen:"../assets/img/check.png"});  
					$("#col_perfil").load("configurar.php");
		    	</script>';
		    	
		    }else{
		    	echo '<script>
					$container = $("#container_notify").notify();  
	            	create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Error al Actualizar <br> Por favor intente nuevamente.", imagen:"../assets/img/alert.png"}); 
		    	</script>';
		    }
		}else{
			// En este casl no actualizar
			echo '<script>
				$container = $("#container_notify").notify();  
            	create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"No hay datos para actualizar.", imagen:"../assets/img/alert.png"}); 
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

					if ($bd=='usuarios') {
						$sql=$miconexion->sql_actualizar_perfil($bd,$list,$columnas);
					}else{
						$sql=$miconexion->sql_actualizar($bd,$list,$columnas);
					}

			    if($miconexion->consulta($sql)){
			    	echo '<script>
			    			document.location.href = document.location.href;
			    		 </script>';			    	
			    }else{
			    	echo '<script>
						$container = $("#container_notify").notify();  
            	create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Error al Actualizar <br> Por favor intente nuevamente.", imagen:"../assets/img/alert.png"});
			    	</script>';
			    }
		    }else{ 
		        echo '<script>
						$container = $("#container_notify").notify();  
            	create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Error al Actualizar <br> Por favor intente nuevamente.", imagen:"../assets/img/alert.png"}); 
			    	</script>';
		    }
		}else{
			echo '<script>
					$container = $("#container_notify").notify();  
            		create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"La imagen debe tener alguna de las siguientes extensiones: <br> .gif .jpg .png .jpeg <br> Por favor intente nuevamente.", imagen:"../assets/img/alert.png"});
		    	</script>';
		}
	}
}else{
    throw new Exception("Error Processing Request", 1);   
}
?>