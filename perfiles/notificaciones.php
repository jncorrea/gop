<h4 style="text-align:center;">Notificaciones</h4>
<table class="table table-striped">  
  <strong>Invitaciones a Grupos</strong>
  <?php
  $miconexion->consulta("select g.id_grupo, g.nombre_grupo, gm.estado 
    from grupos g, grupos_miembros gm 
    where g.id_grupo = gm.id_grupo and gm.email='".$_SESSION["email"]."' ");
  $cont = 0;
  for ($i=0; $i < $miconexion->numregistros(); $i++) { 
    $invitaciones=$miconexion->consulta_lista();
    if ($invitaciones[2]=="0") {
    echo "<tr>";                
    echo  "<td>".$invitaciones[1]."</td>";
    echo  "<td><a href='perfil.php?op=grupos&act=2&id=".$invitaciones[0]."'><span class='icon-checkmark3'></span></a></td>";
    echo  "<td><a href='perfil.php?op=grupos&act=3&id=".$invitaciones[0]."'><span class='icon-cancel2'></span></a></td>";
    echo "</tr>"; 
    $cont++;
    }
  }
  if ($cont==0) {
      echo "<tr><td style='text-align:center;'>No tiene solicitudes pendientes</td></tr>";
  }
   ?>            
</table>