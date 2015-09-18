<?php
date_default_timezone_set('America/Guayaquil');
$dend = new DateTime();
$fecha = $dend->format('Y-m-d H:i:s');
$miconexion->consulta("select count(*) FROM notificaciones n, usuarios u where n.responsable = u.id_user and n.id_user = '".$_SESSION['id']."' and n.tipo = 'solicitud' and visto='0'");
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
?>
  <a href="javascript:;" class="dropdown-toggle" title="Solicitudes" data-toggle="dropdown" data-close-others="true" onclick="actualizar_notificacion('19');">
  <i class="icon-group"></i>
  <span class="badge badge-default" id="solicitud1">
  <?php echo $cont[0]; ?></span>
  </a>
  <ul class="dropdown-menu">
    <li class="external">
      <h3><span class="bold" id="solicitud2"><?php echo $cont[0]; ?></span> solicitudes pendientes</h3>
    </li>
    <li>
      <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283" id="list_solicitud">
        <?php 
        $act = 20;
        $act2 = 21;
        $miconexion->consulta("select u.user, u.avatar, u.sexo, n.responsable ,n.id_user, n.mensaje, n.fecha_not, n.visto, n.id_grupo, n.id_partido, n.id_noti FROM notificaciones n, usuarios u where n.responsable = u.id_user and n.id_user = '".$_SESSION['id']."' and n.tipo = 'solicitud'");
          for ($i=0; $i < $miconexion->numregistros(); $i++) { 
            $notificaciones=$miconexion->consulta_lista(); 
            if ($notificaciones[8]!=null) {
              if ($notificaciones[1]!="") {
                echo "<li>
                  <a href='javascript:;'>
                  <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2' style='padding-left:0px;'>
                    <img style='width:30px; height:30px;' src='images/".$notificaciones[0].$notificaciones[1]."'/>
                  </div>
                  <div style='text-align:justify;'>
                    <strong> ".$notificaciones[0]." </strong>".utf8_decode($notificaciones[5])." <strong>".$grupos[$notificaciones[8]]."</strong>
                  </div>
                  <br>
                  <span class='details' >
                    <span class='label label-sm label-icon label-success' onclick='actualizar_notificacion(".$act.",".$notificaciones[10].");'>
                      <i class='icon-ok'></i>
                    </span>
                    <span class='label label-sm label-icon label-danger' onclick='actualizar_notificacion(".$act2.",".$notificaciones[10].");'>
                    <i class='icon-remove'></i>
                  </span>
                  </span>
                  </a>
                </li>";
              }else{
                if ($notificaciones[2]=="Masculino") {
                 echo "<li>
                  <a href='javascript:;'>
                  <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2' style='padding-left:0px;'>
                    <img style='width:30px; height:30px;' src='../assets/img/user_masculino.png'/>
                  </div>
                  <div style='text-align:justify;'>
                    <strong> ".$notificaciones[0]." </strong>".utf8_decode($notificaciones[5])." <strong>".$grupos[$notificaciones[8]]."</strong>
                  </div>
                  <br>
                  <span class='details' >
                    <span class='label label-sm label-icon label-success' onclick='actualizar_notificacion(".$act.",".$notificaciones[10].");'>
                      <i class='icon-ok'></i>
                    </span>
                    <span class='label label-sm label-icon label-danger' onclick='actualizar_notificacion(".$act2.",".$notificaciones[10].");'>
                    <i class='icon-remove'></i>
                  </span>
                  </span>
                  </a>
                </li>";
                }elseif ($notificaciones[2]=="Femenino") {
                  echo "<li>
                  <a href='javascript:;'>
                  <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2' style='padding-left:0px;'>
                    <img style='width:30px; height:30px;' src='../assets/img/user_femenino.png'/>
                  </div>
                  <div style='text-align:justify;'>
                    <strong> ".$notificaciones[0]." </strong>".utf8_decode($notificaciones[5])." <strong>".$grupos[$notificaciones[8]]."</strong>
                  </div>
                  <br>
                  <span class='details' >
                    <span class='label label-sm label-icon label-success' onclick='actualizar_notificacion(".$act.",".$notificaciones[10].");'>
                      <i class='icon-ok'></i>
                    </span>
                    <span class='label label-sm label-icon label-danger' onclick='actualizar_notificacion(".$act2.",".$notificaciones[10].");'>
                    <i class='icon-remove'></i>
                  </span>
                  </span>
                  </a>
                </li>";
                }
              } 
            }elseif ($notificaciones[9]!=null) {
              if ($notificaciones[1]!="") {
                echo "<li>
                  <a href='javascript:;'>
                  <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2' style='padding-left:0px;'>
                    <img style='width:30px; height:30px;' src='images/".$notificaciones[0].$notificaciones[1]."'/>
                  </div>
                  <div style='text-align:justify;'>
                    <strong> ".$notificaciones[0]." </strong>".utf8_decode($notificaciones[5])." <strong>".$partidos[$notificaciones[9]]."</strong>
                  </div>
                  <br>
                  <span class='details' >
                    <span class='label label-sm label-icon label-success' onclick='actualizar_notificacion(".$act.",".$notificaciones[10].");'>
                      <i class='icon-ok'></i>
                    </span>
                    <span class='label label-sm label-icon label-danger' onclick='actualizar_notificacion(".$act2.",".$notificaciones[10].");'>
                    <i class='icon-remove'></i>
                  </span>
                  </span>
                  </a>
                </li>";
              }else{
                if ($notificaciones[2]=="Masculino") {
                  echo "<li>
                  <a href='javascript:;'>
                  <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2' style='padding-left:0px;'>
                    <img style='width:30px; height:30px;' src='../assets/img/user_masculino.png'/>
                  </div>
                  <div style='text-align:justify;'>
                    <strong> ".$notificaciones[0]." </strong>".utf8_decode($notificaciones[5])." <strong>".$partidos[$notificaciones[9]]."</strong>
                  </div>
                  <br>
                  <span class='details' >
                    <span class='label label-sm label-icon label-success' onclick='actualizar_notificacion(".$act.",".$notificaciones[10].");'>
                      <i class='icon-ok'></i>
                    </span>
                    <span class='label label-sm label-icon label-danger' onclick='actualizar_notificacion(".$act2.",".$notificaciones[10].");'>
                    <i class='icon-remove'></i>
                  </span>
                  </span>
                  </a>
                </li>";
                }elseif ($notificaciones[2]=="Femenino") {
                  echo "<li>
                  <a href='javascript:;'>
                  <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2' style='padding-left:0px;'>
                    <img style='width:30px; height:30px;' src='../assets/img/user_femenino.png'/>
                  </div>
                  <div style='text-align:justify;'>
                    <strong> ".$notificaciones[0]." </strong>".utf8_decode($notificaciones[5])." <strong>".$partidos[$notificaciones[9]]."</strong>
                  </div>
                  <br>
                  <span class='details' >
                    <span class='label label-sm label-icon label-success' onclick='actualizar_notificacion(".$act.",".$notificaciones[10].");'>
                      <i class='icon-ok'></i>
                    </span>
                    <span class='label label-sm label-icon label-danger' onclick='actualizar_notificacion(".$act2.",".$notificaciones[10].");'>
                    <i class='icon-remove'></i>
                  </span>
                  </span>
                  </a>
                </li>";
                }
              } 
            }
          } 
        ?>
      </ul>
    </li>
  </ul>