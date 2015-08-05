<?php 
extract($_POST);
	include("../static/clase_mysql.php");
	include("../static/site_config.php");
	$miconexion = new clase_mysql;
	$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
	$lista;
	$valores;
	$columnas;
	$cont;
	global $sql;
	for ($i=3; $i <count($_POST); $i++) {
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
			$sql[$i] = "update convocatoria set posicion='0', equipo='' where email ='".$columnas[$i]."' and id_partido ='".array_values($_POST)[0]."'";
		}else if(($valores[$i]>0&&$valores[$i]<5)||($valores[$i]>8&&$valores[$i]<13)||($valores[$i]>16&&$valores[$i]<21)||($valores[$i]>24&&$valores[$i]<29)||($valores[$i]>32&&$valores[$i]<37)) {			
			$sql[$i] = "update convocatoria set posicion='".$valores[$i]."', equipo='".array_values($_POST)[1]."' where email ='".$columnas[$i]."' and id_partido ='".array_values($_POST)[0]."'";
		}else{
			$sql[$i] = "update convocatoria set posicion='".$valores[$i]."', equipo='".array_values($_POST)[2]."' where email ='".$columnas[$i]."' and id_partido ='".array_values($_POST)[0]."'";
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
        echo '<script>
            $container = $("#container_notify_ok").notify();    
            create("default", { title:" Notificaci&oacute;n", text:"Se han Guardado los Cambios"});
            </script>';
    }else{
        echo '<script>
            $container = $("#container_notify_bad").notify();   
            create("default", { title:" Notificaci&oacute;n", text:"Error al Guardar <br> Por favor intente nuevamente."}); 
        </script>';
    }
 ?>