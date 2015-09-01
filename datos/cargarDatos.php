<?php 
	include("../static/site_config.php"); 
	include ("../static/clase_mysql.php");
	$miconexion = new clase_mysql;
	$miconexion->conectar($db_name,$db_host, $db_user,$db_password); 
	//crear json para comentarios en grupos 
	$miconexion->consulta("select * from comentarios where  limit 20");
	$response = array();
	$posts = array();
	for ($i=0; $i < $miconexion->numregistros(); $i++) { 
        $usuarios=$miconexion->consulta_lista();  
    	$user=$usuarios[0]; 
		$estado=$usuarios[1]; 
		$posts[] = array('user'=> $user, 'estado'=> $estado);
	}
	$response['posts'] = $posts;

	$fp = fopen('comentarios_grupos.json', 'w');
	fwrite($fp, json_encode($response));
	fclose($fp);
	///crear json para comentarios en partidos
	$miconexion->consulta("select user, estado from usuarios limit 20");
	$response = array();
	$posts = array();
	for ($i=0; $i < $miconexion->numregistros(); $i++) { 
        $usuarios=$miconexion->consulta_lista();  
    	$user=$usuarios[0]; 
		$estado=$usuarios[1]; 
		$posts[] = array('user'=> $user, 'estado'=> $estado);
	}
	$response['posts'] = $posts;

	$fp = fopen('comentarios_grupos.json', 'w');
	fwrite($fp, json_encode($response));
	fclose($fp);


?> 