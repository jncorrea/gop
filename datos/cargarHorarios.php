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

	$miconexion->consulta("select * from horarios_centros where id_centro = '".$_POST['centro']."' and dia='".$fecha."' order by hora_inicio");
	//echo "select * from horarios_centros where id_centro = '".$_POST['centro']."' and dia='".$fecha."' order by hora_inicio";
	$response = array();
	$posts = array();
	
	for ($i=0; $i < $miconexion->numregistros(); $i++) { 
        $horarios=$miconexion->consulta_lista(); 
		//$fecha = preg_split("/[\s,]+/", $comentarios[4]);
		$posts[] = array('start'=> $horarios[3], 'end'=>$horarios[4], 'constraint' => 'availableForMeeting', 'overlap'=> false, 'rendering'=> 'background', 'color'=> '#CF0811');
	}
	$posts[]= array('title' => 'Meeting',
					'start' => '2015-09-18T08:00:00',
					'constraint' => 'availableForMeeting', // defined below
					'color' => '#257e4a');
	echo json_encode($posts);
?>