<?php 
echo "hola";
echo "<script>console.log('hola')</script>";
echo "<script>alert('hola')</script>";
/*    session_start(); 
    extract($_POST);

    include("../static/clase_mysql.php");
    include("../static/site_config.php");   
  
    $miconexion = new clase_mysql;
    $miconexion->conectar($db_name,$db_host, $db_user,$db_password);
    $miconexion->consulta("select pass from usuarios where email = '".$_SESSION['email']."' ");
    $lista=$miconexion->consulta_lista();
    $pass_anterior=$lista[0];

    $pass_actual_encriptada=md5($_POST['pass_actual']);
    if ($pass_anterior!=$pass_actual_encriptada) {
        echo '<script>
                $container = $("#container_notify_bad").notify();   
                create("default", { title:"Alerta", text:"La contrase&ntilde;a anterior no es correcta."}); 
            </script>';
    }elseif ($_POST['pass_nueva1']==$_POST['pass_nueva2']) {
        //echo "contrasenias nuevas son iguales";
        $pass_nueva=md5($_POST['pass_nueva1']);
        # code...
    }else{
        //echo "contrasenias nuevas son distintas";
        echo '<script>
            $container = $("#container_notify_bad").notify();   
            create("default", { title:"Alerta", text:"Las nuevas contrase&ntilde;as no coinciden."}); 
        </script>';
    }

            
    if (count($errores)>0) {
        
        echo "<script>alert('Se presentaron errores');</script>";
       var_dump($errores);
    }else{
        //echo "<br>no hay erroes";
        if ($miconexion->consulta("UPDATE usuarios SET PASS='".$pass_nueva."' where email = '".$_SESSION['email']."' ")) {
            echo '<script>
                $container = $("#container_notify_ok").notify();    
                create("default", { title:" Notificaci&oacute;n", text:"Contrase&ntilde;a cambiada con &eacute;xito."});
                document.getElementById("form_cambpass").reset();
            </script>';
            
        }else{
            echo '<script>
                $container = $("#container_notify_bad").notify();   
                create("default", { title:"Alerta", text:"Error al Cambiar Contrase&ntilde;a<br> Por favor intente nuevamente."}); 
                
            </script>';
        }

    }
*/
            
?>