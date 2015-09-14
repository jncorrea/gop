<?php
include("../static/site_config.php"); 
include ("../static/clase_mysql.php");
$miconexion = new clase_mysql;
$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
session_start();
extract($_GET);
extract($_POST);
echo "Bienvenido a eliminar usuario";

	
 	 $miconexion->consulta("delete from user_grupo where id_grupo = '15' ");
 	 if($miconexion->consulta("delete from grupos where id_grupo = '15' ")){
      echo '<script>
        $container = $("#container_notify_ok").notify();  
        create("default", { title:" Notificaci&oacute;n", text:"Grupo Eliminado"}); 
        $("#menu_izquierdo").load("menu.php");
        </script>';
   }else{
        echo '<script>
        $container = $("#container_notify_bad").notify(); 
        create("default", { title:"Alerta", text:"Error al eliminar el grupo. <br> Por favor intente nuevamente."}); 
        </script>';
   }

  ?>