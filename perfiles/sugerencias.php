<?php
global $notifi;
$miconexion->consulta("select g.nombre_grupo, p.nombre_partido, p.fecha_partido, p.hora_partido , cd.centro_deportivo, n.id_noti, n.id_partido 
  from notificaciones n, grupos g, partidos p, centros_deportivos cd 
  where n.tipo = 'sugerencia' and p.id_grupo = g.id_grupo and p.id_centro = cd.id_centro and n.id_user  = '".$_SESSION["id"]."' 
  and n.id_partido = p.id_partido and p.fecha_partido >= '".date('Y-m-d', time())."'");
$s =0 ;
$hora_comp = date('Y-m-d H:i:s', time());
for ($i=0; $i < @$miconexion->numregistros(); $i++) {
  $notifi=$miconexion->consulta_lista();
  $hora_p = strtotime($notifi[2]." ".$notifi[3]);
  if ($hora_comp <= date('Y-m-d H:i:s', $hora_p)) {
    if ($s==0) {
    echo '<li>
      <a href="javascript:;">
      <i class="icon-calendar"></i>
      <span class="title">Sugerencias</span>
      <span class="arrow "></span>    
      <ul class="sub-menu" id="list_sugerencias">';
  }
    echo "<li><a href='javascript:;'><i class='icon-calendar'></i>";
    echo "<span class='title'>";
    echo  "El grupo ".$notifi[0]." ha ofertado cupos para el partido ".$notifi[1]." a jugarse el ".$notifi[2]." a las ".$notifi[3]." 
    en ".$notifi[4].". Aceptas?<br>"; ?>
    <span class='label label-sm label-icon label-success' onclick='actualizar_notificacion("4","<?php echo $notifi[6] ?>");'>
    <i class='icon-ok'></i>
    </span>
    <span class='label label-sm label-icon label-danger' onclick='actualizar_notificacion("5","<?php echo $notifi[5] ?>");'>
    <i class='icon-remove'></i>
    </span></span></a></li><br>

    <?php 
    if ($i==@$miconexion->numregistros()-1) {
      echo "</ul>
          </li> ";
    }
    $s++; 
  }  
}
?> 
