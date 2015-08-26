<?php 
    extract($_POST);
    date_default_timezone_set('America/Guayaquil');
	include("../static/clase_mysql.php");
	include("../static/site_config.php");
	$miconexion = new clase_mysql;
	$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
	$lista="";
	for ($i=2; $i <count($_POST); $i++) {
			$lista[$i-2]=utf8_decode(array_values($_POST)[$i]);
	}
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
	   	$headers .= "From:Gather Organize and Play <info.gop2015@gmail.com>\r\nContent-type: text/html\r\n"; 
    	if (mail($email,$asunto,$mensaje,$headers)){
	    	if ($temp[0]==0) {
						$_SESSION["ultimoAcceso"]= date("Y-m-d H:i:s", time());	
	    		if($miconexion->consulta("insert into temp values('','".$lista[1]."','".$email."','".date("Y-m-d", time())."')")){
	    			echo '<script>
						$container = $("#container_notify_ok").notify();	
						create("default", { title:" Notificaci&oacute;n", text:"Usuario Invitado.."});
       					$("#col_grupos").load("grupos.php?id='.$lista[1].'");
			    	</script>';
			    }else{
			    	echo '<script>
						$container = $("#container_notify_bad").notify();	
						create("default", { title:"Alerta", text:"No se ha podido enviar la invitaci&oacute; <br> Por favor intente nuevamente."}); 
			    	
			    	</script>';
			    }
	    	}
	    }
	    else{
	    	echo '<script>
				$container = $("#container_notify_bad").notify();	
				create("default", { title:"Alerta", text:"No se ha podido enviar la invitaci&oacute; <br> Por favor intente nuevamente."}); 
	    	</script>';
	    }
		
	}else if ($flag[0]==1) {
		
		$miconexion->consulta("select disponible from usuarios where id_user=".$lista[0]." ");
		@$a=$miconexion->consulta_lista();
		if ($a[0]==1) {

				if($miconexion->consulta("insert into ".$_POST['bd']." values('','".$lista[1]."','".$lista[0]."','".date("Y-m-d H:i:s", time())."','0')")){
				echo '<script>
					$container = $("#container_notify_ok").notify();	
					create("default", { title:" Notificaci&oacute;n", text:"Usuario Invitado.."});
	        		$("#col_grupos").load("grupos.php?id='.$lista[1].'");
		    	</script>';
			    }else{
			    	echo '<script>
						$container = $("#container_notify_bad").notify();	
						create("default", { title:"Alerta", text:"No se ha podido enviar la invitaci&oacute; <br> Por favor intente nuevamente."}); 
			    	</script>';
			    }

		}else{
			echo '<script>
						$container = $("#container_notify_bad").notify();	
						create("default", { title:"Alerta", text:" Usuario no acepta Invitaciones :( "}); 
			    	</script>';
		}

		
	}
?>

