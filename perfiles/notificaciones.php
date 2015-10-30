<?php
date_default_timezone_set('America/Guayaquil');
$dend = new DateTime();
$fecha = $dend->format('Y-m-d H:i:s');
$miconexion->consulta("select count(*) FROM notificaciones n, usuarios u where n.responsable = u.id_user and n.id_user = '".$_SESSION['id']."' and n.tipo != 'solicitud' and n.tipo!= 'sugerencia' and visto='0'");
$cont=$miconexion->consulta_lista();
$miconexion->consulta("select id_grupo, nombre_grupo FROM grupos");
for ($i=0; $i < $miconexion->numregistros(); $i++) { 
  $datos=$miconexion->consulta_lista();
  $grupos[$datos[0]]=$datos[1]; 
}
$miconexion->consulta("select id_partido, nombre_partido FROM partidos");
for ($i=0; $i < $miconexion->numregistros(); $i++) { 
  $datos=$miconexion->consulta_lista();
  $partidos[$datos[0]]=$datos[1]; 
}
$miconexion->consulta("select distinct(n.id_partido), p.id_centro from notificaciones n, partidos p where n.mensaje LIKE '%ha solicitado reservar%' and n.id_partido = p.id_partido and n.id_user = '".$_SESSION['id']."'");
for ($i=0; $i < $miconexion->numregistros(); $i++) { 
  $datos=$miconexion->consulta_lista();
  $centros[$datos[0]]=$datos[1]; 
}
?>
  <a href="javascript:;" title="Notificaciones" class="dropdown-toggle" data-toggle="dropdown" data-close-others="true" onclick="actualizar_notificacion('16');">
  <i class="icon-bell"></i>
  <span class="badge badge-default" id="contador1">
  <?php echo $cont[0]; ?></span>
  </a>
  <ul class="dropdown-menu">
    <li class="external">
      <h3><span class="bold" id="contador2"><?php echo $cont[0]; ?></span> notificaciones pendientes</h3>
    </li>
    <li>
      <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283" id="list_notifi">
        <?php 
        $act = 17;
        $miconexion->consulta("select u.user, u.avatar, u.sexo, n.responsable ,n.id_user, n.mensaje, n.fecha_not, n.visto, n.id_grupo, n.id_partido, n.id_noti, n.tipo, n.id_campeonato FROM notificaciones n, usuarios u where n.responsable = u.id_user and n.id_user = '".$_SESSION['id']."' and n.tipo != 'solicitud' and n.tipo!='sugerencia' order by n.fecha_not desc");
          for ($i=0; $i < $miconexion->numregistros(); $i++) { 
            $notificaciones=$miconexion->consulta_lista();
                if ($notificaciones[11]=="reserva_expirada") {

                  echo "<li>
                  <a href='' onclick='actualizar_notificacion(".$act.",".$notificaciones[10].")' style='text-decoration:none;'><div class='col-lg-2 col-md-2 col-sm-2 col-xs-2' style='padding-left:0px;'><img style='width:30px; height:30px;' src='../assets/img/denegado.png'/></div>
                  <div style='text-align:justify;'><strong>".strtoupper($partidos[$notificaciones[9]]). "</strong>".utf8_decode($notificaciones[5])." </div></a>
                </li>";

                }else{

                  if ($notificaciones[8]!=null) {
                    if ($notificaciones[1]!="") {
                      echo "<li>
                        <a href='perfil.php?op=grupos&id=".$notificaciones[8]."' onclick='actualizar_notificacion(".$act.",".$notificaciones[10].")' style='text-decoration:none;'><div class='col-lg-2 col-md-2 col-sm-2 col-xs-2' style='padding-left:0px;'><img style='width:30px; height:30px;' src='images/".$notificaciones[0].$notificaciones[1]."'/></div>
                        <div style='text-align:justify;'><strong> ".$notificaciones[0]." </strong>".utf8_decode($notificaciones[5])." <strong>".$grupos[$notificaciones[8]]."</strong></div></a>
                      </li>";
                    }else{
                      if ($notificaciones[2]=="Masculino") {
                        echo "<li>
                        <a href='perfil.php?op=grupos&id=".$notificaciones[8]."' onclick='actualizar_notificacion(".$act.",".$notificaciones[10].")' style='text-decoration:none;'><div class='col-lg-2 col-md-2 col-sm-2 col-xs-2' style='padding-left:0px;'><img style='width:30px; height:30px;' src='../assets/img/user_masculino.png'/></div>
                        <div style='text-align:justify;'><strong> ".$notificaciones[0]." </strong>".utf8_decode($notificaciones[5])." <strong>".$grupos[$notificaciones[8]]."</strong></div></a>
                      </li>"; 
                      }elseif ($notificaciones[2]=="Femenino") {
                        echo "<li>
                        <a href='perfil.php?op=grupos&id=".$notificaciones[8]."' onclick='actualizar_notificacion(".$act.",".$notificaciones[10].")' style='text-decoration:none;'><div class='col-lg-2 col-md-2 col-sm-2 col-xs-2' style='padding-left:0px;'><img style='width:30px; height:30px;' src='../assets/img/user_femenino.png'/></div>
                        <div style='text-align:justify;'><strong> ".$notificaciones[0]." </strong>".utf8_decode($notificaciones[5])." <strong>".$grupos[$notificaciones[8]]."</strong></div></a>
                      </li>";
                      }
                    } 
                  }elseif ($notificaciones[9]!=null) {
                    $mensaje = substr($notificaciones[5], 0, 23);
                    $comp_m = strnatcasecmp ($mensaje, "ha solicitado reservar");
                    if ($comp_m == 0){
                      if ($notificaciones[1]!="") {
                        echo "<li>
                          <a href='perfil.php?op=canchas&x=calendar&id=".$centros[$notificaciones[9]]."' onclick='actualizar_notificacion(".$act.",".$notificaciones[10].")' style='text-decoration:none;'><div class='col-lg-2 col-md-2 col-sm-2 col-xs-2' style='padding-left:0px;'><img style='width:30px; height:30px;' src='images/".$notificaciones[0].$notificaciones[1]."'/></div>
                          <div style='text-align:justify;'><strong> ".$notificaciones[0]." </strong>".utf8_decode($notificaciones[5])." <strong>".$partidos[$notificaciones[9]]."</strong></div></a>
                        </li>";
                      }else{
                        if ($notificaciones[2]=="Masculino") {
                          echo "<li>
                          <a href='perfil.php?op=canchas&x=calendar&id=".$centros[$notificaciones[9]]."' onclick='actualizar_notificacion(".$act.",".$notificaciones[10].")' style='text-decoration:none;'><div class='col-lg-2 col-md-2 col-sm-2 col-xs-2' style='padding-left:0px;'><img style='width:30px; height:30px;' src='../assets/img/user_masculino.png'/></div>
                          <div style='text-align:justify;'><strong> ".$notificaciones[0]." </strong>".utf8_decode($notificaciones[5])." <strong>".$partidos[$notificaciones[9]]."</strong></div></a>
                        </li>"; 
                        }elseif ($notificaciones[2]=="Femenino") {
                          echo "<li>
                          <a href='perfil.php?op=canchas&x=calendar&id=".$centros[$notificaciones[9]]."' onclick='actualizar_notificacion(".$act.",".$notificaciones[10].")' style='text-decoration:none;'><div class='col-lg-2 col-md-2 col-sm-2 col-xs-2' style='padding-left:0px;'><img style='width:30px; height:30px;' src='../assets/img/user_femenino.png'/></div>
                          <div style='text-align:justify;'><strong> ".$notificaciones[0]." </strong>".utf8_decode($notificaciones[5])." <strong>".$partidos[$notificaciones[9]]."</strong></div></a>
                        </li>";
                        }
                      }
                    }else{
                      if ($notificaciones[1]!="") {
                        echo "<li>
                          <a href='perfil.php?op=alineacion&id=".$notificaciones[9]."' onclick='actualizar_notificacion(".$act.",".$notificaciones[10].")' style='text-decoration:none;'><div class='col-lg-2 col-md-2 col-sm-2 col-xs-2' style='padding-left:0px;'><img style='width:30px; height:30px;' src='images/".$notificaciones[0].$notificaciones[1]."'/></div>
                          <div style='text-align:justify;'><strong> ".$notificaciones[0]." </strong>".utf8_decode($notificaciones[5])." <strong>".$partidos[$notificaciones[9]]."</strong></div></a>
                        </li>";
                      }else{
                        if ($notificaciones[2]=="Masculino") {
                          echo "<li>
                          <a href='perfil.php?op=alineacion&id=".$notificaciones[9]."' onclick='actualizar_notificacion(".$act.",".$notificaciones[10].")' style='text-decoration:none;'><div class='col-lg-2 col-md-2 col-sm-2 col-xs-2' style='padding-left:0px;'><img style='width:30px; height:30px;' src='../assets/img/user_masculino.png'/></div>
                          <div style='text-align:justify;'><strong> ".$notificaciones[0]." </strong>".utf8_decode($notificaciones[5])." <strong>".$partidos[$notificaciones[9]]."</strong></div></a>
                        </li>"; 
                        }elseif ($notificaciones[2]=="Femenino") {
                          echo "<li>
                          <a href='perfil.php?op=alineacion&id=".$notificaciones[9]."' onclick='actualizar_notificacion(".$act.",".$notificaciones[10].")' style='text-decoration:none;'><div class='col-lg-2 col-md-2 col-sm-2 col-xs-2' style='padding-left:0px;'><img style='width:30px; height:30px;' src='../assets/img/user_femenino.png'/></div>
                          <div style='text-align:justify;'><strong> ".$notificaciones[0]." </strong>".utf8_decode($notificaciones[5])." <strong>".$partidos[$notificaciones[9]]."</strong></div></a>
                        </li>";
                        }
                      }
                    } 
                  }
                }            
          } 
        ?>
      </ul>
    </li>
  </ul>