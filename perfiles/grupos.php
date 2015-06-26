  <?php 
      $miconexion->consulta("select g.nombre_grupo from grupos g
        where g.id_grupo='".$id."'");
        $nom=$miconexion->consulta_lista();
   ?>
  <div class="col-xs-12 col-md-8">
  <h1 style="text-align:center;"><?php echo $nom[0]; ?></h1>
  </div>
  <div class="col-xs-6 col-md-4">
  	<h5 style="text-align:center;"> <strong>INTEGRANTES</strong></h5>
  	<table class="table table-striped">  
      <?php
      $miconexion->consulta("select g.nombre_grupo, m.nombres, m.apellidos, gm.email, m.avatar, g.owner 
        from grupos g, grupos_miembros gm, miembros m 
        where g.id_grupo=gm.id_grupo and gm.email = m.email and gm.id_grupo='".$id."' order by g.owner=gm.email desc");
      for ($i=0; $i < $miconexion->numregistros(); $i++) { 
        $lista3=$miconexion->consulta_lista();
        echo "<tr>";
        if ($lista3[4]==""){
			echo '<td><img style="width:50px; height:50px;" src="../assets/img/user.jpg" alt="Avatar"></td>';
		}else{
			echo "<td><img style='width:50px; height:50px;' src='images/".$_SESSION["email"]."/".$lista3[4]."'></td>";
		}
      if ($lista3[3]==$lista3[5]) {
        echo  "<td>".$lista3[1]." ".$lista3[2]." <strong>(Administrador)</strong><br>".$lista3[3]."</td>";
        echo "</tr>";
      }else{
        echo 	"<td>".$lista3[1]." ".$lista3[2]."<br>".$lista3[3]."</td>";
        echo "</tr>"; 
      }
    }

       ?>            
    </table>
  </div>