<?php
  $miconexion->consulta("select p.fecha, p.nomequipoa, p.nomequipob, c.nombre_cancha, c.direccion_cancha
    from partidos p, canchas c 
    where c.id_cancha = p.id_cancha and id_partido ='".$id."' ");                 
  $cont = $miconexion->numcampos();
  global $partida1;
  $partidos1=$miconexion->consulta_lista();
  $time=strtotime($partidos1[0]);
  global $fecha;
  $fecha = date("d M Y H:i",$time);

  
?>

<div class="infor col-xs-12 col-sm-12 col-md-6 col-lg-6" id="print">
  <h3 style="text-align:center;"><img src="../assets/img/pupos.png" class="pupos"><?php echo "  Fecha ".$fecha ?></h3><hr style="padding:1%; margin:1%">

  <table style="width:100%; text-align:center;">
    <tr>
      <td>
        <h3 style="color:#4337B3; font-size:170%;"><?php echo $partidos1[1] ?></h3>
      </td>
      <td>
        <h3 style="color:#EA2E40; font-size:170%;"><?php echo $partidos1[2] ?></h3>
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

<div class="infor col-xs-12 col-sm-12 col-md-6 col-lg-6" id="print1">



<form method="post" action="../include/insertar_oferta.php" enctype="multipart/form-data" class="form-horizontal">
<?php
      
      echo "<input type='hidden' name='id' value='".$id."'>";

?>

  
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-6">
      <button type="submit" class="btn btn-default" style= "float:right;">Ofertar cupos a otros miembros</button>
    </div>
  </div>
</form>

</div>

<div class="infor col-xs-12 col-sm-12 col-md-6 col-lg-6" id="print2">

<div style="width:85%; display:inline-block; text-align:center;">    
    <h1 style= "text-align: center; color:#000000; font-size:24px"> Comentarios <br> </h1>  
</div>



<form method="post" action="../include/insertar_comentario.php" enctype="multipart/form-data" class="form-horizontal">
<?php

      date_default_timezone_set('America/Lima');
      $fecha_actual=strftime("%Y-%m-%d %H:%M:%S");
      
      echo "<input type='hidden' name='bd' value='comentarios'>";
      echo "<input type='hidden' name='email' value='".$_SESSION["email"]."'>";
      echo "<input type='hidden' name='id_partido' value=".$id.">";
      echo "<input type='hidden' name='fecha' value='".$fecha_actual."'>";

?>

  <div class="form-group">    
    <a href="#" class="col-sm-2 control-label"> 
      <?php
      echo "<img class='avatar' src='images/".$_SESSION["email"]."/".$lista[6]."' style='width:70%; height:25%' > </a> ";
      ?>      
    <div class="col-sm-9">
      <textarea rows="3" class="form-control" name="comentario" placeholder="Ingrese su comentario.." required>
      
      </textarea>
      
    </div>
  </div>

  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-9">
      <button type="submit" class="btn btn-default" style= "float:right;">Guardar</button>
    </div>
  </div>
</form>



<div class="row infor" style="width: 90%;">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">       
            <h4>Comentarios    
                             
                <a href="#" style="position: absolute; top: 0; left: 90%;">
                  <span id="min" class="glyphicon glyphicon-chevron-down" onclick="mostrar('misComentarios'); return false"></span></a>
                </h4>
                <div id="misComentarios" style="display:none;">
                  
                <?php
                $miconexion->consulta("select  m.avatar, c.comentario, m.email  from comentarios c, miembros m where c.email=m.email and c.id_partido=".$id." ORDER BY c.fecha ASC ");
                    
                    for ($i=0; $i <$miconexion->numregistros(); $i++) { 
                        $lista_comen=$miconexion->consulta_lista();

                        echo "<article class='item'>";
                        echo "<p> ".$lista_comen[1]."</p>";
                        echo "<footer1>";
                        echo "<a href='#' class='avatar'><img src='images/".$lista_comen[2]."/".$lista[6]."' ></a>";
                        echo "<a href='#'>".$lista_comen[2]."</a>";
                        echo "<time datetime='2012-04-05T10:30:21+00:00 ' pubdate> </time>";
                        echo "</footer1>";
                        echo "</article>";
                                            
                    }
                ?>                    
                  </div>


          </div>  
        </div>
</div>


<div class="infor col-xs-12 col-md-2">

  <button type="submit" onclick="capturar();" style="width:100%; display:inline-block;" class="btn btn-success">
    Notificar <span class="glyphicon glyphicon-envelope"></span>
  </button>
  <form method="POST" enctype="multipart/form-data" action="../include/notificar_partido.php" id="myForm">
      <input type="hidden" name="id_partido" value="<?php echo $id ?>" />
      <input type="hidden" name="fecha" value="<?php echo $fecha ?>" />
      <input type="hidden" name="lugar" value="<?php echo $partidos1[3] ?>" />
      <input type="hidden" name="direccion" value="<?php echo $partidos1[4] ?>" />
      <input type="hidden" name="img_val" id="img_val" value="" />
  </form>
  <h3 style="text-align:center;">Integrates</h3><hr>   

  <?php
    $miconexion->consulta("select m.email, m.nombres, m.apellidos, m.avatar
      FROM miembros m, convocatoria c
      WHERE c.email = m.email and c.id_partido = $id and c.estado=1");
      echo '<form method="post" action="../include/posiciones_cancha.php"class="form-horizontal" id="form_ubicacion">';
      echo '<input type="hidden" class="form-control" name="id_partido" value="'.$id.'">' ;        
      echo '<input type="hidden" class="form-control" name="equipoA" value="'.$partidos1[1].'">' ;        
      echo '<input type="hidden" class="form-control" name="equipoB" value="'.$partidos1[2].'">' ;        
      for ($i=0; $i < $miconexion->numregistros(); $i++) { 
        $posicion=$miconexion->consulta_lista();
        echo '<input type="hidden" class="form-control" name="'.$i.$posicion[0].'" value="'.$posicion[0].'">' ;
        echo '<input type="hidden" class="form-control" name="'.$posicion[0].'" id="in'.$i.'" value="">' ;
      }   
      echo '<button onclick="ubicar();" style="width:100%; display:inline-block;" type="submit" class="btn btn-default">
      Guardar Cambios</button>';

      echo '</form>';

    $miconexion->consulta("select m.email, m.nombres, m.apellidos, m.avatar, c.posicion
      FROM miembros m, convocatoria c 
      WHERE c.email = m.email and c.id_partido = $id and c.estado = 1");
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