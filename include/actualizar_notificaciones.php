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
  if (@$act==9) {
  if($miconexion->consulta("delete from centros_favoritos where id_centro = '".$id."' and id_user = '".$usm."'")){
    echo '<script>
        document.getElementById("centro_favorito").className = "icon-star-empty";
        document.getElementById("centro_favorito").onclick = function() {
          actualizar_notificacion("10","'.$id.'","'.$_SESSION["id"].'");
        };
        $container = $("#container_notify_ok").notify();  
        create("default", { title:" Notificaci&oacute;n", text:"Has quitado el centro <br> deportivo como favorito "}); 
        </script>';
    }else{
        echo '<script>
        $container = $("#container_notify_bad").notify(); 
        create("default", { title:"Alerta", text:"Algo ocurri&oacute;. <br> Por favor intente nuevamente."}); 
        </script>';
    }
  }
  if (@$act==10) {
  if($miconexion->consulta("insert into centros_favoritos values ('','".$id."','".$usm."')")){
    echo '<script>
        document.getElementById("centro_favorito").className = "icon-star";
        document.getElementById("centro_favorito").onclick = function() {
          actualizar_notificacion("9","'.$id.'","'.$_SESSION["id"].'");
        };
        $container = $("#container_notify_ok").notify();  
        create("default", { title:" Notificaci&oacute;n", text:"Haz indicado el centro <br> deportivo como favorito."}); 
        
        
        </script>';
    }else{
        echo '<script>
        $container = $("#container_notify_bad").notify(); 
        create("default", { title:"Alerta", text:"Error´, no se pudo actualizar. <br> Por favor intente nuevamente."}); 
        </script>';
    }
  }

  if (@$act==11) {
  if($miconexion->consulta("delete from deportes_favoritos where id_deporte = '".$id."' and id_user = '".$usm."'")){
    echo '<script>
        
        document.getElementById("centro_favorito").onclick = function() {
          actualizar_notificacion("12","'.$id.'","'.$_SESSION["id"].'");
        };
        $container = $("#container_notify_ok").notify();  
        create("default", { title:" Notificaci&oacute;n", text:"Has quitado el deporte seleccionado <br> como favorito."}); 
        $("#col_perfil").load("configurar.php?opcion=favoritos");
        </script>';


    }else{
        echo '<script>
        $container = $("#container_notify_bad").notify(); 
        create("default", { title:"Alerta", text:"Algo ocurri&oacute;. <br> Por favor intente nuevamente."}); 
        </script>';
    }
  }

  if (@$act==12) {
  if($miconexion->consulta("insert into deportes_favoritos values ('','".$id."','".$usm."')")){
    echo '<script>
        
        document.getElementById("deporte_favorito").onclick = function() {
          actualizar_notificacion("11","'.$id.'","'.$_SESSION["id"].'");
        };
        $container = $("#container_notify_ok").notify();  
        create("default", { title:" Notificaci&oacute;n", text:"Has indicado el <br> deporte seleccionado como favorito."}); 
        $("#col_perfil").load("configurar.php?opcion=favoritos");
        </script>';
    }else{
        echo '<script>
        $container = $("#container_notify_bad").notify(); 
        create("default", { title:"Alerta", text:"Error, no se pudo actualizar. <br> Por favor intente nuevamente."}); 
        </script>';
    }
  }

  if (@$act==13) {
  if($miconexion->consulta("delete from centros_favoritos where id_centro = '".$id."' and id_user = '".$usm."'")){
    echo '<script>
        
        document.getElementById("centro_favorito").onclick = function() {
          actualizar_notificacion("10","'.$id.'","'.$_SESSION["id"].'");
        };
        $container = $("#container_notify_ok").notify();  
        create("default", { title:" Notificaci&oacute;n", text:"Has quitado el centro <br> deportivo como favorito "}); 
        $("#col_perfil").load("configurar.php?opcion=favoritos");
        </script>';
    }else{
        echo '<script>
        $container = $("#container_notify_bad").notify(); 
        create("default", { title:"Alerta", text:"Algo ocurri&oacute;. <br> Por favor intente nuevamente."}); 
        </script>';
    }
  }
  if (@$act==14) {
  if($miconexion->consulta("insert into centros_favoritos values ('','".$id."','".$usm."')")){
    echo '<script>
        
        document.getElementById("centro_favorito").onclick = function() {
          actualizar_notificacion("9","'.$id.'","'.$_SESSION["id"].'");
        };
        $container = $("#container_notify_ok").notify();  
        create("default", { title:" Notificaci&oacute;n", text:"Haz indicado el centro <br> deportivo como favorito. "}); 
        $("#col_perfil").load("configurar.php");
        </script>';
    }else{
        echo '<script>
        $container = $("#container_notify_bad").notify(); 
        create("default", { title:"Alerta", text:"Error, no se pudo actualizar. <br> Por favor intente nuevamente."}); 
        </script>';
    }
  }
  if (@$act==15) {
  if($miconexion->consulta("delete from horarios_centros where id_horario = '".$usm."'")){
    echo '<script>
        $container = $("#container_notify_ok").notify();  
        create("default", { title:" Notificaci&oacute;n", text:"Se ha eliminado el horario"}); 
        $("#col_tabla_horario").load("tabla_horario.php?i='.$id.'");
        </script>';
    }else{
        echo '<script>
        $container = $("#container_notify_bad").notify(); 
        create("default", { title:"Alerta", text:"Error, no se pudo actualizar. <br> Por favor intente nuevamente."}); 
        </script>';
    }
  }
 ?>