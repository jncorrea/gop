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
	if($bd=='1'){
		@$bd="centros_deportivos";
		@$nom_img = "/centro.";
		@$nombre_archivo = $_FILES['foto_centro']['name'];
		@$tipo_archivo = $_FILES['foto_centro']['type'];
		@$input_img = $_FILES['foto_centro']['tmp_name'];
		$x=0;
		for ($i=1; $i <=count($_POST); $i++) {
			if ($i==1) {	    
			    @$list[$x]=$_SESSION['id'];
			    @$columnas[$x]= 'id_user';
			    $x++;
			}else{
				@$list[$x] = utf8_decode(array_values($_POST)[$i-1]);
			    @$columnas[$x]= array_keys($_POST)[$i-1];
			    $x++;
			}	
		}
		@$tipo = split('image/', $tipo_archivo);
		if ($_POST['centro_deportivo']=='' || $_POST['tiempo_alquiler']=='' || $_POST['num_jugadores']=='') {
			echo '<script> 
					$container = $("#container_notify").notify();  
            		create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"* Campos requeridos", imagen:"../assets/img/alert.png"}); 
		    	</script>';
		}else{	
			if (@$nombre_archivo == "") {
				$sql=$miconexion->ingresar_sql($bd,$columnas,$list);
				if($miconexion->consulta($sql)){
					$miconexion->consulta("select id_centro from centros_deportivos where centro_deportivo = '".$list[1]."'");
					$id_centro = $miconexion->consulta_lista();
			    	echo '<script>
						$container = $("#container_notify").notify();    
            			create("default", { color:"background:rgba(16,122,43,0.8);", enlace:"#" ,title:"Notificaci&oacute;n", text:"Genial, has ingresado un centro deportivo", imagen:"../assets/img/check.png"}); 
						location.href = "perfil.php?op=canchas&x=horario&id='.$id_centro[0].'";
			    	</script>';
			    }else{
			    	echo '<script>
						$container = $("#container_notify").notify();  
            			create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Error al guardar <br> Por favor intente nuevamente.", imagen:"../assets/img/alert.png"}); 
			    	</script>';
			    }
			}else{
				if ((strpos($tipo_archivo, "gif") || strpos($tipo_archivo, "jpeg") || strpos($tipo_archivo, "jpg") || strpos($tipo_archivo, "png"))) {			
					$list[count($_POST)] = $nom_img.$tipo[1];
					$columnas[count($_POST)] = array_keys($_FILES)[0];
					$sql=$miconexion->ingresar_sql($bd,$columnas,$list);
				    if($miconexion->consulta($sql)){
						$miconexion->consulta("select id_centro from centros_deportivos where centro_deportivo = '".$list[1]."'");
						$id_centro = $miconexion->consulta_lista();
						@$carpeta = "../perfiles/images/centros/".$id_centro[0];
						if (!file_exists($carpeta)) {
						    mkdir($carpeta, 0777);
						}
						if (move_uploaded_file($input_img,$carpeta.$nom_img.$tipo[1])){  
					    }else{ 
					        echo '<script> 
								$container = $("#container_notify").notify();  
            					create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Error al guardar <br> Por favor intente nuevamente.", imagen:"../assets/img/alert.png"}); 
						    	</script>';
					    }
				    	echo '<script>
				    			location.href = "perfil.php?op=canchas&x=horario&id='.$id_centro[0].'";
				    		 </script>';			    	
				    }else{
				    	echo '<script>
							$container = $("#container_notify").notify();  
            				create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Error al guardar <br> Por favor intente nuevamente.", imagen:"../assets/img/alert.png"}); 
				    	</script>';
				    }
				}else{
					echo '<script>
							$container = $("#container_notify").notify();  
            				create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"La imagen debe tener alguna de las siguientes extensiones: <br> .gif .jpg .png .jpeg <br> Por favor intente nuevamente.", imagen:"../assets/img/alert.png"}); 
				    	</script>';
				}
			}
		}
	}else if($bd=='2'){
		$bd="horarios_centros";
		$x=0;
		for ($i=1; $i <count($_POST)-1; $i++) {
			if ($i==1) {	    
			    @$list[$x]=array_values($_POST)[$i];
			    @$columnas[$x]= 'id_centro';
			    $x++;
			}else{
				if ($_POST['todos']==1) { 
					if ($i==2) {
						@$list[$x] = "Todos";
					}else{
						@$list[$x] = utf8_decode(array_values($_POST)[$i+1]);
					}
					    @$columnas[$x]= array_keys($_POST)[$i+1];
					    $x++;
				}else{
					@$list[$x] = utf8_decode(array_values($_POST)[$i]);
				    @$columnas[$x]= array_keys($_POST)[$i];
					if ($i == count($_POST)-2) {
						@$list[$x+1] = utf8_decode(array_values($_POST)[$i+1]);
				    	@$columnas[$x+1]= array_keys($_POST)[$i+1];
					}
				    $x++;
				}
			}	
		}
		$sql=$miconexion->ingresar_sql($bd,$columnas,$list);
		if ($miconexion->consulta($sql)) {
			echo '<script>
					$container = $("#container_notify").notify();    
            		create("default", { color:"background:rgba(16,122,43,0.8);", enlace:"#" ,title:"Notificaci&oacute;n", text:"Se ha guardado con &eacute;xito tu horario de atenci&oacute;n", imagen:"../assets/img/check.png"}); 
		    		$("#col_tabla_horario").load("tabla_horario.php?id='.$list[0].'");
		    		document.getElementById("horaIni").value = "";
		    		document.getElementById("horaFin").value = "";	
					horario();
		    	</script>';
		}else {
			echo '<script>
				$container = $("#container_notify").notify();  
            	create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Error al guardar <br>Por favor intente nuevamente", imagen:"../assets/img/alert.png"}); 
	    	</script>';
		}
		
	}else if($bd='3'){
		$bd="horarios_centros";
		for ($i=2; $i < count($_POST); $i++) { 
			@$list[$i-2]=array_values($_POST)[$i];
			@$columnas[$i-2]= array_keys($_POST)[$i];
		}
		$sql=$miconexion->sql_actualizar($bd,$list,$columnas);
		if ($miconexion->consulta($sql)) {
			echo '<script>
					$("#col_tabla_horario").load("tabla_horario.php?id='.$_POST['centro'].'");
					$container = $("#container_notify").notify();    
            		create("default", { color:"background:rgba(16,122,43,0.8);", enlace:"#" ,title:"Notificaci&oacute;n", text:"Se ha modificado el horario", imagen:"../assets/img/check.png"}); 
		    	</script>';
		}else{
			echo '<script>
				$container = $("#container_notify").notify();  
            	create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Error al editar horario <br>Por favor intente nuevamente", imagen:"../assets/img/alert.png"}); 
	    	</script>';
		}
	}
}else{
    throw new Exception("Error Processing Request", 1);   
}
?>