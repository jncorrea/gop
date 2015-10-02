<?php 
	include("../static/site_config.php"); 
	include ("../static/clase_mysql.php");
	$miconexion = new clase_mysql;
	$miconexion->conectar($db_name,$db_host, $db_user,$db_password); 
	date_default_timezone_set('America/Guayaquil');
    $hoy = date("Y-m-d H:i:s", time());

	$miconexion->consulta("select id_partido, nombre_partido, fecha_partido, hora_partido, estado_partido, fecha_creacion from partidos where estado_partido=2");
	$response = array();
	$posts = array();
	for ($i=0; $i < $miconexion->numregistros(); $i++) { 
        $datos=$miconexion->consulta_lista(); 
       	$fecha_hora_partido=$datos[2]."".$datos[3];
        //algoritmo
        $segundosdiferencia=strtotime($fecha_hora_partido)-strtotime($datos[5]);
        $horasdiferencia=floor(($segundosdiferencia/60)/60); //Redondeamos con floor
        $minutosdiferencia=floor($segundosdiferencia/60);
        $cuarto=($horasdiferencia/4);
        $cuarto=number_format($cuarto, 0);
        $fechaVence = date('Y-m-d H:i:s',strtotime('+'.$cuarto.' hour', strtotime($datos[5])));
        
        if ($horasdiferencia<=24) {//Si el partido se jugara en menos de 1 dia el tiempo de espera de confirmacion sera de medio dia 
            $fechaVence=date('Y-m-d H:i:s',strtotime('+'.$cuarto.' hour', strtotime($fechaVence)));//Sumanos cuarto como numero de horas a la fecha actual.
            /*@$fecha_hora = split(' ', $fechaVence); 
            if ($fecha_hora[1]<'08:00:00') {
                $fechaVence=$fecha_hora[0]." 08:00:00";
            }*/
        }

		$posts[] = array('id_partido'=> $datos[0], 'estado_partido'=> $datos[4], 'fecha_creacion'=> $datos[5], 'fecha_expira'=> $fechaVence);
	}
	//$response['posts'] = $posts;

	$fp = fopen('tiempoEsperaPartidos.json', 'w');
	fwrite($fp, json_encode($posts));
	fclose($fp);
	
?>