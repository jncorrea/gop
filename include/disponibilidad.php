<?php 	
	$fecha = $_POST['b'];
	$id_centro = $_POST['c'];
	$datos;
	include("../static/clase_mysql.php");
	include("../static/site_config.php");
	$miconexion = new clase_mysql;
	$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
	if($miconexion->consulta("select hora_inicio, hora_fin, tiempo_alquiler FROM centros_deportivos where id_centro ='$id_centro'")){
		$horario=$miconexion->consulta_lista();		
	}
	$miconexion->consulta("select hora_partido FROM partidos where fecha_partido = '$fecha' and id_centro ='$id_centro'");
    if ($miconexion->numregistros()!=0) {
	    for ($i=0; $i < $miconexion->numregistros(); $i++) { 
			$disponibles=$miconexion->consulta_lista();
			$Hora = strtotime($disponibles[0]) + (60 *60 * $horario[2]);   
			$dato = "".date('H:i:s',$Hora);
	    	if ($i==0) {
	    		$datos="[['".$disponibles[0]."','".$dato."'";
	    	}else{
	    		$datos=$datos."],['".$disponibles[0]."','".$dato."'";
	    	}
	    }    	
	    $datos = $datos."]]";
		echo "<script>
		$('#timeformatExample').timepicker('option', {'timeFormat': 'H:i:s',
			  	'minTime': '$horario[0]',
			    'maxTime': '$horario[1]',
		    'disableTimeRanges': ".$datos."});
		</script>";
    }else{
    	echo "<script>
			$('#timeformatExample').timepicker('option', {'timeFormat': 'H:i:s',
			  	'minTime': '$horario[0]',
			    'maxTime': '$horario[1]',
				'disableTimeRanges': [['00:00:00'],['00:00:00']]});
			</script>";
    }
?>

