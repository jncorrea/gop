<?php 
extract($_POST);
	include("../static/clase_mysql.php");
	include("../static/site_config.php");
	$miconexion = new clase_mysql;
	$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
	session_start();
	$lista;
	$valores;
	$columnas;
	$cont;
	global $sql;
	for ($i=3; $i <count($_POST)-1; $i++) {
		$lista[$i-3] = array_values($_POST)[$i];
	}
	$x=0;
	for ($j=1; $j < count($lista); $j=$j+2) { 
		$valores[$x] = $lista[$j];
		$x++;
	}
	$x=0;	
	for ($j=0; $j < count($lista); $j=$j+2) { 
		$columnas[$x] =  $lista[$j];
		$x++;

	}
	for ($i=0; $i < count($valores); $i++) { 
		if ($valores[$i]=="undefined"){
			$sql[$i] = "update alineacion set posicion_event='0', equipo_event='' where id_user ='".$columnas[$i]."' and id_partido ='".array_values($_POST)[0]."'";
		}else if(($valores[$i]>0&&$valores[$i]<5)||($valores[$i]>8&&$valores[$i]<13)||($valores[$i]>16&&$valores[$i]<21)||($valores[$i]>24&&$valores[$i]<29)||($valores[$i]>32&&$valores[$i]<37)) {			
			$sql[$i] = "update alineacion set posicion_event='".$valores[$i]."', equipo_event='".array_values($_POST)[1]."' where id_user ='".$columnas[$i]."' and id_partido ='".array_values($_POST)[0]."'";
		}else{
			$sql[$i] = "update alineacion set posicion_event='".$valores[$i]."', equipo_event='".array_values($_POST)[2]."' where id_user ='".$columnas[$i]."' and id_partido ='".array_values($_POST)[0]."'";
		}
	}
	for ($i=0; $i < count($sql); $i++) { 
		if($miconexion->consulta($sql[$i])){
			$cont=1;
		}else{
			$cont=0;
		}
	}
	if ($cont==1) {
		$miconexion->consulta("select u.id_user FROM alineacion a, usuarios u WHERE a.id_user=u.id_user and a.id_partido = '".$_POST['id_partido']."' and a.estado_alineacion=1 and a.id_user != '".$_SESSION['id']."'");
		$count = $miconexion->numregistros();
		for ($i=0; $i < $count; $i++) { 
			$user=$miconexion->consulta_lista();
			@$inserts[$i]= "insert into notificaciones (id_user, id_partido, fecha_not, visto, responsable, tipo, mensaje) values('".$user[0]."','".$_POST['id_partido']."','".$_POST['fecha_actual']."','0','".$_SESSION['id']."','cambios',' ha realizado cambios en la alineación de')";
		}
		for ($i=0; $i < $count; $i++) { 
			$miconexion->consulta($inserts[$i]);
		}
        echo '<script>
        	$.get("../datos/cargarNotificaciones.php");
            $container = $("#container_notify").notify();    
            create("default", { color:"background:rgba(16,122,43,0.8);", enlace:"#" ,title:"Notificaci&oacute;n", text:"Se ha guardado la nueva alineaci&oacute;n", imagen:"../assets/img/check.png"}); 
            </script>';
    }else{
        echo '<script>
            $container = $("#container_notify").notify();  
            create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Error al Guardar <br> Por favor intente nuevamente.", imagen:"../assets/img/alert.png"});  
        </script>';
    }
 ?>