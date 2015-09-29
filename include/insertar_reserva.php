<?php 
	extract($_POST);
    date_default_timezone_set('America/Guayaquil'); 
	include("../static/clase_mysql.php");
	include("../static/site_config.php");
	@$miconexion = new clase_mysql;
	@$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
    session_start();
    global $bd;
    $bd="reservas";
    switch ($_POST['op']) {
    	case '1':    		
    		for ($i=1; $i <count($_POST); $i++) {
				$val[$i-1]=utf8_decode(array_values($_POST)[$i]);            
		        $col[$i-1]=array_keys($_POST)[$i];
		    }	
		    $sql = 'select count(*) from partidos where id_centro="'.$_POST['id_centro'].'" and estado_partido != 0 and FECHA_PARTIDO = "'.$_POST['fecha_reserva'].'" and 
            ((("'.$_POST['hora_inicio'].'" >= hora_partido and  "'.$_POST['hora_inicio'].'" < hora_fin) and ("'.$_POST['hora_fin'].'"  > hora_partido and "'.$_POST['hora_fin'].'"  >= hora_fin)) 
            or (("'.$_POST['hora_inicio'].'" <= hora_partido and  "'.$_POST['hora_inicio'].'" > hora_fin) and ("'.$_POST['hora_fin'].'" > hora_partido and "'.$_POST['hora_fin'].'"  <= hora_fin)) 
            or (hora_partido > "'.$_POST['hora_inicio'].'" AND hora_partido < "'.$_POST['hora_fin'].'" ))';
            if($miconexion->consulta($sql)){	
            	$compr=$miconexion->consulta_lista();
                if ($compr[0]=="0") {  
                	$sql = 'select count(*) from reservas where id_centro="'.$_POST['id_centro'].'" and fecha_reserva = "'.$_POST['fecha_reserva'].'" and 
		            ((("'.$_POST['hora_inicio'].'" >= hora_inicio and  "'.$_POST['hora_inicio'].'" < hora_fin) and ("'.$_POST['hora_fin'].'"  > hora_inicio and "'.$_POST['hora_fin'].'"  >= hora_fin)) 
		            or (("'.$_POST['hora_inicio'].'" <= hora_inicio and  "'.$_POST['hora_inicio'].'" > hora_fin) and ("'.$_POST['hora_fin'].'" > hora_inicio and "'.$_POST['hora_fin'].'"  <= hora_fin)) 
		            or (hora_inicio > "'.$_POST['hora_inicio'].'" AND hora_inicio < "'.$_POST['hora_fin'].'" ))';
		            if($miconexion->consulta($sql)){	
		            	$compr=$miconexion->consulta_lista();
		                if ($compr[0]=="0") {   
						    $col[count($col)]="estado";
						    $val[count($val)]="1";	    
						    $sql=$miconexion->ingresar_sql($bd,$col,$val);
				            if($miconexion->consulta($sql)){                
				                echo '<script>
				                	calendario_centro();
        							$("#cerrar_crear_reserva").trigger("click");
				                    $container = $("#container_notify").notify();  
				                    create("default", { color:"background:rgba(16,122,43,0.8);", enlace:"#" ,title:"Notificaci&oacute;n", text:"Reserva creada.", imagen:"../assets/img/check.png"});
				                </script>';                
				            }else{
				                echo '<script>
				                    $container = $("#container_notify").notify();  
				                    create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Ocurrio algo, por favor intente nuevamente.", imagen:"../assets/img/alert.png"}); 
				                </script>';
				        	}
				    	}else{
                			echo "<script>leer_horarios(); document.getElementById('error').innerHTML = 'Lo sentimos, este horario ya no se ecuentra disponible, por favor revisa el calendario e intetalo nuevamente.';</script>";
				    	}
				    }else{
				    	echo '<script>
	                    $container = $("#container_notify").notify();  
	                    create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Ocurrio algo, por favor intente nuevamente.", imagen:"../assets/img/alert.png"}); 
	                </script>';
				    }
		        }else{
                	echo "<script>leer_horarios(); document.getElementById('error').innerHTML = 'Lo sentimos, este horario ya no se ecuentra disponible, por favor revisa el calendario e intetalo nuevamente.';</script>";
		        }
	        }else{
	        	echo '<script>
	                    $container = $("#container_notify").notify();  
	                    create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Ocurrio algo, por favor intente nuevamente.", imagen:"../assets/img/alert.png"}); 
	                </script>';
            }
    	break;

    	case '2':
    		$x=0;
			$dia = $_POST['dia'];
			$fechaIni = date("Y-m-d", strtotime($_POST['fecha_reserva']));
			$fechaFin = date("Y-m-d", strtotime($_POST['fecha_fin']));
			for ($i=$fechaIni; $i <= $fechaFin; $i = date('Y-m-d', strtotime("$i + 1 day"))) {
				if (date("w", strtotime($i)) == $dia) {				 	
	                $inserts[$x] = "insert into reservas (id_centro, fecha_reserva, hora_inicio, hora_fin, motivo, estado) values ('".$_POST['id_centro']."','".$i."','".$_POST['hora_inicio']."','".$_POST['hora_fin']."','".$_POST['motivo']."','1')";
					$x++;
				} 
			}
			$x=0;
			for ($i=0; $i < count($inserts) ; $i++) { 
				if ($miconexion->consulta($inserts[$i])) {
					$x++;
				}				
			}
			if ($x>0) {
				echo '<script>
                    $container = $("#container_notify").notify();  
                    create("default", { color:"background:rgba(16,122,43,0.8);", enlace:"#" ,title:"Notificaci&oacute;n", text:"Reservas creadas.", imagen:"../assets/img/check.png"});
                </script>';  
			}
    		break;
    	
    	default:
    		
    		break;
    }
?>