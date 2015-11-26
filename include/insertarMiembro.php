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
	for ($i=2; $i <count($_POST)-1; $i++) {
			$lista[$i-2]=utf8_decode(array_values($_POST)[$i]);
	}
	
	$miconexion->consulta("select id_user from user_grupo where id_grupo='".$lista[1]."' and id_user='".$lista[0]."' UNION select id_user from notificaciones where id_grupo='".$lista[1]."' and id_user='".$lista[0]."'");
	$usuarios_invitados=$miconexion->numregistros();
	//Excepción : cuando se ingresa un email que no existe registrado como usuario, por defecto viene el id_user del usuario invitado anteriormente
	$miconexion->consulta("select email from usuarios where id_user='".$lista[0]."'");
	$email_usuario=$miconexion->consulta_lista();
	if ($email_usuario[0]==htmlspecialchars(array_values($_POST)[1])) {
			$bandera=1;
	}

if ($usuarios_invitados>0 and $bandera==1) {
		echo '<script>
				$container = $("#container_notify").notify();  
            	create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Este usuario ya ha sido invitado al grupo anteriormente.", imagen:"../assets/img/alert.png"}); 
			  </script>';
		
}else{
	$miconexion->consulta("select count(*) from usuarios where (id_user = '".array_values($_POST)[1]."' or email ='".array_values($_POST)[1]."')");
	$flag=$miconexion->consulta_lista();
	$miconexion->consulta("select nombre_grupo from grupos where id_grupo = '".$lista[1]."'");
	$grupo=$miconexion->consulta_lista();
	$miconexion->consulta("select count(*) from temp where email_temp = '".array_values($_POST)[1]."' and id_grupo = '".$lista[1]."'");
	$temp=$miconexion->consulta_lista();
	if ($flag[0]==0) { 
	    $email = htmlspecialchars(array_values($_POST)[1]);
	    $asunto ="Unete a un grupo (GOP)";
	    $mensaje = "<h1 style='color:#0B0B3B; font-weight:bold;'>Te han invitado a unirte a un grupo...!</h1><hr>";
	    $mensaje .= "<blockquote style='font-size: 18px; background: #f9f9f9; border-left: 10px solid #ccc; margin: 1.5em 10px; padding: 0.5em 10px;'>
	    			Has sido invitado a unirte al grupo $grupo[0]<br>
	    			&iquest;Quieres aceptar la invitaci&oacute;n? <br>
	    			<a href='http://loxatec.com/gop/index.php' target='_blank'; style='font-weight:bold; font-size: 20px;'>Registrate Ya.! </a>
	    			</blockquote>";       
	   	$headers .= "\r\nContent-type: text/html\r\n"; 
    	if (mail($email,$asunto,$mensaje,$headers)){
	    	if ($temp[0]==0) {
						$_SESSION["ultimoAcceso"]= date("Y-m-d H:i:s", time());	
	    		if($miconexion->consulta("insert into temp values('','".$lista[1]."','".$email."','".date("Y-m-d", time())."','".$_SESSION['id']."')")){
	    			echo '<script>
						$container = $("#container_notify").notify();    
            			create("default", { color:"background:rgba(16,122,43,0.8);", enlace:"#" ,title:"Notificaci&oacute;n", text:"Usuario Invitado.", imagen:"../assets/img/check.png"}); 
       					$("#col_grupos").load("grupos.php?id='.$lista[1].'");
       					$.get("../datos/cargarSolicitudes.php");
       					send(2);
			    	</script>';
			    }else{
			    	echo '<script>
			    		$container = $("#container_notify").notify();  
            			create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"No se ha podido enviar la invitaci&oacute;n <br> Por favor intente nuevamente.", imagen:"../assets/img/alert.png"}); 
			    	</script>';
			    }
	    	}
	    }
	    else{
	    	echo '<script>
				$container = $("#container_notify").notify();  
            	create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"No se ha podido enviar la invitaci&oacute;n <br> Por favor intente nuevamente.", imagen:"../assets/img/alert.png"}); 
	    	</script>';
	    }
		
	}else if ($flag[0]==1) {
		
		$miconexion->consulta("select disponible from usuarios where id_user=".$lista[0]." ");
		@$a=$miconexion->consulta_lista();
		if ($a[0]==1) {
				$sql = "insert into notificaciones (id_user, id_grupo, fecha_not, visto, responsable, tipo, mensaje) values('".$lista[0]."','".$lista[1]."','".$_POST['fecha_actual']."','0','".$_SESSION['id']."','solicitud',' te ha invitado a formar parte del grupo')";
				if($miconexion->consulta($sql)){
					$miconexion->consulta("update grupos set ultima_modificacion= '".date("Y-m-d H:i:s", time())."' where id_grupo='".$lista[1]."'");
					echo '<script>
						$.get("../datos/cargarSolicitudes.php");
						$container = $("#container_notify").notify();    
	            		create("default", { color:"background:rgba(16,122,43,0.8);", enlace:"#" ,title:"Notificaci&oacute;n", text:"El usuario ha sido invitado.!", imagen:"../assets/img/check.png"}); 
		        		$("#col_miembros").load("miembros.php?id='.$lista[1].'");
		        		document.getElementById("id_persona").value = "";
		        		document.getElementById("persona").value = "";
		        		send(2);
			    	</script>';
			    }else{
			    	echo '<script>
						$container = $("#container_notify").notify();  
            			create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"No se ha podido enviar la invitaci&oacute;n <br> Por favor intente nuevamente.", imagen:"../assets/img/alert.png"});
            			document.getElementById("id_persona").value = "";
			        	document.getElementById("persona").value = "";  
			    	</script>';
			    }

		}else{
			echo '<script>
						$container = $("#container_notify").notify();  
            			create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Este usuario no acepta Invitaciones :( ", imagen:"../assets/img/alert.png"}); 
			    		document.getElementById("id_persona").value = "";
			        	document.getElementById("persona").value = "";
			    	</script>';
		}

		
	}
}
?>

