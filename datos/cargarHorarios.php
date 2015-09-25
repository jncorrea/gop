<?php 
	include("../static/site_config.php"); 
	include ("../static/clase_mysql.php");
	$miconexion = new clase_mysql;
	$miconexion->conectar($db_name,$db_host, $db_user,$db_password); 
	///crear json para notificaciones de comentarios en grupos
	$fecha = date('l', strtotime(date('Y-m-d H:i:s', time() )));
	setlocale(LC_ALL,"es_ES@euro","es_ES","esp","es"); 
	$dias = array('','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
	$fecha = $dias[date('N', strtotime($fecha))];

	$asignacion = array('Domingo'=>"0",'Lunes'=>"1",'Martes'=>"2",'Miercoles'=>"3",'Jueves'=>"4",'Viernes'=>"5",'Sabado'=>"6");
	//echo "select * from horarios_centros where id_centro = '".$_POST['centro']."' and dia='".$fecha."' order by hora_inicio";
	$posts = array();
	//$miconexion->consulta("select * from horarios_centros where id_centro = '".$_POST['centro']."' and dia='".$fecha."' order by hora_inicio");
	$miconexion->consulta("select * from horarios_centros where id_centro = '".$_POST['centro']."' order by hora_inicio");
	for ($i=0; $i < $miconexion->numregistros(); $i++) { 
        $horarios=$miconexion->consulta_lista(); 
		//$fecha = preg_split("/[\s,]+/", $comentarios[4]);
		$posts[] = array('start'=> $horarios[3], 'end'=>$horarios[4], 'dow' => $asignacion[$horarios[2]], 'constraint' => 'availableForMeeting', 'overlap'=> false, 'rendering'=> 'background', 'color'=> '#D2383C');
	}
	$miconexion->consulta("select p.nombre_partido, p.fecha_partido, p.hora_partido, cd.tiempo_alquiler, p.estado_partido, p.id_partido, p.id_user from partidos p, centros_deportivos cd where p.id_centro = cd.id_centro and p.id_centro = '".$_POST['centro']."' order by p.fecha_partido");
	for ($i=0; $i < $miconexion->numregistros(); $i++) { 
        $reservas=$miconexion->consulta_lista(); 
        $Hora = strtotime($reservas[2]) + (60 *60 * $reservas[3]);   
		$dato = "".date('H:i:s',$Hora);
		//$fecha = preg_split("/[\s,]+/", $comentarios[4]);
		if ($reservas[4]=="1") {
			$posts[]= array('title' => $reservas[0],
							'start' => $reservas[1]."T".$reservas[2],
							'end' => $reservas[1]."T".$dato,
							'constraint' => 'availableForMeeting', // defined below
							'color' => '#4CAF50',
							'id' => $reservas[5],
							'user' => $reservas[6]);
		}else{
			/*$posts[]= array('title' => $reservas[0],
							'start' => $reservas[1]."T".$reservas[2],
							'end' => $reservas[1]."T".$dato,
							'constraint' => 'availableForMeeting', // defined below
							'color' => '#78909C',
							'id' => $reservas[5]);*/
		}
	}
	echo json_encode($posts);
?>