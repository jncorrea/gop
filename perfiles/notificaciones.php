<?php
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
          <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
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
                        echo "<li><a href='javascript:;'>";
                        echo "<span class='details'>
                            <span class='label label-sm label-icon label-success'>
                            <i class='icon-ok'></i>
                          </span>
                          <span class='label label-sm label-icon label-danger'>
                            <i class='icon-remove'></i>
                          </span>";                
                        echo  "Te han invitado a unirte a ".$invitaciones[1]. "</span></a></li>"; 
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
                        echo "<span class='details'>
                            <span class='label label-sm label-icon label-success'>
                            <i class='icon-ok'></i>
                          </span>
                          <span class='label label-sm label-icon label-danger'>
                            <i class='icon-remove'></i>
                          </span>";                
                        echo  "Tienes un nuevo partido en la cancha ".$notifi[6].", el ".$notifi[4].". Te unes? </span></a></li>"; 
                          $cont++;
                      }                   
                  ?>
                </ul>
              </li>
            </ul>
          </li>