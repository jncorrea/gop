
<h4 style="text-align:center;">Notificaciones</h4>

<table class="table table-striped">  
  <strong>Invitaciones a Grupos</strong>
  <?php
  $miconexion->consulta("select g.id_grupo, g.nombre_grupo, gm.estado 
    from grupos g, grupos_miembros gm 
    where g.id_grupo = gm.id_grupo and gm.email='".$_SESSION["email"]."' and estado=0 ");
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
<table class="table table-striped">  
  <strong>Invitaciones a Partidos</strong>
  <?php
  $miconexion->consulta("select gm.email from grupos_miembros gm left join convocatoria c on gm.email = c.email where c.email IS NULL and gm.email='".$_SESSION['email']."'");
  $cont = $miconexion->numregistros();;
  $mail;
  if ($cont>0) {
    for ($i=0; $i < $cont; $i++) {
      $lista=$miconexion->consulta_lista();
      $x="".$lista[0]."";
      $mail[$i] = $x;
    }
    for ($j=0; $j <$cont; $j++) { 
      echo "<tr>";                
      echo  "<td>".$mail[$j]."</td>";
      echo  "<td><a title='Aceptar' href='perfil.php?op=grupos&act=2&id=".$invitaciones[0]."'><span class='glyphicon glyphicon-ok'></span></a></td>";
      echo  "<td><a title='Rechazar' href='perfil.php?op=grupos&act=3&id=".$invitaciones[0]."'><span class='glyphicon glyphicon-remove'></span></a></td>";
      echo "</tr>"; 
    }
  }
  if ($cont==0) {
      echo "<tr><td style='text-align:center;'>No tiene solicitudes pendientes</td></tr>";
  }
   ?>            
</table>
