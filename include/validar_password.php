<?php 
    session_start(); 
    extract($_POST);
    include("../static/clase_mysql.php");
    include("../static/site_config.php");   
  
    $miconexion = new clase_mysql;
    $miconexion->conectar($db_name,$db_host, $db_user,$db_password);
    

     $miconexion->consulta("select pass from usuarios where email = '".$_SESSION['email']."' ");
    

    $lista=$miconexion->consulta_lista();
    //echo "<br> contrasenia GUARDADA EN BD".$lista[0];
    $pass_anterior=$lista[0];

    $pass_actual_encriptada=md5($_POST['pass_actual']);
    //echo "<br>pass_actual_encriptada".$pass_actual_encriptada;


    if ($pass_anterior==$pass_actual_encriptada) {
        //echo "contraseña actual correcta";
        # code...
    }else{
        //echo "la contraseña actual no es correcta";
        $errores[]='La contrase&ntilde;a anterior no es correcta';
    }
    if ($_POST['pass_nueva1']==$_POST['pass_nueva2']) {
        //echo "contrasenias nuevas son iguales";
        $pass_nueva=md5($_POST['pass_nueva1']);
        # code...
    }else{
        //echo "contrasenias nuevas son distintas";
        $errores[]='Las nuevas contrase&ntilde;as no coinciden';
    }

            
    if (count(@$errores)>0) {
        
        //echo "<script>alert('Se presentaron errores')</script>";
        $array = serialize($errores);
        $array = urlencode($array);

      echo "<script>location.href='perfil.php?op=configurar_pass&a=$array'</script>";
       // echo "<script>location.href='prueba.php?a=$array'</script>";
        
        
    }else{
        //echo "<br>no hay erroes";
        if ($miconexion->consulta("UPDATE usuarios SET PASS='".$pass_nueva."' where email = '".$_SESSION['email']."' ")) {
            echo '<script>
                $container = $("#container_notify").notify();    
                create("default", { color:"background:rgba(16,122,43,0.8);", enlace:"#" ,title:"Notificaci&oacute;n", text:"Contrase&ntilde;a cambiada con &eacute;xito.", imagen:"../assets/img/check.png"}); 
                document.getElementById("form_cambpass").reset();
            </script>';
            
        }else{
            echo '<script> 
                $container = $("#container_notify").notify();  
                create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Error al Cambiar Contrase&ntilde;a<br> Por favor intente nuevamente.", imagen:"../assets/img/alert.png"}); 
            </script>';
        }
    }

?>
