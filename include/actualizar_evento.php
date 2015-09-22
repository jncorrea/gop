<?php 
    extract($_POST);
    session_start();
	include("../static/clase_mysql.php");
	include("../static/site_config.php");
	@$bd= $_POST['bd'];
	@$miconexion = new clase_mysql;
	@$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
	@$lista="";
	for ($i=0; $i <count($_POST)-3; $i++) {
		$columnas[$i]= array_keys($_POST)[$i];
		if ($i == 3) {
        	$lista[$i]=date("Y-m-d",strtotime(array_values($_POST)[$i]));
        }else{
			$lista[$i]=utf8_decode(array_values($_POST)[$i]);            
        }
	}
	if ($_POST['cambios']!="") {
	    $sql=$miconexion->sql_actualizar($bd,$lista,$columnas);
	    if ($_POST['cambios']!="") {
		    $cambios = explode(",", $_POST['cambios']);
		    for ($i=0; $i < count($cambios); $i++) { 
		    	if ($cambios[$i]=="fecha_partido" || $cambios[$i]=="hora_partido") {
		    		$mensaje = "ha cambiado la fecha por ".$_POST['fecha_partido']." a las ".$_POST['hora_partido']." en el partido";
		    	}elseif ($cambios[$i]=="id_centro") {
		    		$miconexion->consulta("select centro_deportivo FROM centros_deportivos WHERE id_centro=".$_POST['id_centro']);
					$centro=$miconexion->consulta_lista();
		    		$mensaje = "ha cambiado el centro deportivo por ".$centro[0]." en el partido";
		    	}elseif($cambios[$i]=="estado_partido"){
		    		if ($_POST['estado_partido']==1) {
		    			$mensaje = "ha seleccionado la fecha ".$_POST['fecha_partido']." a las ".$_POST['hora_partido']." para jugarse el partido";
		    		}else{
		    			$mensaje = "ha cancelado el partido";
		    		}
		    	}elseif ($cambios[$i]=="descripcion_partido" || $cambios[$i]=="equipo_a" || $cambios[$i]=="equipo_b" || $cambios[$i]=="res_a" || $cambios[$i]=="res_b") {
		    		$mensaje = "ha realizado cambios en el partido";
		    	}
		    }
	    }
	    if($miconexion->consulta($sql)){
	    	$miconexion->consulta("select u.id_user FROM alineacion a, usuarios u WHERE a.id_user=u.id_user and a.id_partido = '".$_POST['id_partido']."' and a.estado_alineacion=1 and a.id_user != '".$_SESSION['id']."'");
			$count = $miconexion->numregistros();
			for ($i=0; $i < $count; $i++) { 
				$user=$miconexion->consulta_lista();
				$inserts[$i]="insert into notificaciones (id_user, id_partido, fecha_not, visto, responsable, tipo, mensaje) values('".$user[0]."','".$_POST['id_partido']."','".$_POST['fecha_actual']."','0','".$_SESSION['id']."','cambios','".$mensaje."')";
			}
			for ($i=0; $i < $count; $i++) { 
				$miconexion->consulta($inserts[$i]);
			}
	        echo '<script>
	        	$.get("../datos/cargarNotificaciones.php");
	            $container = $("#container_notify").notify();    
	            create("default", { color:"background:rgba(16,122,43,0.8);", enlace:"#" ,title:"Notificaci&oacute;n", text:"Partido Modificado con &eacute;xito", imagen:"../assets/img/check.png"}); 
	            document.location.href = document.location.href;
	        </script>';
		}else{
			echo '<script>
	            $container = $("#container_notify").notify();  
	            create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Ha ocurrido algo, por favor intente nuevamente", imagen:"../assets/img/alert.png"}); 
	        </script>';
		}
	}else{
		echo '<script>
	            $container = $("#container_notify").notify();  
	            create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"No existen cambios que realizar.", imagen:"../assets/img/alert.png"}); 
	        </script>';
	}
?>