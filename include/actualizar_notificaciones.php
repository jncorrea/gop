<?php
include("../static/site_config.php"); 
include ("../static/clase_mysql.php");
$miconexion = new clase_mysql;
$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
  session_start();
extract($_GET);
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
   if($miconexion->consulta("update grupos_miembros set estado=1 where id_grupo = '".$id."' and email = '".$_SESSION['email']."'")){
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
   $miconexion->consulta("delete from grupos_miembros where id_grupo = '".$id."'  and email = '".$_SESSION['email']."'");    
  }
  if(@$act==4){
   	if($miconexion->consulta("update convocatoria set estado=1 where id_convocatoria = '".$id."' and email = '".$_SESSION['email']."'")){ 
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
  	$miconexion->consulta("delete from convocatoria where id_convocatoria = '".$id."' and email = '".$_SESSION['email']."'");  
  }
  if (@$act==6) {
    if($miconexion->consulta("delete from grupos_miembros where id_grupo = '".$id."' and email = '".$_SESSION['email']."' ")){
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
    if($miconexion->consulta("delete from grupos_miembros where id_grupo = '".$id."' and email = '".$usm."' ")){
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
  if($miconexion->consulta("update grupos set owner = '".$usm."' where id_grupo = '".$id."'")){
    echo '<script>
        $container = $("#container_notify_ok").notify();  
        create("default", { title:" Notificaci&oacute;n", text:"Has nombrado a '.$usm.' <br> como nuevo administrador."}); 
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