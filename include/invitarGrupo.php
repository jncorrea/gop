<?php 
    extract($_POST);
    date_default_timezone_set('America/Guayaquil');
	include("../static/clase_mysql.php");
	include("../static/site_config.php");
	$miconexion = new clase_mysql;
	$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
	session_start();
	$lista="";
	$bandera=0;
	for ($i=0; $i <count($_POST); $i++) {
			$lista[$i]=utf8_decode(array_values($_POST)[$i]);
	}
	
	$miconexion->consulta("select id_grupo from grupos_campeonato where id_campeonato='".$lista[1]."' UNION select id_grupo from notificaciones where id_campeonato='".$lista[1]."'");
	$grupos_invitados=$miconexion->numregistros();
	for ($i=0; $i < $miconexion->numregistros(); $i++) { 
		$grupo_camp = $miconexion->consulta_lista();
		if ($grupo_camp[0]==$lista[0]) {
			$bandera=1;
		}
	}
if ($lista[0]=='0') {
	echo '<script>
		$container = $("#container_notify").notify();  
    	create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Debes seleccionar un grupo.", imagen:"../assets/img/alert.png"}); 
	  </script>';
}
else{
	if ($grupos_invitados>0 and $bandera==1) {
			echo '<script>
					$container = $("#container_notify").notify();  
	            	create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Este grupo ya ha sido invitado al campeonato.", imagen:"../assets/img/alert.png"}); 
				  </script>';
			
	}else{
		$miconexion->consulta("select nombre_grupo, id_user from grupos where id_grupo ='".$lista[0]."'");
		$grupo=$miconexion->consulta_lista();
		$miconexion->consulta("select nombre_campeonato from campeonatos where id_campeonato ='".$lista[1]."'");
		$campeonato=$miconexion->consulta_lista();
		$sql = "insert into notificaciones (id_user, id_campeonato, id_grupo, fecha_not, visto, responsable, tipo, mensaje) values('".$grupo[1]."','".$lista[1]."','".$lista[0]."','".date('Y-m-d H:i:s', time())."','0','".$_SESSION['id']."','solicitud',' ha invitado a unirse al campeonato <strong>".$campeonato[0]."</strong> al grupo ')";
		if($miconexion->consulta($sql)){
			echo '<script>
				$.get("../datos/cargarSolicitudes.php");
				send(2);
				$container = $("#container_notify").notify();    
        		create("default", { color:"background:rgba(16,122,43,0.8);", enlace:"#" ,title:"Notificaci&oacute;n", text:"El grupo ha sido invitado.!", imagen:"../assets/img/check.png"}); 
        		location.href = location.href;
	    	</script>';
		}else{
			echo '<script>
				$container = $("#container_notify").notify();  
    			create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"No se ha podido enviar la invitacion.", imagen:"../assets/img/alert.png"});  
	    	</script>';
		}
				
	}
}
?>

