<?php
$nombre_archivo = $_FILES['archivo']['name'];
$tipo_archivo = $_FILES['archivo']['type'];
$tamano_archivo = $_FILES['archivo']['size'];
 
$MESSAGE_BODY  = "Nombre: ".$_POST["nombre"]."<br />";
$MESSAGE_BODY .= "Email: ".$_POST["mail"]."<br />";
$MESSAGE_BODY .= "Telefono: ".$_POST["telefono"]."<br />";
 
$email        = "destinatario@dominio.es";
 
$asunto     = "Asunto del correo";
$mensaje    = utf8_decode($MESSAGE_BODY);
$nombref    = $_FILES["archivo"]["name"];
 
$cabeceras     = "From: ".$_POST["mail"]."n";
$cabeceras .= "Reply-To: ".$_POST["mail"]."n";
$cabeceras .= "MIME-version: 1.0n";
$cabeceras .= "Content-type: multipart/mixed; ";
$cabeceras .= "boundary="Message-Boundary"n";
$cabeceras .= "Content-transfer-encoding: 7BITn";
$cabeceras .= "X-attachments: $nombref";
 
$body_top  = "--Message-Boundaryn";
$body_top .= "Content-type: text/html; charset=US-ASCIIn";
$body_top .= "Content-transfer-encoding: 7BITn";
$body_top .= "Content-description: Mail message bodynn";
 
$cuerpo = $body_top.$mensaje;
 
if($tamano_archivo>0)
{
//Leo el fichero
   $oFichero = fopen($_FILES["archivo"]["tmp_name"], 'r'); 
   $sContenido = fread($oFichero, filesize($_FILES["archivo"]["tmp_name"]));
   $sAdjuntos .= chunk_split(base64_encode($sContenido));
   fclose($oFichero);
   //Adjunto el fichero
   $cuerpo .= "nn--Message-Boundaryn";
   $cuerpo .= "Content-type: Binary; name="$nombref"n";
   $cuerpo .= "Content-Transfer-Encoding: BASE64n";
   $cuerpo .= "Content-disposition: attachment; filename="$nombref"nn";
   $cuerpo .= "$sAdjuntosn";
   $cuerpo .= "--Message-Boundary--n";
}
//Envío el correo
mail($email, $asunto, $cuerpo, $cabeceras);
 
?>