<?php
  $miconexion->consulta("select fecha, nomequipoa, nomequipob from partidos where id_partido ='".$id."' ");                 
  $cont = $miconexion->numcampos();
  $partidos=$miconexion->consulta_lista();
  $time=strtotime($partidos[0]);
  $fecha = date("d M Y H:i",$time);
?>
<div class="infor col-xs-12 col-sm-12 col-md-6 col-lg-6">
  <h3 style="text-align:center;"><img src="../assets/img/pupos.png" class="pupos"><?php echo "  Fecha ".$fecha ?></h2><hr style="padding:1%; margin:1%">
  <table style="width:100%; text-align:center;">
    <tr>
      <td>
        <h3 style="color:#4337B3; font-size:170%;"><?php echo $partidos[1] ?></h3>
      </td>
      <td>
        <h3 style="color:#EA2E40; font-size:170%;"><?php echo $partidos[2] ?></h3>
      </td>
    </tr>
  </table>
<div class ="cancha">
  <?php 
    for ($i=1; $i <= 40; $i++) { 
      echo "<div class='jugadores'><div id='".$i."' class='column ui-sortable'>";
      echo "</div></div>";
    }
   ?>  
</div>
</div>
<div class="infor col-xs-12 col-md-2">
  <h3 style="text-align:center;">Integrantes</h3><hr>  
  <?php
    $miconexion->consulta("select m.email, m.nombres, m.apellidos, m.avatar
      FROM miembros m, convocatoria c
      WHERE c.email = m.email and c.id_partido = $id");
      echo '<form method="post" action="../include/posiciones_cancha.php"class="form-horizontal" id="form_ubicacion">';
      echo '<input type="hidden" class="form-control" name="id_partido" value="'.$id.'">' ;        
      echo '<input type="hidden" class="form-control" name="equipoA" value="'.$partidos[1].'">' ;        
      echo '<input type="hidden" class="form-control" name="equipoB" value="'.$partidos[2].'">' ;        
      for ($i=0; $i < $miconexion->numregistros(); $i++) { 
        $posicion=$miconexion->consulta_lista();
        echo '<input type="hidden" class="form-control" name="'.$i.$posicion[0].'" value="'.$posicion[0].'">' ;
        echo '<input type="hidden" class="form-control" name="'.$posicion[0].'" id="in'.$i.'" value="">' ;
      }   
      echo '<button onclick="ubicar();" style="width:100%; display:inline-block;" type="submit" class="btn btn-default">Guardar</button>';

      echo '</form>';

    $miconexion->consulta("select m.email, m.nombres, m.apellidos, m.avatar, c.posicion
      FROM miembros m, convocatoria c 
      WHERE c.email = m.email and c.id_partido = $id");
      for ($i=0; $i < $miconexion->numregistros(); $i++) { 
        $alineacion=$miconexion->consulta_lista();
        echo '<div class="column ui-sortable">' ;
        if ($alineacion[3]==""){
          echo "<img class='jugador_img' src='../assets/img/user.jpg' 
          id='div".$i."' alt='".$alineacion[0]."'>";
        }else{
          echo "<img class='jugador_img' src='images/".$alineacion[0]."/".$alineacion[3]."' 
          id='div".$i."' alt='".$alineacion[0]."'>";        
        }
        echo '</div>';
        if ($alineacion[4]!="") {
          echo "<script>";
          echo "$('#div$i').appendTo('#$alineacion[4]')";
          echo "</script>";
        }
        $persona[$i] = $alineacion[0];
      }  
        echo '<div class="column ui-sortable"></div>' ;    
   ?>
</div>