<?php
include("../static/site_config.php"); 
include ("../static/clase_mysql.php");
@$miconexion = new clase_mysql;
@$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
if(@$_POST['mail']){
	
	@$mail = htmlentities($_POST['mail']);
	@$caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890"; //posibles caracteres a usar
	@$numerodeletras=8; //numero de letras para generar el texto
	@$new_pass = ""; //variable para almacenar la cadena generada
	for($i=0;$i<$numerodeletras;$i++)
	{
	    $new_pass .= substr($caracteres,rand(0,strlen($caracteres)),1); /*Extraemos 1 caracter de los caracteres 
	entre el rango 0 a Numero de letras que tiene la cadena */
	}
	@$miconexion->consulta("select email, pass, user from usuarios where email='$mail'");
	@$num=$miconexion->numregistros();
	if($num == 0){
    echo "<p style='text-align:center; color:red;'>Lo siento, no se ha encontrado el email</p>";
	exit();
	}	
	@$row = $miconexion->consulta_lista();
    @$email = htmlspecialchars($_POST['mail']);
    @$asunto ="Nuevo password (WasiSport)";
    @$mensaje = "<h1 style='color:#0B0B3B; font-weight:bold;'>Nueva Contrase&ntilde;a</h1><hr>";
    @$mensaje .= "<blockquote style='font-size: 18px; background: #f9f9f9; border-left: 10px solid #ccc; margin: 1.5em 10px; padding: 0.5em 10px;'>
    			Ha solicitado una nueva contrase&ntilde;a: <br>
    			<strong>Usuario: <strong> ".$row[2]."<br>
    			<strong>Password: <strong> ".$new_pass."<br>
    			</blockquote>";       
    @$headers .= "From:WasiSport <info.gop2015@gmail.com>\r\nContent-type: text/html\r\n"; 
    if (mail($email,$asunto,$mensaje,$headers)){
    	echo "<p style='text-align:center; color:green;'>Se ha enviado una nueva contrase&ntilde;a</p>";
    	$miconexion->consulta("update usuarios set pass = '".md5($new_pass)."' where email='".$row[0]."'");
    }
    else{
    	echo "<p style='text-align:center; color:red;'>Lo siento, no se ha podido enviar el mail.! <br>Intentelo nuevamente</p>";
    }
}
echo "<script>document.getElementById('formulario_recuperar').reset();</script>";
?>