  <?php
  include("../static/site_config.php"); 
include ("../static/clase_mysql.php");
$miconexion = new clase_mysql;
$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
  session_start();
  global $notifi;
  $miconexion->consulta(" select a.id_user, g.id_grupo, g.nombre_grupo, p.id_partido, p.fecha_partido, p.estado_partido, cd.centro_deportivo, cd.num_jugadores, a.id_alineacion 
    FROM grupos g, partidos p, centros_deportivos cd, alineacion a 
    where p.id_grupo = g.id_grupo and p.id_centro = cd.id_centro and a.id_user  = '".$_SESSION["id"]."' and a.id_partido = p.id_partido and a.estado_alineacion='2'  ");
  $cont1=$miconexion->numregistros();
  $mail;
  if ($cont1>0) {
    $miconexion->consulta(" select a.id_user, g.id_grupo, g.nombre_grupo, p.id_partido, p.fecha_partido, p.estado_partido, cd.centro_deportivo, cd.num_jugadores, a.id_alineacion, g.nombre_grupo 
    FROM grupos g, partidos p, centros_deportivos cd, alineacion a
    where p.id_grupo = g.id_grupo and p.id_centro = cd.id_centro and a.id_user  = '".$_SESSION["id"]."' and a.id_partido = p.id_partido and a.estado_alineacion='2' ");
    $cont1=0;

    for ($i=0; $i < $miconexion->numregistros(); $i++) {
      $notifi=$miconexion->consulta_lista();
        echo "<li><a href='javascript:;'><i class='icon-calendar'></i>";
        echo "<span class='title'>";
        echo  "Hay cupos disponibles: Grupo: ".$notifi[9].", el ".$notifi[4].". Te unes? <br>"; ?>
        <span class='label label-sm label-icon label-success' onclick='actualizar_notificacion("4","<?php echo $notifi[8] ?>");'>
        <i class='icon-ok'></i>
        </span>
        <span class='label label-sm label-icon label-danger' onclick='actualizar_notificacion("5","<?php echo $notifi[8] ?>");'>
        <i class='icon-remove'></i>
        </span></span></a></li><br>
        <?php      
    }

    
  }else if ($cont1==0) {
    echo "<li><a href='javascript:;'><i class='icon-calendar'></i>";
    echo "<span class='title'>";
    echo  "No hay sugerencias</span></a></li>";
  }
   ?> 
