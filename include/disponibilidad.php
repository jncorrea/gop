<?php 	
	if ($_POST['op']=="1") {
		$dia = $_POST['dia'];
		$centro = $_POST['centro'];
		include("../static/clase_mysql.php");
		include("../static/site_config.php");
		$miconexion = new clase_mysql;
		$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
		if ($dia == 'Todos') {
			$miconexion->consulta("select hora_inicio, hora_fin FROM horarios_centros where id_centro ='$centro'");
		}else{
			$miconexion->consulta("select hora_inicio, hora_fin FROM horarios_centros where (dia = '$dia' OR dia = 'Todos') and id_centro ='$centro'");
		}
	    if ($miconexion->numregistros()!=0) {
		    for ($i=0; $i < $miconexion->numregistros(); $i++) { 
				$disponibles=$miconexion->consulta_lista();
		    	if ($i==0) {
		    		$datos="[['".$disponibles[0]."','".$disponibles[1]."'";
		    	}else{
		    		$datos=$datos."],['".$disponibles[0]."','".$disponibles[1]."'";
		    	}
		    }    	
		    $datos = $datos."]]";
			echo "<script>
			$('#horaIni').timepicker('option', {'timeFormat': 'H:i:s',
			    'disableTimeRanges': ".$datos."});
			$('#horaFin').timepicker('option', {'timeFormat': 'H:i:s',
			    'disableTimeRanges': ".$datos."});
			</script>";
	    }else{
	    	echo "<script>
				$('#horaIni').timepicker('option', {'timeFormat': 'H:i:s',
					'disableTimeRanges': [['00:00:00'],['00:00:00']]});
				$('#horaFin').timepicker('option', {'timeFormat': 'H:i:s',
									'disableTimeRanges': [['00:00:00'],['00:00:00']]});
				</script>";
	    }
	}elseif ($_POST['op']=="2") {
		$dia = $_POST['dia'];
		$centro = $_POST['centro'];
		include("../static/clase_mysql.php");
		include("../static/site_config.php");
		$miconexion = new clase_mysql;
		$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
		if ($dia == 'Todos') {
			$miconexion->consulta("select hora_inicio, hora_fin FROM horarios_centros where id_centro ='$centro'");
		}else{
			$miconexion->consulta("select hora_inicio, hora_fin FROM horarios_centros where (dia = '$dia' OR dia = 'Todos') and id_centro ='$centro' and id_horario!=".$_POST['id_horario']);
		}
	    if ($miconexion->numregistros()!=0) {
		    for ($i=0; $i < $miconexion->numregistros(); $i++) { 
				$disponibles=$miconexion->consulta_lista();
		    	if ($i==0) {
		    		$datos="[['".$disponibles[0]."','".$disponibles[1]."'";
		    	}else{
		    		$datos=$datos."],['".$disponibles[0]."','".$disponibles[1]."'";
		    	}
		    }    	
		    $datos = $datos."]]";
			echo "<script>
			$('#horaIniEdit').timepicker('option', {'timeFormat': 'H:i:s',
			    'disableTimeRanges': ".$datos."});
			$('#horaFinEdit').timepicker('option', {'timeFormat': 'H:i:s',
			    'disableTimeRanges': ".$datos."});
			</script>";
	    }else{
	    	echo "<script>
				$('#horaIniEdit').timepicker('option', {'timeFormat': 'H:i:s',
					'disableTimeRanges': [['00:00:00'],['00:00:00']]});
				$('#horaFinEdit').timepicker('option', {'timeFormat': 'H:i:s',
									'disableTimeRanges': [['00:00:00'],['00:00:00']]});
				</script>";
	    }	
	}
?>
