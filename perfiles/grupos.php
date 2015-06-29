  <?php 
      $miconexion->consulta("select * from grupos g
        where g.id_grupo='".$id."'");
        $nom=$miconexion->consulta_lista();
   ?>
  <div class="col-xs-12 col-md-8">
  <h1 style="text-align:center;"><?php echo $nom[1]; ?></h1>
      <h3>Invitar <a title="A&ntilde;adir miembro" style="font-size:20px;" href="#" onclick="mostrar('invite'); return false" >
        <span class="icon-plus2"></span></h3>
      </a>
    </h5>
    <div id="invite" style="display:none;">
            <form method="post" action="../include/insertarGrupo.php"class="form-horizontal" id="frmAdd" autocomplete="off">
              <div class="form-horizontal" style="display:inline-block;">
                  <input type="hidden" class="form-control" id="bd" name="bd" value="grupos">
                  <input style="width:78%; display:inline-block;" type="text" class="form-control" id="persona" name="persona" placeholder="Buscar...">
                  <?php 
                    echo '<input type="hidden" class="form-control" id="id_grupo" name="id_grupo" value="'.$nom[0].'">'; 
                   ?>
                  <input type="hidden" class="form-control" id="id_persona" name="id_persona" value="">
                  <button style="width:20%; display:inline-block;" type="submit" class="btn btn-default"><span class="icon-user-plus"></span></button>
              </div>
            </form>
          </div>
    <table class="table table-striped">

      <?php
      $miconexion->consulta("select g.nombre_grupo, m.nombres, m.apellidos, gm.email, m.avatar, g.owner 
        from grupos g, grupos_miembros gm, miembros m 
        where g.id_grupo=gm.id_grupo and gm.email = m.email and gm.id_grupo='".$id."' order by g.owner=gm.email desc");
      for ($i=0; $i < $miconexion->numregistros(); $i++) { 
        $lista3=$miconexion->consulta_lista();
        echo "<tr>";
        if ($lista3[4]==""){
      echo '<td style="width:50px;"><img style="width:50px; height:50px;" src="../assets/img/user.jpg" alt="Avatar"></td>';
    }else{
      echo "<td style='width:50px;'><img style='width:50px; height:50px;' src='images/".$_SESSION["email"]."/".$lista3[4]."'></td>";
    }
      if ($lista3[3]==$lista3[5]) {
        echo  "<td>".$lista3[1]." ".$lista3[2]." <strong>(Administrador)</strong><br>".$lista3[3]."</td>";
      }else{
        echo  "<td>".$lista3[1]." ".$lista3[2]."<br>".$lista3[3]."</td>";
      }
        echo "</tr>"; 
    }

       ?>            
    </table>
  </div>
  <div class="col-xs-6 col-md-4">
  	<h5 style="text-align:center;">
      <strong>INTEGRANTES </strong>
      
  </div>