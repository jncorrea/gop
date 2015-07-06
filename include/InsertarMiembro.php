<?php 
    extract($_POST);
	include("../static/clase_mysql.php");
	include("../static/site_config.php");
	$miconexion = new clase_mysql;
	$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
	$lista="";
	for ($i=2; $i <count($_POST); $i++) {
			$lista[$i-2]=array_values($_POST)[$i];
	}
	$miconexion->consulta("select count(*) from miembros where email = '".array_values($_POST)[1]."'");
	$flag=$miconexion->consulta_lista();
	$miconexion->consulta("select nombre_grupo from grupos where id_grupo = '".$lista[1]."'");
	$grupo=$miconexion->consulta_lista();
	$miconexion->consulta("select count(*) from temp where email_temp = '".array_values($_POST)[1]."' and grupo_temp = '".$lista[1]."'");
	$temp=$miconexion->consulta_lista();
	if ($flag[0]==0) {
		$msg = null;      
	    $email = htmlspecialchars(array_values($_POST)[1]);
	    $asunto ="Unete a un grupo (GOP)";
	    $mensaje = "<h1 style='color:#0B0B3B; font-weight:bold;'>Te han invitado a unirte a un grupo...!</h1><hr>";
	    $mensaje .= "<blockquote style='font-size: 18px; background: #f9f9f9; border-left: 10px solid #ccc; margin: 1.5em 10px; padding: 0.5em 10px;'>
	    			Has sido invitado a unirte al grupo $grupo[0]<br>
	    			&iquest;Quieres aceptar la invitaci&oacute;n? <br>
	    			<a href='http://127.0.0.1/gop/index.php' target='_blank'; style='font-weight:bold; font-size: 20px;'>Registrate Ya.! </a>
	    			</blockquote>";       
	    require "../phpmailer/PHPMailerAutoload.php";

	      $mail = new PHPMailer;
		  
		  //indico a la clase que use SMTP
	      $mail->IsSMTP();
		  
	      //permite modo debug para ver mensajes de las cosas que van ocurriendo
	      //$mail->SMTPDebug = 2;

		  //Debo de hacer autenticación SMTP
	      $mail->SMTPAuth = true;
	      $mail->SMTPSecure = "ssl";

		  //indico el servidor de Gmail para SMTP
	      $mail->Host = "smtp.gmail.com";

		  //indico el puerto que usa Gmail
	      $mail->Port = 465;

		  //indico un usuario / clave de un usuario de gmail
	      $mail->Username = "info.gop2015@gmail.com";
	      $mail->Password = "utpl-gop2015";
	   
	      $mail->From = "info.gop2015@gmail.com";
	    
	      $mail->FromName = "Gather, Organize and Play";
	    
	      $mail->Subject = $asunto;
	    
	      $mail->addAddress($email, $email);
	    
	      $mail->MsgHTML($mensaje);
	    if($mail->Send()){
	    	echo '<script>alert("Usuario invitado")</script>';
	    	if ($temp[0]==0) {
	    		$miconexion->consulta("insert into temp values('','".$email."','".$lista[1]."')");
	    	}
	    	echo "<script>location.href='../perfiles/perfil.php?op=grupos&id=".$lista[1]."'</script>";
	    }
	    else{
	    	echo "<script> alert(Lo siento, no se ha podido inivtar un miembro a unirse.! Intentelo nuevamente)</script>";
	    	echo "<script>location.href='../perfiles/perfil.php?op=grupos&id=".$lista[1]."'</script>";
	    }
		
	}else if ($flag[0]==1) {
		$miconexion->consulta("insert into ".$_POST['bd']." values('".$lista[0]."','".$lista[1]."','0')");  
	    echo '<script>alert("Usuario invitado")</script>';
	    echo "<script>location.href='../perfiles/perfil.php?op=grupos&id=".$lista[1]."'</script>";
	}	
?>

