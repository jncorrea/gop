<?php
include("../static/site_config.php"); 
include ("../static/clase_mysql.php");
$miconexion = new clase_mysql;
$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
if(@$_POST['mail']){
	
	$mail = htmlentities($_POST['mail']);
	$caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890"; //posibles caracteres a usar
	$numerodeletras=8; //numero de letras para generar el texto
	$new_pass = ""; //variable para almacenar la cadena generada
	for($i=0;$i<$numerodeletras;$i++)
	{
	    $new_pass .= substr($caracteres,rand(0,strlen($caracteres)),1); /*Extraemos 1 caracter de los caracteres 
	entre el rango 0 a Numero de letras que tiene la cadena */
	}
	$miconexion->consulta("select email, pass, user from miembros where email='$mail'");
	$num=$miconexion->numregistros();
	if($num == 0){
	echo "El email ingresado no existe";
	exit();
	}	
	$row = $miconexion->consulta_lista();
	$hash = md5(md5($row[2]).md5($row[1]));
	$msg = null;      
    $email = htmlspecialchars($_POST['mail']);
    $asunto ="Recuperar password (GOP)";
    $mensaje = "<h1 style='color:#0B0B3B; font-weight:bold;'>Nueva Contrase&ntilde;a</h1><hr>";
    $mensaje .= "<blockquote style='font-size: 18px; background: #f9f9f9; border-left: 10px solid #ccc; margin: 1.5em 10px; padding: 0.5em 10px;'>
    			Ha solicitado recuperar contrase&ntilde;a: <br>
    			<strong>Usuario: <strong> ".$row[2]."<br>
    			<strong>Password: <strong> ".$new_pass."<br>
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
    	echo '<script>alert("Se ha enviado una nueva contrase$ntilde;a")</script>';
    	$miconexion->consulta("update miembros set pass = '".md5($new_pass)."' where email='".$row[0]."'");
    	echo "<script>location.href='../index.php'</script>";
    }
    else{
    	echo "<script> alert(Lo siento, no se ha podido enviar el mail.! Intentelo nuevamente)</script>";
    	echo "<script>location.href='../index.php'</script>";
    }
}?>