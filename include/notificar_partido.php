<?php 
	include("../static/clase_mysql.php");
	include("../static/site_config.php");
	$miconexion = new clase_mysql;
	$miconexion->conectar($db_name,$db_host, $db_user,$db_password);	
	$miconexion->consulta("select email FROM convocatoria WHERE id_partido = '".$_POST['id_partido']."' and estado =1"); 
	$msg = null;
	$headers ="";      
    $asunto ="Proximo Juego (GOP)";
    $mensaje = "<h1 style='color:#0B0B3B; font-weight:bold;'>Alineacion de Partido...!</h1><hr>";
    $mensaje .= "<blockquote style='font-size: 18px; background: #f9f9f9; border-left: 10px solid #ccc; margin: 1.5em 10px; padding: 0.5em 10px;'>
    			<br>
    			Alineacion de Partido...<br>
    			Tienes un juego proximo a realizarse el: ".$_POST['fecha']."<br>
    			En la cancha: ".$_POST['lugar']."<br>
    			Ubicada en: ".$_POST['direccion']."<br>
    			<a href='http://loxatec.com/gop/index.php' target='_blank'; style='font-weight:bold; font-size: 20px;'>Accede a tu cuenta para ver.! </a>
    			</blockquote><br>
    			Te adjuntamos una imagen en donde podras visualizar la alineacion que se ha pre-establecido. <br>";      
    $filteredData=substr($_POST['img_val'], strpos($_POST['img_val'], ",")+1); 
	//Decode the string
	$unencodedData=base64_decode($filteredData);		 
	//Save the image
	file_put_contents('img.png', $unencodedData);
	$email = "";
 	for ($i=0; $i < $miconexion->numregistros(); $i++) { 
        $notificar=$miconexion->consulta_lista();
        if ($miconexion->numregistros() == 1) {
        	$email .= $notificar[0]; 
        }else{
        	if ($i == ($miconexion->numregistros()-1)) {
        		$email .= $notificar[0];
        	}else{
        		$email .= $notificar[0].", ";
        	}
        }
 	}    
    $foto= "img.png";
	$mensaje .='<img style="width:100%; heigth:100%" src="http://loxatec.com/gop/include/'. $foto .'">';
	$headers .= "From:Gather Organize and Play <info.gop2015@gmail.com>\r\nContent-type: text/html\r\n"; 
    if (mail($email,$asunto,$mensaje,$headers)){
    	    echo '<script>
                $container = $("#container_notify_ok").notify();    
                create("default", { title:" Notificaci&oacute;n", text:"Se ha enviado un email a los miembros del partido."});
            </script>';
	}else{
		echo '<script>
            $container = $("#container_notify_bad").notify();   
            create("default", { title:" Notificaci&oacute;n", text:"Error al enviar Notificar <br> Por favor intente nuevamente."}); 
        </script>';
	}
 ?>
