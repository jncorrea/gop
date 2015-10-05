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
        $container = $("#container_notify").notify();    
            create("default", { color:"background:rgba(16,122,43,0.8);", enlace:"#" ,title:"Notificaci&oacute;n", text:"Grupo Eliminado", imagen:"../assets/img/check.png"}); 
        $("#menu_izquierdo").load("menu.php");
        location.href = "perfil.php?";
        </script>';
   }else{
        echo '<script> 
        $container = $("#container_notify").notify();  
        create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Error al eliminar el grupo. <br> Por favor intente nuevamente.", imagen:"../assets/img/alert.png"}); 
        </script>';
   }

  }
  if(@$act==2){
   if($miconexion->consulta("update user_grupo set estado_conec=1 where id_grupo = '".$id."' and id_user = '".$_SESSION['id']."'")){
    echo '<script>
        $container = $("#container_notify").notify();    
        create("default", { color:"background:rgba(16,122,43,0.8);", enlace:"#" ,title:"Notificaci&oacute;n", text:"Ahora formas parte del grupo", imagen:"../assets/img/check.png"}); 
        $("#menu_izquierdo").load("menu.php");
        $("#col_grupos").load("grupos.php?id='.$id.'");
        </script>';
      }else{
        echo '<script>
        $container = $("#container_notify").notify();  
        create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Error al confimar solicitud. <br> Por favor intente nuevamente.", imagen:"../assets/img/alert.png"}); 
        </script>';
      }   
  }
  if(@$act==3){
   $miconexion->consulta("delete from user_grupo where id_grupo = '".$id."'  and id_user = '".$_SESSION['id']."'");    
  }
  if(@$act==4){
   	if($miconexion->consulta("insert into alineacion (id_partido, id_user, posicion_event, fecha_alineacion, estado_alineacion) values ('".$id."', '".$_SESSION['id']."','0','".date('Y-m-d H:i:s', time())."', '1')")){
    $miconexion->consulta("delete from notificaciones where id_noti = '".$usm."'"); 
    echo '<script>
        $container = $("#container_notify").notify();    
        create("default", { color:"background:rgba(16,122,43,0.8);", enlace:"#" ,title:"Notificaci&oacute;n", text:"Te has unido. <br> Mira la alineaci&oacute;n desde tus partidos...", imagen:"../assets/img/check.png"}); 
        $("#menu_izquierdo").load("menu.php");        
        </script>';
      }else{
        echo '<script>
        $container = $("#container_notify").notify();  
        create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Error al confimar solicitud. <br> Por favor intente nuevamente.", imagen:"../assets/img/alert.png"}); 
        </script>';
      }  
  }
  if(@$act==5){ 
    if($miconexion->consulta("delete from notificaciones where id_noti = '".$id."'")){ 
    echo '<script>
        $container = $("#container_notify").notify();    
        create("default", { color:"background:rgba(16,122,43,0.8);", enlace:"#" ,title:"Notificaci&oacute;n", text:"Has cancelado la invitaci&oacute;n :(", imagen:"../assets/img/check.png"}); 
        $("#menu_izquierdo").load("menu.php");        
        </script>';
      }else{
        echo '<script>
        $container = $("#container_notify").notify();  
        create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Ocurri&oacute; un error. <br> Por favor intente nuevamente.", imagen:"../assets/img/alert.png"}); 
        </script>';
      }  
  }
  if (@$act==6) {
    
    $miconexion->consulta("select id_user from grupos where id_grupo='".$id."'");
    $identificador_grupo=$miconexion->consulta_lista();
    if ($identificador_grupo[0]==$_SESSION['id']) {
      echo '<script>
        $container = $("#container_notify").notify();    
        create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Por favor debes asignar un nuevo administrador de Grupo.", imagen:"../assets/img/alert.png"}); 
        </script>';
      
    }else{
      if($miconexion->consulta("delete from user_grupo where id_grupo = '".$id."' and id_user = '".$_SESSION['id']."' ")){      
      echo '<script>
        $container = $("#container_notify").notify();    
        create("default", { color:"background:rgba(16,122,43,0.8);", enlace:"#" ,title:"Notificaci&oacute;n", text:"Haz dejado el grupo. "}); 
        location.href = "perfil.php?";
        </script>';
      }else{
          echo '<script>
          $container = $("#container_notify").notify();  
          create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Error al confimar solicitud. <br> Por favor intente nuevamente.", imagen:"../assets/img/alert.png"});  
          </script>';
      }
    }

    
  } 
  if (@$act==7) {
    if($miconexion->consulta("delete from user_grupo where id_grupo = '".$id."' and id_user = '".$usm."' ")){
      echo '<script>        
        $container = $("#container_notify").notify();    
        create("default", { color:"background:rgba(16,122,43,0.8);", enlace:"#" ,title:"Notificaci&oacute;n", text:"Usuario eliminado", imagen:"../assets/img/check.png"});  
        $("#col_miembros").load("miembros.php?id='.$id.'");
        </script>';
    }else{
        echo '<script>; 
        $container = $("#container_notify").notify();  
        create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Error al eliminar usuario. <br> Por favor intente nuevamente.", imagen:"../assets/img/alert.png"}); 
        </script>';
    }
  }
  if (@$act==8) {
  if($miconexion->consulta("update grupos set id_user = '".$usm."' where id_grupo = '".$id."'")){
      $miconexion->consulta("insert into notificaciones (id_user, id_grupo, fecha_not, visto, responsable, tipo, mensaje) values('".$usm."','".$id."','".$fecha."','0','".$_SESSION['id']."','cambios','te ha nombrado administrador en')");
      echo '<script>
          $.get("../datos/cargarNotificaciones.php");
          $container = $("#container_notify").notify();  
          create("default", { color:"background:rgba(16,122,43,0.8);", enlace:"#" ,title:"Notificaci&oacute;n", text:"Has nombrado un nuevo Administrador", imagen:"../assets/img/check.png"}); 
          send(1);  
          $("#menu_izquierdo").load("menu.php");
          $("#col_miembros").load("miembros.php?id='.$id.'");
          </script>';

    }else{
        echo '<script>
        $container = $("#container_notify").notify();  
        create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Error al cambiar de administrador. <br> Por favor intente nuevamente.", imagen:"../assets/img/alert.png"});  
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
        $container = $("#container_notify").notify();    
        create("default", { color:"background:rgba(16,122,43,0.8);", enlace:"#" ,title:"Notificaci&oacute;n", text:"Has quitado el centro <br> deportivo como favorito", imagen:"../assets/img/check.png"}); 
        </script>';
    }else{
        echo '<script>
        $container = $("#container_notify").notify();  
        create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Algo ocurri&oacute;. <br> Por favor intente nuevamente.", imagen:"../assets/img/alert.png"});  
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
        $container = $("#container_notify").notify();    
        create("default", { color:"background:rgba(16,122,43,0.8);", enlace:"#" ,title:"Notificaci&oacute;n", text:"Haz indicado el centro <br> deportivo como favorito.", imagen:"../assets/img/check.png"}); 
        </script>';
    }else{
        echo '<script>
        $container = $("#container_notify").notify();  
        create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Error´, no se pudo actualizar. <br> Por favor intente nuevamente.", imagen:"../assets/img/alert.png"});  
        </script>';
    }
  }

  if (@$act==11) {
  if($miconexion->consulta("delete from deportes_favoritos where id_deporte = '".$id."' and id_user = '".$usm."'")){
    echo '<script>
        
        document.getElementById("centro_favorito").onclick = function() {
          actualizar_notificacion("12","'.$id.'","'.$_SESSION["id"].'");
        };
        $container = $("#container_notify").notify();    
        create("default", { color:"background:rgba(16,122,43,0.8);", enlace:"#" ,title:"Notificaci&oacute;n", text:"Has quitado el deporte seleccionado <br> como favorito.", imagen:"../assets/img/check.png"}); 
        $("#col_perfil").load("configurar.php?opcion=favoritos");
        </script>';


    }else{
        echo '<script>
        $container = $("#container_notify").notify();  
        create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Algo ocurri&oacute;. <br> Por favor intente nuevamente.", imagen:"../assets/img/alert.png"});  
        </script>';
    }
  }

  if (@$act==12) {
  if($miconexion->consulta("insert into deportes_favoritos values ('','".$id."','".$usm."')")){
    echo '<script>
        
        document.getElementById("deporte_favorito").onclick = function() {
          actualizar_notificacion("11","'.$id.'","'.$_SESSION["id"].'");
        };
        $container = $("#container_notify").notify();    
        create("default", { color:"background:rgba(16,122,43,0.8);", enlace:"#" ,title:"Notificaci&oacute;n", text:"Has indicado el <br> deporte seleccionado como favorito.", imagen:"../assets/img/check.png"}); 
        $("#col_perfil").load("configurar.php?opcion=favoritos");
        </script>';
    }else{
        echo '<script>
        $container = $("#container_notify").notify();  
        create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Error´, no se pudo actualizar. <br> Por favor intente nuevamente.", imagen:"../assets/img/alert.png"});  
        </script>';
    }
  }

  if (@$act==13) {
  if($miconexion->consulta("delete from centros_favoritos where id_centro = '".$id."' and id_user = '".$usm."'")){
    echo '<script>
        
        document.getElementById("centro_favorito").onclick = function() {
          actualizar_notificacion("10","'.$id.'","'.$_SESSION["id"].'");
        };
        $container = $("#container_notify").notify();    
        create("default", { color:"background:rgba(16,122,43,0.8);", enlace:"#" ,title:"Notificaci&oacute;n", text:"Has quitado el centro <br> deportivo como favorito", imagen:"../assets/img/check.png"}); 
        $("#col_perfil").load("configurar.php?opcion=favoritos");
        </script>';
    }else{
        echo '<script>
        $container = $("#container_notify").notify();  
        create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Algo ocurri&oacute;. <br> Por favor intente nuevamente.", imagen:"../assets/img/alert.png"});  
        </script>';
    }
  }
  if (@$act==14) {
  if($miconexion->consulta("insert into centros_favoritos values ('','".$id."','".$usm."')")){
    echo '<script>
        
        document.getElementById("centro_favorito").onclick = function() {
        actualizar_notificacion("9","'.$id.'","'.$_SESSION["id"].'");
        };
        $container = $("#container_notify").notify();    
        create("default", { color:"background:rgba(16,122,43,0.8);", enlace:"#" ,title:"Notificaci&oacute;n", text:"Haz indicado el centro <br> deportivo como favorito.", imagen:"../assets/img/check.png"}); 
        $("#col_perfil").load("configurar.php");
        </script>';
    }else{
        echo '<script>
        $container = $("#container_notify").notify();  
        create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Error´, no se pudo actualizar. <br> Por favor intente nuevamente.", imagen:"../assets/img/alert.png"}); 
        </script>';
    }
  }
  if (@$act==15) {
    if($miconexion->consulta("delete from horarios_centros where id_horario = '".$usm."'")){
      echo '<script>
          $container = $("#container_notify_ok").notify();  
          create("default", { title:" Notificaci&oacute;n", text:"Se ha eliminado el horario"}); 
          $("#col_tabla_horario").load("tabla_horario.php?id='.$id.'");
          </script>';
    }else{
        echo '<script>
        $container = $("#container_notify_bad").notify(); 
        create("default", { title:"Alerta", text:"Error, no se pudo actualizar. <br> Por favor intente nuevamente."}); 
        </script>';
    }
  }
  if (@$act==16) {
    $miconexion->consulta("update notificaciones SET visto='1' WHERE id_user='".$_SESSION['id']."' and tipo != 'solicitud'");
    echo "<script>
      document.getElementById('contador1').innerHTML = '0';
      document.getElementById('contador2').innerHTML = '0';
    </script>";
  }
  if (@$act==17) {
    $miconexion->consulta("delete from notificaciones where id_noti = '".$id."'");
  }
  if (@$act==18) {
    $miconexion->consulta("select * from horarios_centros WHERE id_horario='".$id."'");
    $lista_horario=$miconexion->consulta_lista();
    echo "<script>
      document.getElementById('diaEdit').innerHTML = '".$lista_horario[2]."';
      document.getElementById('horarioEdit').value = '".$id."';
      document.getElementById('horaIniEdit').value = '".$lista_horario[3]."';
      document.getElementById('horaFinEdit').value = '".$lista_horario[4]."';
    </script>";
  }
  if (@$act==19) {
    $miconexion->consulta("update notificaciones SET visto='1' WHERE id_user='".$_SESSION['id']."' and tipo = 'solicitud'");
    echo "<script>
      document.getElementById('solicitud1').innerHTML = '0';
      document.getElementById('solicitud2').innerHTML = '0';
    </script>";
  }
  if (@$act==20) {
    $miconexion->consulta("Select id_grupo, id_partido from notificaciones where id_noti = ".$id);
    $solicitud = $miconexion->consulta_lista();
    if ($solicitud[0]!='') {
      if($miconexion->consulta("insert into user_grupo (id_grupo, id_user, fecha_inv, estado_conec) values ('".$solicitud[0]."','".$_SESSION['id']."','".date("Y-m-d H:i:s", time())."','1')")){
        $miconexion->consulta("delete from notificaciones where id_noti = ".$id);
        $miconexion->consulta("update grupos set ultima_modificacion= '".date("Y-m-d H:i:s", time())."' where id_grupo='".$solicitud[0]."'");
        echo '<script>
        $container = $("#container_notify").notify();    
        create("default", { color:"background:rgba(16,122,43,0.8);", enlace:"perfil.php?op=grupos&id='.$solicitud[0].'" ,title:"Notificaci&oacute;n", text:"Ahora formas parte del grupo. Presiona aqui para ver", imagen:"../assets/img/check.png"}); 
        $("#menu_izquierdo").load("menu.php");
        location.href = "perfil.php?op=grupos&id='.$solicitud[0].'";
        </script>';
      }else{
        echo '<script>
        $container = $("#container_notify").notify();  
        create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Algo ocurri&oacute;. <br> Por favor intente nuevamente.", imagen:"../assets/img/alert.png"});  
        </script>';
      }
    }elseif ($solicitud[1]!='') {
      if($miconexion->consulta("insert into alineacion (id_partido, id_user, posicion_event, fecha_alineacion, estado_alineacion) values ('".$solicitud[1]."','".$_SESSION['id']."', '0', '".date("Y-m-d H:i:s", time())."','1')")){
        $miconexion->consulta("delete from notificaciones where id_noti = ".$id);
        echo '<script>
        $container = $("#container_notify").notify();    
        create("default", { color:"background:rgba(16,122,43,0.8);", enlace:"perfil.php?op=alineacion&id='.$solicitud[1].'" ,title:"Notificaci&oacute;n", text:"Genial, has aceptado jugar en el partido. Presiona aqui para ver", imagen:"../assets/img/check.png"}); 
        $("#menu_izquierdo").load("menu.php");
        location.href = "perfil.php?op=alineacion&id='.$solicitud[1].'";
        </script>';
      }else{
        echo '<script>
        $container = $("#container_notify").notify();  
        create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Algo ocurri&oacute;. <br> Por favor intente nuevamente.", imagen:"../assets/img/alert.png"});  
        </script>';
      }
    }
  }
  if (@$act==21) {
    if ($miconexion->consulta("delete from notificaciones where id_noti = ".$id)) {
      echo '<script>
        $container = $("#container_notify").notify();    
        create("default", { color:"background:rgba(16,122,43,0.8);", enlace:"#" ,title:"Notificaci&oacute;n", text:"Has rechazado la solicitud :(", imagen:"../assets/img/check.png"}); 
        $("#menu_izquierdo").load("menu.php");
        </script>';
    }else {
        echo '<script>
        $container = $("#container_notify").notify();  
        create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Algo ocurri&oacute;. <br> Por favor intente nuevamente.", imagen:"../assets/img/alert.png"});  
        </script>';
    }
  }
  if (@$act==22) {
    if ($miconexion->consulta("select p.id_partido, p.nombre_partido, u.user, g.nombre_grupo, p.fecha_partido, p.hora_partido, p.hora_fin, p.estado_partido, u.nombres, u.apellidos, u.avatar, u.telefono, u.celular, u.email 
      from partidos p, grupos g, usuarios u 
      where p.id_grupo = g.id_grupo and p.id_user = u.id_user and p.id_partido = '".$id."'")) {
      $partido=$miconexion->consulta_lista();
      if ($partido[11] == '' && $partido[12] == '') {
        $partido[11] = 'No tiene un numero de contacto registrado';
      }
      echo '<script>
        document.getElementById("nom_partido").innerHTML = "'.$partido[1].'";
        document.getElementById("responsable").innerHTML = "'.$partido[8].' '.$partido[9].' ('.$partido[2].')";
        document.getElementById("contacto").innerHTML = "'.$partido[11].'  '.$partido[12].'";
        document.getElementById("email").innerHTML = "'.$partido[13].'";
        document.getElementById("grupo_partido").innerHTML = "'.$partido[3].'";
        document.getElementById("fecha").innerHTML = "'.$partido[4].'";
        document.getElementById("hora").innerHTML = "'.date('H:i', strtotime($partido[5])).' - '.date('H:i', strtotime($partido[6])).'";
        if ("'.$partido[7].'"=="1") {
          document.getElementById("estado").innerHTML = "Habilitado";
        }else if("'.$partido[7].'"=="2"){
          document.getElementById("estado").innerHTML = "Pendiente";
        };
        </script>';
    }else {
        echo '<script>
        $container = $("#container_notify").notify();  
        create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Algo ocurri&oacute;. <br> Por favor intente nuevamente.", imagen:"../assets/img/alert.png"});  
        </script>';
    }
  }
  if (@$act==23) {
    if ($miconexion->consulta("update partidos SET estado_partido='0' WHERE id_partido= '".$id."'")) {
      $miconexion->consulta("insert into notificaciones (id_user, id_partido, fecha_not, visto, responsable, tipo, mensaje) values('".$usm."','".$id."','".date("Y-m-d H:i:s", time())."','0','".$_SESSION['id']."','cambios','ha cancelado tu reservaci&oacute;n en el partido ')");
      echo '<script>
        $.get("../datos/cargarNotificaciones.php");
        calendario_centro();
        $container = $("#container_notify").notify();
        create("default", { color:"background:rgba(16,122,43,0.8);", enlace:"#" ,title:"Notificaci&oacute;n", text:"Se ha cancelado la reserva.", imagen:"../assets/img/check.png"}); 
        seend(1);
        </script>';
    }else {
        echo '<script>
        $container = $("#container_notify").notify();  
        create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Algo ocurri&oacute;. <br> Por favor intente nuevamente.", imagen:"../assets/img/alert.png"});  
        </script>';
    }
  }
  if (@$act==24) {
    if ($miconexion->consulta("delete from partidos where id_partido = '".$id."'")) {
      echo '<script>
        $.get("../datos/cargarTiempoEsperaPartidos.php");
        $container = $("#container_notify").notify();
        create("default", { color:"background:rgba(16,122,43,0.8);", enlace:"#" ,title:"Notificaci&oacute;n", text:"Se ha eliminado el partido.", imagen:"../assets/img/check.png"}); 
        $("#col_partidos_g").load("partidos_g.php?id='.$usm.'");
        </script>';
    }else {
        echo '<script>
        $container = $("#container_notify").notify();  
        create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Algo ocurri&oacute;. <br> Por favor intente nuevamente.", imagen:"../assets/img/alert.png"});  
        </script>';
    }
  }
  if (@$act==25) {
    if ($miconexion->consulta("update partidos SET estado_partido='1' WHERE id_partido= '".$id."'")) {
      $miconexion->consulta("insert into notificaciones (id_user, id_partido, fecha_not, visto, responsable, tipo, mensaje) values('".$usm."','".$id."','".date("Y-m-d H:i:s", time())."','0','".$_SESSION['id']."','cambios','ha aceptado tu reservaci&oacute;n en el partido ')");
      $miconexion->consulta("select id_grupo, fecha_partido, hora_partido FROM partidos where id_partido='".$id."'");
      $partido=$miconexion->consulta_lista();
      $miconexion->consulta("select ug.id_user FROM user_grupo ug, usuarios u where u.disponible ='1' and u.id_user = ug.id_user and ug.id_grupo='".$partido[0]."' and ug.id_user != '".$usm."'");
      for ($i=0; $i < $miconexion->numregistros(); $i++) { 
          $list=$miconexion->consulta_lista();
          $insert[$i] = "insert into notificaciones (id_user, id_partido, fecha_not, visto, responsable, tipo, mensaje) 
                          values ('".$list[0]."','".$id."','".date('Y-m-d H:i:s', time())."','0','".$usm."','solicitud',' te ha invitado a jugar el ".$partido[1]." a las ".date('g:i a', strtotime($partido[2]))." en el partido')";
      }
      for ($i=0; $i < count(@$insert); $i++) { 
          $miconexion->consulta($insert[$i]);
      }
      echo '<script>
        $.get("../datos/cargarNotificaciones.php");
        calendario_centro();
        $container = $("#container_notify").notify();
        create("default", { color:"background:rgba(16,122,43,0.8);", enlace:"#" ,title:"Notificaci&oacute;n", text:"Ha aceptado la reserva.", imagen:"../assets/img/check.png"}); 
        seend(1);
        </script>';
    }else {
        echo '<script>
        $container = $("#container_notify").notify();  
        create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Algo ocurri&oacute;. <br> Por favor intente nuevamente.", imagen:"../assets/img/alert.png"});  
        </script>';
    }
  }
  if (@$act==26) {
    if ($miconexion->consulta("delete from partidos where id_partido = '".$id."'")) {
      echo '<script>
        $container = $("#container_notify").notify();
        create("default", { color:"background:rgba(16,122,43,0.8);", enlace:"#" ,title:"Notificaci&oacute;n", text:"Se ha eliminado el partido.", imagen:"../assets/img/check.png"}); 
        $("#col_listar_partidos").load("listar_partidos.php");
        </script>';
    }else {
        echo '<script>
        $container = $("#container_notify").notify();  
        create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Algo ocurri&oacute;. <br> Por favor intente nuevamente.", imagen:"../assets/img/alert.png"});  
        </script>';
    }
  }
  if (@$act==27) {
    if ($miconexion->consulta("select motivo, fecha_reserva, hora_inicio, hora_fin, estado, id_reserva, id_grupo, email from reservas where id_reserva = '".$id."'")) {
    $partido=$miconexion->consulta_lista();
    if ($partido[6]!=null) {
      $miconexion->consulta("select nombre_grupo from grupos where id_grupo = '".$partido[6]."'");
      $grupo=$miconexion->consulta_lista();      
    }
      echo '<script>
        document.getElementById("motivo").innerHTML = "'.$partido[0].'";
        document.getElementById("fecha_reserva").innerHTML = "'.$partido[1].'";
        document.getElementById("hora_reserva").innerHTML = "'.date('H:i', strtotime($partido[2])).' - '.date('H:i', strtotime($partido[3])).'";
        if ("'.$partido[4].'"=="1") {
          document.getElementById("estado_reserva").innerHTML = "Reservado";
        }else if("'.$partido[4].'"=="2"){
          document.getElementById("estado_reserva").innerHTML = "Pendiente";
        };
        if ("'.$partido[6].'"== null || "'.$partido[7].'"==null) {
          document.getElementById("otorgado").innerHTML = "Nadie";
        }else{
          document.getElementById("otorgado").innerHTML = "'.$partido[7].' '.$grupo[0].'";
        };
        </script>';
    }else {
        echo '<script>
        $container = $("#container_notify").notify();  
        create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Algo ocurri&oacute;. <br> Por favor intente nuevamente.", imagen:"../assets/img/alert.png"});  
        </script>';
    }
  }
  if (@$act==28) {
    if ($miconexion->consulta("delete from reservas where id_reserva = '".$id."'")) {      
      echo '<script>
        calendario_centro();
        $("#cerrar_reserva").trigger("click");
        $container = $("#container_notify").notify();
        create("default", { color:"background:rgba(16,122,43,0.8);", enlace:"#" ,title:"Notificaci&oacute;n", text:"Has cancelado la reserva.", imagen:"../assets/img/check.png"}); 
        </script>';
    }else {
        echo '<script>
        $container = $("#container_notify").notify();  
        create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Algo ocurri&oacute;. <br> Por favor intente nuevamente.", imagen:"../assets/img/alert.png"});  
        </script>';
    }
  }
  if (@$act==29) {
    if ($miconexion->consulta("update partidos SET estado_partido='3' WHERE id_partido= '".$id."'")) {
      $miconexion->consulta("insert into notificaciones (id_user, id_partido, fecha_not, visto, responsable, tipo, mensaje) values('".$usm."','','".date("Y-m-d H:i:s", time())."','0','".$_SESSION['id']."','cambios','ha rechazado t&uacute; reservaci&oacute;n ')");
      echo '<script>
        $.get("../datos/cargarNotificaciones.php");
        calendario_centro();
        $container = $("#container_notify").notify();
        create("default", { color:"background:rgba(16,122,43,0.8);", enlace:"#" ,title:"Notificaci&oacute;n", text:"Se ha rechazado la reserva.", imagen:"../assets/img/check.png"}); 
        seend(1);
        </script>';
    }else {
        echo '<script>
        $container = $("#container_notify").notify();  
        create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Algo ocurri&oacute;. <br> Por favor intente nuevamente.", imagen:"../assets/img/alert.png"});  
        </script>';
    }
  }

  if (@$act==30) {
    if ($miconexion->consulta("update partidos SET estado_partido='3' WHERE id_partido = '".$id."'")) {
    $miconexion->consulta("insert into notificaciones (id_user, id_partido, fecha_not, visto, responsable, tipo, mensaje) values('".$usm."','".$id."','".date("Y-m-d H:i:s", time())."','0','".$_SESSION['id']."','reserva_expirada',' Su reserva para este partido ha sido cancelada, debido a que el administrador del centro deportivo no ha confirmado la aceptaci&oacute;n.')");
      echo '<script>
        
        $.get("../datos/cargarTiempoEsperaPartidos.php");
        
        $container = $("#container_notify").notify();
        create("default", { color:"background:rgba(16,122,43,0.8);", enlace:"#" ,title:"Notificaci&oacute;n", text:"Su reserva ha expirado.", imagen:"../assets/img/check.png"}); 
        </script>';
    }else {
        echo '<script>
        $container = $("#container_notify").notify();  
        create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Algo ocurri&oacute;. <br> Por favor intente nuevamente.", imagen:"../assets/img/alert.png"});  
        </script>';
    }
  }

  if (@$act==31) {
    if ($miconexion->consulta("select p.id_partido, p.nombre_partido, u.user, g.nombre_grupo, p.fecha_partido, p.hora_partido, p.hora_fin, p.estado_partido, u.nombres, u.apellidos
      from partidos p, grupos g, usuarios u 
      where p.id_grupo = g.id_grupo and p.id_user = u.id_user and p.id_partido = '".$id."'")) {
    $partido=$miconexion->consulta_lista();
      echo '<script>
        document.getElementById("nom_partido").innerHTML = "'.$partido[1].'";
        document.getElementById("responsable").innerHTML = "'.$partido[8].' '.$partido[9].' ('.$partido[2].')";
        document.getElementById("grupo_partido").innerHTML = "'.$partido[3].'";
        document.getElementById("fecha").innerHTML = "'.$partido[4].'";
        document.getElementById("hora").innerHTML = "'.date('H:i', strtotime($partido[5])).' - '.date('H:i', strtotime($partido[6])).'";
        if ("'.$partido[7].'"=="1") {
          document.getElementById("estado").innerHTML = "Habilitado";
        }else if("'.$partido[7].'"=="2"){
          document.getElementById("estado").innerHTML = "Pendiente";
        };
        </script>';
    }else {
        echo '<script>
        $container = $("#container_notify").notify();  
        create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Algo ocurri&oacute;. <br> Por favor intente nuevamente.", imagen:"../assets/img/alert.png"});  
        </script>';
    }
  }
  
 ?>