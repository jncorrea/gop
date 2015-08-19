<?php
include("../static/site_config.php"); 
include ("../static/clase_mysql.php");
$miconexion = new clase_mysql;
$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
session_start();
extract($_GET);
date_default_timezone_set('America/Guayaquil');
	if (@$act==1) {
 	 $miconexion->consulta("delete from user_grupo where id_grupo = '".$id."' ");
 	 if($miconexion->consulta("delete from grupos where id_grupo = '".$id."' ")){
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

  }
  if(@$act==2){
   if($miconexion->consulta("update user_grupo set estado_conec=1 where id_grupo = '".$id."' and id_user = '".$_SESSION['id']."'")){
    echo '<script>
        $container = $("#container_notify_ok").notify();  
        create("default", { title:" Notificaci&oacute;n", text:"Ha sido agregado a tus grupos.."}); 
        $("#menu_izquierdo").load("menu.php");
        $("#col_grupos").load("grupos.php?id='.$id.'");
        </script>';
      }else{
        echo '<script>
        $container = $("#container_notify_bad").notify(); 
        create("default", { title:"Alerta", text:"Error al confimar solicitud. <br> Por favor intente nuevamente."}); 
        </script>';
      }   
  }
  if(@$act==3){
   $miconexion->consulta("delete from user_grupo where id_grupo = '".$id."'  and id_user = '".$_SESSION['id']."'");    
  }
  if(@$act==4){
   	if($miconexion->consulta("update alineacion set estado_alineacion=1, fecha_alineacion='".date("Y-m-d H:i:s", time())."' where id_alineacion = '".$id."' and id_user = '".$_SESSION['id']."'")){ 
    echo '<script>
        $container = $("#container_notify_ok").notify();  
        create("default", { title:" Notificaci&oacute;n", text:"Te has unido. <br> Mira la alineaci&oacute;n desde tus partidos..."}); 
        $("#menu_izquierdo").load("menu.php");        
        </script>';
      }else{
        echo '<script>
        $container = $("#container_notify_bad").notify(); 
        create("default", { title:"Alerta", text:"Error al confimar solicitud. <br> Por favor intente nuevamente."}); 
        </script>';
      }  
  }
  if(@$act==5){
  	$miconexion->consulta("delete from alineacion where id_alineacion = '".$id."' and id_user = '".$_SESSION['id']."'");  
  }
  if (@$act==6) {
    if($miconexion->consulta("delete from user_grupo where id_grupo = '".$id."' and id_user = '".$_SESSION['id']."' ")){
    echo '<script> 
        location.href = "perfil.php";
        </script>';
    }else{
        echo '<script>
        $container = $("#container_notify_bad").notify(); 
        create("default", { title:"Alerta", text:"Error al confimar la solicitud. <br> Por favor intente nuevamente."}); 
        </script>';
    }
  } 
  if (@$act==7) {
    if($miconexion->consulta("delete from user_grupo where id_grupo = '".$id."' and id_user = '".$usm."' ")){
      echo '<script>        
        $container = $("#container_notify_ok").notify();  
        create("default", { title:" Notificaci&oacute;n", text:"El usuario '.$usm.' <br> ha sido eliminado"}); 
        $("#col_grupos").load("grupos.php?id='.$id.'");
        </script>';
    }else{
        echo '<script>
        $container = $("#container_notify_bad").notify(); 
        create("default", { title:"Alerta", text:"Error al eliminar usuario. <br> Por favor intente nuevamente."}); 
        </script>';
    }
  }
  if (@$act==8) {
  if($miconexion->consulta("update grupos set id_user = '".$usm."' where id_grupo = '".$id."'")){
    echo '<script>
        $container = $("#container_notify_ok").notify();  
        create("default", { title:" Notificaci&oacute;n", text:"Has nombrado un nuevo administrador."}); 
        $("#menu_izquierdo").load("menu.php");
        $("#col_grupos").load("grupos.php?id='.$id.'");
        </script>';
    }else{
        echo '<script>
        $container = $("#container_notify_bad").notify(); 
        create("default", { title:"Alerta", text:"Error al cambiar de administrador. <br> Por favor intente nuevamente."}); 
        </script>';
    }
  }
 ?>