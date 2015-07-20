
<h4 style="text-align:center;">Notificaciones</h4>
<?php
  $miconexion->consulta("select g.id_grupo, g.nombre_grupo, gm.estado 
    from grupos g, grupos_miembros gm 
    where g.id_grupo = gm.id_grupo and gm.email='".$_SESSION["email"]."' and estado=0 ");
  $num=$miconexion->numregistros();
?>
<div class="col-xs-12" style="padding-bottom:1em;"> 
  <strong>Invitaciones a Grupos   <span class="badge"><?php echo $num; ?></span>
    <a href="#" style="position: absolute; top: 0; left: 90%;">
      <span id="min" class="glyphicon glyphicon-chevron-down" onclick="mostrar('notGrupos'); return false"></span>
    </a>
  </strong>
</div> 
<table class="table table-striped" id="notGrupos" style="display:none;">
  <?php
  $cont = 0;
  for ($i=0; $i < $miconexion->numregistros(); $i++) { 
    $invitaciones=$miconexion->consulta_lista();
    if ($invitaciones[2]=="0") {
    echo "<tr>";                
    echo  "<td>".$invitaciones[1]."</td>";
    echo  "<td><a title='Aceptar' href='perfil.php?op=grupos&act=2&id=".$invitaciones[0]."'><span class='glyphicon glyphicon-ok'></span></a></td>";
    echo  "<td><a title='Rechazar' href='perfil.php?op=grupos&act=3&id=".$invitaciones[0]."'><span class='glyphicon glyphicon-remove'></span></a></td>";
    echo "</tr>"; 
    $cont++;
    }
  }
  if ($cont==0) {
      echo "<tr><td style='text-align:center;'>No tiene solicitudes pendientes</td></tr>";
  }
   ?>            
</table>

<?php 
  $miconexion->consulta("select gm.email, g.id_grupo, g.nombre_grupo, p.id_partido, p.fecha, p.estado, ca.nombre_cancha, ca.num_max 
    FROM grupos_miembros gm, grupos g, partidos p, canchas ca, convocatoria co 
    where gm.id_grupo = g.id_grupo and p.id_grupo = g.id_grupo and p.id_cancha = ca.id_cancha and co.email = gm.email and co.id_partido = p.id_partido and gm.email = '".$_SESSION["email"]."' and co.estado=0");
  $cont = 0;  
  $dstart;
  $dend;
  for ($i=0; $i < $miconexion->numregistros(); $i++) {
      $notifi1=$miconexion->consulta_lista();
      date_default_timezone_set('America/Guayaquil');
      $dstart = new DateTime($notifi1[4]);
      $dend = new DateTime();
      $dend->format('Y-m-d H:i:s');
      if ($dstart > $dend) {
        $cont ++;
      }
  }
?>  
<div class="col-xs-12" style="padding-bottom:1em;"> 
  <strong>Invitaciones a Partidos   <span class="badge"><?php echo $cont; ?></span>
    <a href="#" style="position: absolute; top: 0; left: 90%;">
      <span id="min" class="glyphicon glyphicon-chevron-down" onclick="mostrar('notPartido'); return false"></span>
    </a>
  </strong>
</div>
<table class="table table-striped" id="notPartido" style="display:none;">
  <?php
  $mail;
  if ($cont>0) {
    $miconexion->consulta("select gm.email, g.id_grupo, g.nombre_grupo, p.id_partido, p.fecha, p.estado, ca.nombre_cancha, ca.num_max, co.id_convocatoria
    FROM grupos_miembros gm, grupos g, partidos p, canchas ca, convocatoria co 
    where gm.id_grupo = g.id_grupo and p.id_grupo = g.id_grupo and p.id_cancha = ca.id_cancha and co.email = gm.email and co.id_partido = p.id_partido and gm.email = '".$_SESSION["email"]."' and co.estado=0");
    for ($i=0; $i < $cont; $i++) {
      $notifi=$miconexion->consulta_lista();
      if ($dstart > $dend) {
        echo "<tr>";                
        echo  "<td>Tienes un nuevo partido.!<br>Fecha: ".$notifi[4]."<br>Lugar: ".$notifi[6]."<br>Grupo:".$notifi[2]."</td>";
        echo  "<td><a title='Aceptar' href='perfil.php?op=alineacion&act=4&id=".$notifi[8]."'><span class='glyphicon glyphicon-ok'></span></a></td>";
        echo  "<td><a title='Rechazar' href='perfil.php?op=alineacion&act=5&id=".$notifi[8]."'><span class='glyphicon glyphicon-remove'></span></a></td>";
        echo "</tr>";
      }
    }
  }
  if ($cont==0) {
      echo "<tr><td style='text-align:center;'>No tiene solicitudes pendientes</td></tr>";
  }
   ?>            
</table>

<?php
  $miconexion->consulta(" select co.email, g.id_grupo, g.nombre_grupo, p.id_partido, p.fecha, p.estado, ca.nombre_cancha, ca.num_max, co.id_convocatoria 
    FROM grupos g, partidos p, canchas ca, convocatoria co 
    where p.id_grupo = g.id_grupo and p.id_cancha = ca.id_cancha and co.email  = '".$_SESSION["email"]."' and co.id_partido = p.id_partido and co.estado=2  ");
  $cont1=$miconexion->numregistros();
?>

<div class="col-xs-12" style="padding-bottom:1em;"> 
  <strong>Invitaciones a Cupos Ofertado  <span class="badge"><?php echo $cont1; ?></span>
    <a href="#" style="position: absolute; top: 0; left: 90%;">
      <span id="min" class="glyphicon glyphicon-chevron-down" onclick="mostrar('notOfertas'); return false"></span>
    </a>
  </strong>
</div>
<table class="table table-striped" id="notOfertas" style="display:none;">
  <?php
  $mail;
  if ($cont1>0) {
    $miconexion->consulta(" select co.email, g.id_grupo, g.nombre_grupo, p.id_partido, p.fecha, p.estado, ca.nombre_cancha, ca.num_max, co.id_convocatoria 
    FROM grupos g, partidos p, canchas ca, convocatoria co 
    where p.id_grupo = g.id_grupo and p.id_cancha = ca.id_cancha and co.email  = '".$_SESSION["email"]."' and co.id_partido = p.id_partido and co.estado=2 ");
    
for ($i=0; $i < $miconexion->numregistros(); $i++) {
      $notifi1=$miconexion->consulta_lista();
      date_default_timezone_set('America/Guayaquil');
      $dstart = new DateTime($notifi1[4]);
      $dend = new DateTime();
      $dend->format('Y-m-d H:i:s');
      if ($dstart > $dend) {
        $cont ++;
      }
  }

    for ($i=0; $i < $cont1; $i++) {
      $notifi=$miconexion->consulta_lista();
      if ($dstart > $dend) {
        echo "<tr>";                
        echo  "<td>Se han ofertado cupos.!<br>Fecha: ".$notifi1[4]."<br>Lugar: ".$notifi1[6]."<br>Grupo:".$notifi1[2]."</td>";
        echo  "<td><a title='Aceptar' href='perfil.php?op=alineacion&act=6&idc=".$notifi1[8]."&id=".$notifi1[3]."'><span class='glyphicon glyphicon-ok'></span></a></td>";
        echo  "<td><a title='Rechazar' href='perfil.php?op=alineacion&act=7&idc=".$notifi1[8]."&id=".$notifi1[3]."'><span class='glyphicon glyphicon-remove'></span></a></td>";
        echo "</tr>";
      }
    }

    
  }
  if ($cont1==0) {
      echo "<tr><td style='text-align:center;'>No tiene Oferta de cupos disponibles</td></tr>";
  }
   ?>            
</table>