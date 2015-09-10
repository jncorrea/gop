<?php 
    extract($_POST);
	include("../static/clase_mysql.php");
	include("../static/site_config.php");
	$miconexion = new clase_mysql;
	$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
	$lista="";
	for ($i=1; $i <count($_POST); $i++) {
			$lista[$i-1]=utf8_decode(array_values($_POST)[$i]);			
	}
	for ($i=1; $i <count($_POST); $i++) {
			$columnas[$i-1]=array_keys($_POST)[$i];			
	}
	$sql=$miconexion->ingresar_sql($_POST['bd'],$columnas,$lista);
	if (@$_POST['id_partido']<>"") {
		$miconexion->consulta("select a.id_user from partidos p, alineacion a where p.id_partido = a.id_partido and p.id_partido='".$_POST['id_partido']."' and a.id_user != '".$_POST['id_user']."'");
		for ($i=0; $i < $miconexion->numregistros(); $i++) { 
			$user=$miconexion->consulta_lista();
			$miconexion->consulta("insert into notificaciones (id_user, id_partido, fecha_not, visto, responsable, tipo, mensaje) values('".$user[0]."','".$_POST['id_partido']."','".$_POST['fecha_publicacion']."','0','".$_POST['id_user']."','comentario','ha comentado en el partido')");
		}
	}
	if (@$_POST['id_grupo']<>"") {
		$miconexion->consulta("select id_user from user_grupo where id_grupo='".$_POST['id_grupo']."' and id_user <> '".$_POST['id_user']."'");
		for ($i=0; $i < $miconexion->numregistros(); $i++) { 
			$user=$miconexion->consulta_lista();
			$miconexion->consulta("insert into notificaciones (id_user, id_grupo, fecha_not, visto, responsable, tipo, mensaje) values('".$user[0]."','".$_POST['id_grupo']."','".$_POST['fecha_publicacion']."','0','".$_POST['id_user']."','comentario','ha comentado en el grupo')");
		}
	}
    
    if($miconexion->consulta($sql)){
    	echo '<script>
			document.getElementById("text_comentario").value = "";
			$.get("../datos/cargarDatos.php");
			$.get("../datos/cargarNotificaciones.php");
    	</script>';
    }else{
    	echo '<script>
			$container = $("#container_notify_bad").notify();	
			create("default", { title:" Notificaci&oacute;n", text:"Error al Publicar Comentario <br> Por favor intente nuevamente."}); 
    	</script>';
    }
    
   ?>