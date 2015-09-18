<?php 
	include("../static/site_config.php"); 
	include ("../static/clase_mysql.php");
	$miconexion = new clase_mysql;
	$miconexion->conectar($db_name,$db_host, $db_user,$db_password); 
	//crear json para comentarios en grupos 
	$miconexion->consulta("select u.user, u.sexo, u.avatar, c.id_grupo, c.fecha_publicacion, c.comentario, c.image from comentarios c, usuarios u where u.id_user = c.id_user and id_grupo is not null order by fecha_publicacion desc");
	$response = array();
	$posts = array();
	for ($i=0; $i < $miconexion->numregistros(); $i++) { 
        $comentarios=$miconexion->consulta_lista(); 
        $fecha = preg_split("/[\s,]+/", $comentarios[4]);
		$posts[] = array('user'=> $comentarios[0], 'sexo'=> $comentarios[1], 'avatar'=> $comentarios[2], 'tipo'=> $comentarios[3], 'fecha_publicacion'=> $fecha[0]."T".$fecha[1]."-0500", 'comentario'=> $comentarios[5], 'image'=> $comentarios[6]);
	}
	//$response['posts'] = $posts;

	$fp = fopen('comentarios_grupos.json', 'w');
	fwrite($fp, json_encode($posts));
	fclose($fp);
	///crear json para comentarios en partidos
	$miconexion->consulta("select u.user, u.sexo, u.avatar, c.id_partido, c.fecha_publicacion, c.comentario, c.image from comentarios c, usuarios u where u.id_user = c.id_user and id_partido is not null order by fecha_publicacion desc");
	$response = array();
	$posts = array();
	for ($i=0; $i < $miconexion->numregistros(); $i++) { 
        $comentarios=$miconexion->consulta_lista(); 
        $fecha = preg_split("/[\s,]+/", $comentarios[4]);
		$posts[] = array('user'=> $comentarios[0], 'sexo'=> $comentarios[1], 'avatar'=> $comentarios[2], 'tipo'=> $comentarios[3], 'fecha_publicacion'=> $fecha[0]."T".$fecha[1]."-0500", 'comentario'=> $comentarios[5],'image'=> $comentarios[6]);
	}
	//$response['posts'] = $posts;

	$fp = fopen('comentarios_partidos.json', 'w');
	fwrite($fp, json_encode($posts));
	fclose($fp);


?> 