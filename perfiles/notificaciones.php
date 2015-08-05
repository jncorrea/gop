<?php
include("../static/site_config.php"); 
include ("../static/clase_mysql.php");
session_start();
  $miconexion = new clase_mysql;
  $miconexion->conectar($db_name,$db_host, $db_user,$db_password);
  date_default_timezone_set('America/Guayaquil');
  $dend = new DateTime();
  $fecha = $dend->format('Y-m-d H:i:s');
  $miconexion->consulta("select count(*) from grupos g, grupos_miembros gm where g.id_grupo = gm.id_grupo and gm.email='".$_SESSION['email']."' and estado=0 ");
  $num=$miconexion->consulta_lista();
  $miconexion->consulta("select count(*) 
    FROM grupos_miembros gm, grupos g, partidos p, canchas ca, convocatoria co 
    where gm.id_grupo = g.id_grupo and p.id_grupo = g.id_grupo and p.id_cancha = ca.id_cancha and co.email = gm.email and 
    co.id_partido = p.id_partido and gm.email = '".$_SESSION['email']."' and co.estado=0 and p.fecha > '".$fecha."'");
  $cont=$miconexion->consulta_lista();
?>
  <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
  <i class="icon-bell"></i>
  <span class="badge badge-default">
  <?php echo $num[0]+$cont[0]; ?></span>
  </a>
  <ul class="dropdown-menu">
    <li class="external">
      <h3><span class="bold"><?php echo $num[0]+$cont[0]; ?></span> notificaciones pendientes</h3>
    </li>
    <li>
      <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
        <?php
          $inv = $num[0]+$cont[0];
          $miconexion->consulta("select g.id_grupo, g.nombre_grupo, gm.estado 
                  from grupos g, grupos_miembros gm 
                  where g.id_grupo = gm.id_grupo and gm.email='".$_SESSION['email']."' and estado=0 ");
          $cont = 0;
          for ($i=0; $i < $miconexion->numregistros(); $i++) { 
            $invitaciones=$miconexion->consulta_lista();
            if ($invitaciones[2]=="0") {
              echo "<li><a href='javascript:;'>";?>
              <span class='details' >
                  <span class='label label-sm label-icon label-success' onclick='actualizar_notificacion("2","<?php echo $invitaciones[0] ?>");'>
                  <i class='icon-ok'></i>
                </span>
                <span class='label label-sm label-icon label-danger' onclick='actualizar_notificacion("3","<?php echo $invitaciones[0] ?>");'>
                  <i class='icon-remove'></i>
                </span>         
              <?php 
              echo  "Te han invitado a unirte a <strong>".$invitaciones[1]. "</strong></span></a></li>"; 
              $cont++;
              }
          }
          $miconexion->consulta("select gm.email, g.id_grupo, g.nombre_grupo, p.id_partido, p.fecha, p.estado, ca.nombre_cancha, ca.num_max, co.id_convocatoria
            FROM grupos_miembros gm, grupos g, partidos p, canchas ca, convocatoria co 
            where gm.id_grupo = g.id_grupo and p.id_grupo = g.id_grupo and p.id_cancha = ca.id_cancha and co.email = gm.email and co.id_partido = p.id_partido 
            and gm.email = '".$_SESSION['email']."' and co.estado=0");
            for ($i=0; $i < $miconexion->numregistros(); $i++) {
              $notifi=$miconexion->consulta_lista();
              echo "<li><a href='javascript:;'>";
              echo "<span class='details'>"?>
                  <span class='label label-sm label-icon label-success' onclick='actualizar_notificacion("4","<?php echo $notifi[8] ?>");'>
                  <i class='icon-ok'></i>
                </span>
                <span class='label label-sm label-icon label-danger' onclick='actualizar_notificacion("5","<?php echo $notifi[8] ?>");'>
                  <i class='icon-remove'></i>
                </span>
                <?php                 
              echo  "Tienes un nuevo partido en la cancha ".$notifi[6].", el ".$notifi[4].". Te unes? </span></a></li>"; 
                $cont++;
            }                   
        ?>
      </ul>
    </li>
  </ul>