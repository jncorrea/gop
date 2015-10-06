<?php 
    extract($_POST);
    session_start();
	include("../static/clase_mysql.php");
	include("../static/site_config.php");
	$miconexion = new clase_mysql;
	$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
	use Snipe\BanBuilder\CensorWords;
	include ("..\static\CensorWords.php");
	$censor = new CensorWords;
	$langs = array('es','en-us','en-uk');
	$badwords = $censor->setDictionary($langs);
	$lista="";
	for ($i=1; $i <count($_POST); $i++) {
		$lista[$i-1]=htmlspecialchars(array_values($_POST)[$i]);			
		$columnas[$i-1]=array_keys($_POST)[$i];		
	}
	$comen = $censor->censorString($lista[count($lista)-1]);
	$lista[count($lista)-1]= $comen['clean'];
	$miconexion->consulta("select count(*) from comentarios WHERE id_user = '".$_SESSION['id']."' and image IS NOT NULL");
	$num = $miconexion->consulta_lista();
	@$carpeta = "../perfiles/images/comentarios";
	@$nom_img = "/".$_SESSION['user']."_".$num[0].".";
	@$nombre_archivo = $_FILES['image']['name'];
	@$tipo_archivo = $_FILES['image']['type'];
	@$input_img = $_FILES['image']['tmp_name'];

	@$tipo = split('image/', $tipo_archivo);
	if ($_POST['comentario']==null) {
			echo '<script>
		    		$container = $("#container_notify").notify();  
		            create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Primero debe escribir algo.", imagen:"../assets/img/alert.png"}); 
		    	</script>';
	}else{	
		if (@$nombre_archivo == "") {
			$sql=$miconexion->ingresar_sql($_POST['bd'],$columnas,$lista);
			if (@$_POST['id_partido']<>"") {
				$miconexion->consulta("select a.id_user from partidos p, alineacion a where p.id_partido = a.id_partido and p.id_partido='".$_POST['id_partido']."' and a.id_user != '".$_POST['id_user']."'");
				$count = $miconexion->numregistros();
				for ($i=0; $i < $count; $i++) { 
					$user=$miconexion->consulta_lista();
					@$inserts[$i]= "insert into notificaciones (id_user, id_partido, fecha_not, visto, responsable, tipo, mensaje) values('".$user[0]."','".$_POST['id_partido']."','".$_POST['fecha_publicacion']."','0','".$_POST['id_user']."','comentario','ha comentado en el partido')";
				}
				for ($i=0; $i < $count; $i++) { 
					$miconexion->consulta($inserts[$i]);
				}
			}
			if (@$_POST['id_grupo']<>"") {
				$miconexion->consulta("select id_user from user_grupo where id_grupo='".$_POST['id_grupo']."' and id_user <> '".$_POST['id_user']."'");
				$count = $miconexion->numregistros();
				for ($i=0; $i < $count; $i++) { 
					$user=$miconexion->consulta_lista();
					@$inserts[$i]="insert into notificaciones (id_user, id_grupo, fecha_not, visto, responsable, tipo, mensaje) values('".$user[0]."','".$_POST['id_grupo']."','".$_POST['fecha_publicacion']."','0','".$_POST['id_user']."','comentario','ha comentado en el grupo')";
				}
				for ($i=0; $i < $count; $i++) { 
					$miconexion->consulta($inserts[$i]);
				}
			}
		    
		    if($miconexion->consulta($sql)){
		    	$miconexion->consulta("update grupos set ultima_modificacion= '".@$_POST['fecha_publicacion']."' where id_grupo='".@$_POST['id_grupo']."'");
		    	echo '<script>
					document.getElementById("text_comentario").value = "";
					$.get("../datos/cargarDatos.php");
					$.get("../datos/cargarNotificaciones.php");
					send(1);
		    	</script>';
		    }else{
		    	echo '<script>
		    		$container = $("#container_notify").notify();  
		            create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Error al Publicar Comentario <br> Por favor intente nuevamente.", imagen:"../assets/img/alert.png"}); 
		    	</script>';
		    }		
		}else{
			if ((strpos($tipo_archivo, "gif") || strpos($tipo_archivo, "jpeg") || strpos($tipo_archivo, "jpg") || strpos($tipo_archivo, "png"))) {			
				$lista[count($_POST)-1] = "images/comentarios".$nom_img.$tipo[1];
				$columnas[count($_POST)-1] = array_keys($_FILES)[0];
				if (!file_exists($carpeta)) {
				    mkdir($carpeta, 0777);
				}
				if (move_uploaded_file($input_img,$carpeta.$nom_img.$tipo[1])){  
				    $sql=$miconexion->ingresar_sql($_POST['bd'],$columnas,$lista);
					if (@$_POST['id_partido']<>"") {
						$miconexion->consulta("select a.id_user from partidos p, alineacion a where p.id_partido = a.id_partido and p.id_partido='".$_POST['id_partido']."' and a.id_user != '".$_POST['id_user']."'");
						$count = $miconexion->numregistros();
						for ($i=0; $i < $count; $i++) { 
							$user=$miconexion->consulta_lista();
							@$inserts[$i]= "insert into notificaciones (id_user, id_partido, fecha_not, visto, responsable, tipo, mensaje) values('".$user[0]."','".$_POST['id_partido']."','".$_POST['fecha_publicacion']."','0','".$_POST['id_user']."','comentario','ha comentado en el partido')";
						}
						for ($i=0; $i < $count; $i++) { 
							$miconexion->consulta($inserts[$i]);
						}
					}
					if (@$_POST['id_grupo']<>"") {
						$miconexion->consulta("select id_user from user_grupo where id_grupo='".$_POST['id_grupo']."' and id_user <> '".$_POST['id_user']."'");
						$count = $miconexion->numregistros();
						for ($i=0; $i < $count; $i++) { 
							$user=$miconexion->consulta_lista();
							@$inserts[$i]="insert into notificaciones (id_user, id_grupo, fecha_not, visto, responsable, tipo, mensaje) values('".$user[0]."','".$_POST['id_grupo']."','".$_POST['fecha_publicacion']."','0','".$_POST['id_user']."','comentario','ha comentado en el grupo')";
						}
						for ($i=0; $i < $count; $i++) { 
							$miconexion->consulta($inserts[$i]);
						}
					}
				    
				    if($miconexion->consulta($sql)){
				    	$miconexion->consulta("update grupos set ultima_modificacion= '".@$_POST['fecha_publicacion']."' where id_grupo='".@$_POST['id_grupo']."'");
				    	echo '<script>
							document.getElementById("text_comentario").value = "";
							location.href = location.href;
							$.get("../datos/cargarDatos.php");
							$.get("../datos/cargarNotificaciones.php");
				    	</script>';
				    }else{
				    	echo '<script>
				    		$container = $("#container_notify").notify();  
				            create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Error al Publicar Comentario <br> Por favor intente nuevamente.", imagen:"../assets/img/alert.png"}); 
				    	</script>';
				    }		
			    }else{ 
			        echo '<script>
							$container = $("#container_notify").notify();  
	            	create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Error al Publicar Comentario <br> Por favor intente nuevamente.", imagen:"../assets/img/alert.png"}); 
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
    
?>