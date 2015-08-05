  <?php
  include("../static/site_config.php"); 
include ("../static/clase_mysql.php");
$miconexion = new clase_mysql;
$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
  session_start();
  global $notifi;
  $miconexion->consulta(" select co.email, g.id_grupo, g.nombre_grupo, p.id_partido, p.fecha, p.estado, ca.nombre_cancha, ca.num_max, co.id_convocatoria 
    FROM grupos g, partidos p, canchas ca, convocatoria co 
    where p.id_grupo = g.id_grupo and p.id_cancha = ca.id_cancha and co.email  = '".$_SESSION["email"]."' and co.id_partido = p.id_partido and co.estado=2  ");
  $cont1=$miconexion->numregistros();
  $mail;
  if ($cont1>0) {
    $miconexion->consulta(" select co.email, g.id_grupo, g.nombre_grupo, p.id_partido, p.fecha, p.estado, ca.nombre_cancha, ca.num_max, co.id_convocatoria, g.nombre_grupo 
    FROM grupos g, partidos p, canchas ca, convocatoria co 
    where p.id_grupo = g.id_grupo and p.id_cancha = ca.id_cancha and co.email  = '".$_SESSION["email"]."' and co.id_partido = p.id_partido and co.estado=2 ");
    $cont1=0;
    /*
for ($i=0; $i < $miconexion->numregistros(); $i++) {
      $notifi=$miconexion->consulta_lista();
      date_default_timezone_set('America/Guayaquil');
      $dstart = new DateTime($notifi[4]);
      $dend = new DateTime();
      $dend->format('Y-m-d H:i:s');
      if ($dstart > $dend) {
        $cont1 ++;
      }
  }*/

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
      echo "<p style='text-align:center; color:white;'>No hay sugerencias</p>";
  }
   ?> 
