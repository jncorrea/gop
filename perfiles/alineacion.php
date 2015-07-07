<div class="col-xs-12 col-md-8">
  
<div class ="cancha">
  <?php 
    for ($i=0; $i < 30; $i++) { 
      echo "<div class='jugadores'><div id='".$i."' class='column ui-sortable'></div></div>";
    }
   ?>  
</div>
</div>
<div class="col-xs-6 col-md-4">
  <a href="#" style="position: absolute; top: 0; left: 90%;">
                  <span id="min" class="glyphicon glyphicon-minus" onclick="ubicar();"></span></a>
  
  <?php
  /*function ubicar(){
    echo "<script>alert('hola')</script>";
    for ($i=0; $i < count($persona); $i++) { 
      echo "$i";
      echo "<script>          
            email = document.getElementById($persona[$i]);
            console.log($(email).parent().attr('id'));</script>
            "
    }   
  }*/ 
    $miconexion->consulta("select m.email, m.nombres, m.apellidos, m.avatar 
      FROM miembros m, convocatoria c 
      WHERE c.email = m.email and c.id_partido = $id");
      echo '<form method="post" action="../include/posiciones_cancha.php"class="form-horizontal" id="form_ubicacion">';

      for ($i=0; $i < $miconexion->numregistros(); $i++) { 
        $posicion=$miconexion->consulta_lista();
        echo '<input type="hidden" class="form-control" name="'.$posicion[0].'" id="in'.$i.'" value="">' ;
      }   
      echo '<button onclick="ubicar();" style="width:50%; display:inline-block;" type="submit" class="btn btn-default">Guardar</button>';

      echo '</form>';

    $miconexion->consulta("select m.email, m.nombres, m.apellidos, m.avatar 
      FROM miembros m, convocatoria c 
      WHERE c.email = m.email and c.id_partido = $id");
      for ($i=0; $i < $miconexion->numregistros(); $i++) { 
        $alineacion=$miconexion->consulta_lista();
        echo '<div class="column ui-sortable">' ;
        if ($alineacion[3]==""){
          echo "<img src='../assets/img/user.jpg' 
          id='div".$i."' alt='".$alineacion[0]."' style='width:117px; height:105px; padding:3%;'>";
        }else{
          echo "<img src='images/".$_SESSION["email"]."/".$alineacion[3]."' 
          id='div".$i."' alt='".$alineacion[0]."' style='width:117px; height:105px; padding:3%;'>";        
        }
        echo '</div>';
        $persona[$i] = $alineacion[0];
      }      
   ?>
</div>