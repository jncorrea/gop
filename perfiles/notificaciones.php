<?php
date_default_timezone_set('America/Guayaquil');
$dend = new DateTime();
$fecha = $dend->format('Y-m-d H:i:s');
$miconexion->consulta("select count(*) FROM notificaciones n, usuarios u where n.responsable = u.id_user and n.id_user = '".$_SESSION['id']."' and n.tipo != 'solicitud' and visto='0'");
$cont=$miconexion->consulta_lista();
?>
  <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-close-others="true">
  <i class="icon-bell"></i>
  <span class="badge badge-default">
  <?php echo $miconexion->numregistros(); ?></span>
  </a>
  <ul class="dropdown-menu">
    <li class="external">
      <h3><span class="bold"><?php echo $miconexion->numregistros() ?></span> notificaciones pendientes</h3>
    </li>
    <li>
      <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
        <?php 
        $miconexion->consulta("select u.user, u.avatar, u.sexo, n.responsable ,n.id_user, n.mensaje, n.fecha_not, n.visto, n.id_grupo, n.id_partido, n.id_noti FROM notificaciones n, usuarios u where n.responsable = u.id_user and n.id_user = '".$_SESSION['id']."' and n.tipo != 'solicitud'");
          for ($i=0; $i < $miconexion->numregistros(); $i++) { 
            $notificaciones=$miconexion->consulta_lista(); 
            if ($notificaciones[8]!=null) {
              if ($notificaciones[1]!="") {
                echo "<li>
                  <a><div class='col-lg-2 col-md-2 col-sm-2 col-xs-2' style='padding-left:0px;'><img style='width:30px; height:30px;' src='images/".$notificaciones[0].$notificaciones[1]."'/></div>
                  <div style='text-align:justify;'><strong> ".$notificaciones[0]." </strong>".$notificaciones[5]." <strong>".$notificaciones[8]."</strong></div></a>
                </li>";
              }else{
                if ($notificaciones[2]=="Masculino") {
                  echo "<li>
                  <a><div class='col-lg-2 col-md-2 col-sm-2 col-xs-2' style='padding-left:0px;'><img style='width:30px; height:30px;' src='../assets/img/user_masculino.png'/></div>
                  <div style='text-align:justify;'><strong> ".$notificaciones[0]." </strong>".$notificaciones[5]." <strong>".$notificaciones[8]."</strong></div></a>
                </li>"; 
                }elseif ($notificaciones[2]=="Femenino") {
                  echo "<li>
                  <a><div class='col-lg-2 col-md-2 col-sm-2 col-xs-2' style='padding-left:0px;'><img style='width:30px; height:30px;' src='../assets/img/user_femenino.png'/></div>
                  <div style='text-align:justify;'><strong> ".$notificaciones[0]." </strong>".$notificaciones[5]." <strong>".$notificaciones[8]."</strong></div></a>
                </li>";
                }
              } 
            }elseif ($notificaciones[9]!=null) {
              if ($notificaciones[1]!="") {
                echo "<li>
                  <a><div class='col-lg-2 col-md-2 col-sm-2 col-xs-2' style='padding-left:0px;'><img style='width:30px; height:30px;' src='images/".$notificaciones[0].$notificaciones[1]."'/></div>
                  <div style='text-align:justify;'><strong> ".$notificaciones[0]." </strong>".$notificaciones[5]." <strong>".$notificaciones[9]."</strong></div></a>
                </li>";
              }else{
                if ($notificaciones[2]=="Masculino") {
                  echo "<li>
                  <a><div class='col-lg-2 col-md-2 col-sm-2 col-xs-2' style='padding-left:0px;'><img style='width:30px; height:30px;' src='../assets/img/user_masculino.png'/></div>
                  <div style='text-align:justify;'><strong> ".$notificaciones[0]." </strong>".$notificaciones[5]." <strong>".$notificaciones[9]."</strong></div></a>
                </li>"; 
                }elseif ($notificaciones[2]=="Femenino") {
                  echo "<li>
                  <a><div class='col-lg-2 col-md-2 col-sm-2 col-xs-2' style='padding-left:0px;'><img style='width:30px; height:30px;' src='../assets/img/user_femenino.png'/></div>
                  <div style='text-align:justify;'><strong> ".$notificaciones[0]." </strong>".$notificaciones[5]." <strong>".$notificaciones[9]."</strong></div></a>
                </li>";
                }
              } 
            }
          } 
        ?>
      </ul>
    </li>
  </ul>