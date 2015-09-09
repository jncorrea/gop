<?php 
	include("../static/site_config.php"); 
	include ("../static/clase_mysql.php");
	$miconexion = new clase_mysql;
	$miconexion->conectar($db_name,$db_host, $db_user,$db_password); 
	///crear json para notificaciones de comentarios en grupos
	$miconexion->consulta("select u.user, u.avatar, u.sexo, n.id_user, n.fecha_not, n.visto, n.id_grupo, g.nombre_grupo from notificaciones n, usuarios u, grupos g where n.responsable = u.id_user and n.tipo='comentario' and n.id_grupo = g.id_grupo and n.id_grupo is not null");
	$response = array();
	$posts = array();
	for ($i=0; $i < $miconexion->numregistros(); $i++) { 
        $comentarios=$miconexion->consulta_lista(); 
		$posts[] = array('user'=> $comentarios[0], 'avatar'=> $comentarios[1], 'sexo'=> $comentarios[2], 'id_user'=> $comentarios[3], 'fecha_not'=> $comentarios[4], 'visto'=> $comentarios[5], 'id_grupo'=> $comentarios[6], 'nom_grupo'=> $comentarios[7]);
	}
	//$response['posts'] = $posts;

	$fp = fopen('notcomen_grupos.json', 'w');
	fwrite($fp, json_encode($posts));
	fclose($fp);
	///crear json para notificaciones de comentarios en partidos
	$miconexion->consulta("select u.user, u.avatar, u.sexo, n.id_user, n.fecha_not, n.visto, n.id_partido, p.nombre_partido from notificaciones n, usuarios u, partidos p where n.responsable = u.id_user and n.tipo='comentario' and n.id_partido = p.id_partido and n.id_partido is not null");
	$response = array();
	$posts = array();
	for ($i=0; $i < $miconexion->numregistros(); $i++) { 
        $comentarios=$miconexion->consulta_lista(); 
		$posts[] = array('user'=> $comentarios[0], 'avatar'=> $comentarios[1], 'sexo'=> $comentarios[2], 'id_user'=> $comentarios[3], 'fecha_not'=> $comentarios[4], 'visto'=> $comentarios[5], 'id_partido'=> $comentarios[6], 'nom_partido'=> $comentarios[6]);
	}
	//$response['posts'] = $posts;

	$fp = fopen('notcomen_partidos.json', 'w');
	fwrite($fp, json_encode($posts));
	fclose($fp);


?> 