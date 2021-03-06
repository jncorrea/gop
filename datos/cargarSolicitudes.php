<?php 
	include("../static/site_config.php"); 
	include ("../static/clase_mysql.php");
	$miconexion = new clase_mysql;
	$miconexion->conectar($db_name,$db_host, $db_user,$db_password); 
	///crear json para notificaciones de comentarios en grupos
	$miconexion->consulta("select u.user, u.avatar, u.sexo, n.id_user, n.fecha_not, n.visto, n.id_grupo, g.nombre_grupo, n.mensaje, n.id_noti from notificaciones n, usuarios u, grupos g where n.responsable = u.id_user and n.tipo='solicitud' and n.id_grupo = g.id_grupo and n.id_user != n.responsable and n.id_grupo is not null");
	$response = array();
	$posts = array();
	for ($i=0; $i < $miconexion->numregistros(); $i++) { 
        $comentarios=$miconexion->consulta_lista(); 
		$fecha = preg_split("/[\s,]+/", $comentarios[4]);
		$posts[] = array('user'=> $comentarios[0], 'avatar'=> $comentarios[1], 'sexo'=> $comentarios[2], 'id_user'=> $comentarios[3], 'fecha_not'=> $fecha[0]."T".$fecha[1]."-0500", 'visto'=> $comentarios[5], 'id_grupo'=> $comentarios[6], 'nom_grupo'=> $comentarios[7], 'mensaje'=> $comentarios[8], 'id_noti'=>$comentarios[9]);
	}
	//$response['posts'] = $posts;

	$fp = fopen('not_solicitudesGrupos.json', 'w');
	fwrite($fp, json_encode($posts));
	fclose($fp);
	
	$miconexion->consulta("select u.user, u.avatar, u.sexo, n.id_user, n.fecha_not, n.visto, n.id_partido, p.nombre_partido, n.mensaje, n.id_noti from notificaciones n, usuarios u, partidos p where n.responsable = u.id_user and n.tipo='solicitud' and n.id_user != n.responsable and n.id_partido = p.id_partido and n.id_partido is not null");
	$response = array();
	$posts = array();
	for ($i=0; $i < $miconexion->numregistros(); $i++) { 
        $comentarios=$miconexion->consulta_lista(); 
        $fecha = preg_split("/[\s,]+/", $comentarios[4]);
		$posts[] = array('user'=> $comentarios[0], 'avatar'=> $comentarios[1], 'sexo'=> $comentarios[2], 'id_user'=> $comentarios[3], 'fecha_not'=> $fecha[0]."T".$fecha[1]."-0500", 'visto'=> $comentarios[5], 'id_partido'=> $comentarios[6], 'nom_partido'=> $comentarios[7], 'mensaje'=> $comentarios[8], 'id_noti'=>$comentarios[9]);
	}
	$fp = fopen('not_solicitudesPartidos.json', 'w');
	fwrite($fp, json_encode($posts));
	fclose($fp);

	$miconexion->consulta("select u.user, u.avatar, u.sexo, n.id_user, n.fecha_not, n.visto, n.id_partido, p.nombre_partido, n.mensaje, n.id_noti, p.fecha_partido, p.hora_partido, p.hora_fin, cd.centro_deportivo from notificaciones n, usuarios u, partidos p, centros_deportivos cd where p.id_centro = cd.id_centro and n.responsable = u.id_user and n.tipo='sugerencia' and n.id_user != n.responsable and n.id_partido = p.id_partido and n.id_partido is not null");
	$response = array();
	$posts = array();
	for ($i=0; $i < $miconexion->numregistros(); $i++) { 
        $comentarios=$miconexion->consulta_lista(); 
        $fecha = preg_split("/[\s,]+/", $comentarios[4]);
		$posts[] = array('user'=> $comentarios[0], 'avatar'=> $comentarios[1], 'sexo'=> $comentarios[2], 'id_user'=> $comentarios[3], 'fecha_not'=> $fecha[0]."T".$fecha[1]."-0500", 'visto'=> $comentarios[5], 'id_partido'=> $comentarios[6], 'nom_partido'=> $comentarios[7], 'mensaje'=> $comentarios[8], 'id_noti'=>$comentarios[9], 'fecha'=>$comentarios[10], 'hora_ini'=>$comentarios[11], 'hora_fin'=>$comentarios[12], 'centro'=>$comentarios[13]);
	}
	$fp = fopen('not_sugerenciaPartidos.json', 'w');
	fwrite($fp, json_encode($posts));
	fclose($fp);
?>