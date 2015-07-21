  <?php 
      $miconexion->consulta("select * from grupos g
        where g.id_grupo='".$id."'");
        $nom=$miconexion->consulta_lista();
   ?>
<div class="page-bar">
  <ul class="page-breadcrumb">
    <li>
      <i class="fa fa-home"></i>
      <a href="perfil.php">Home</a>
      <i class="fa fa-angle-right"></i>
    </li>
    <li>
      <a href="#">Editar Partido</a>
    </li>
  </ul> 
</div>
<!-- END PAGE HEADER-->
<!-- BEGIN DASHBOARD STATS -->
  <div class="row">
    <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
      <h3 class="page-title">
        Grupos <small>Miembros del Grupo</small>
      </h3>
      <div class="portlet light ">
          <div class="col-xs-12 col-md-12">
  <h3>Invitar <a title="A&ntilde;adir miembro" style="font-size:20px;" href="#" onclick="mostrar('invite'); return false" >
        <i class="fa fa-plus-circle"></i>
      </a>
    </h3>
    <div id="invite" style="display:none;">
            <form method="post" action="../include/insertarMiembro.php"class="form-horizontal" autocomplete="off">
              <div class="form-horizontal" style="display:inline-block;">
                  <input type="hidden" class="form-control" id="bd" name="bd" value="grupos_miembros">
                  <input style="width:78%; display:inline-block;" type="text" class="form-control" id="persona" name="persona" placeholder="Buscar...">
                  <input type="hidden" class="form-control" id="id_persona" name="id_persona" value="">
                  <?php 
                    echo '<input type="hidden" class="form-control" id="id_grupo" name="id_grupo" value="'.$nom[0].'">'; 
                   ?>
                  <button style="width:20%; display:inline-block;" type="submit" class="btn btn-default"><i class="fa fa-plus-circle"></i></button>
              </div>
            </form>
          </div>

      <div class="row">
        <div class='col-xs-6'>
          <table class="table table-striped">
            <?php
            $miconexion->consulta("select g.nombre_grupo, m.nombres, m.apellidos, gm.email, m.avatar, g.owner, gm.estado 
              from grupos g, grupos_miembros gm, miembros m 
              where g.id_grupo=gm.id_grupo and gm.email = m.email and gm.id_grupo='".$id."' order by g.owner=gm.email desc");
            for ($i=0; $i < $miconexion->numregistros(); $i++) { 
              $lista3=$miconexion->consulta_lista();
              if ($i%2==0) {
                echo "<tr>";
                if ($lista3[4]==""){
                  echo '<td style="width:50px;"><img style="width:50px; height:50px;" src="../assets/img/user.jpg" alt="Avatar"></td>';
                }else{
                  echo "<td style='width:50px;'><img style='width:50px; height:50px;' src='images/".$lista3[3]."/".$lista3[4]."'></td>";
                }
                if ($lista3[3]==$lista3[5]) {
                  echo  "<td>".$lista3[1]." ".$lista3[2]." <strong>(Administrador)</strong><br>".$lista3[3]."</td>";
                }else{
                if ($lista3[6]=='0') {
                  echo  "<td>".$lista3[1]." ".$lista3[2]."<br>".$lista3[3]." (Invitado)</td>";
                }else{
                  echo  "<td>".$lista3[1]." ".$lista3[2]."<br>".$lista3[3]."</td>";
                }
              }
                echo "</tr>";
              }              
          }
             ?>            
        </table>
        </div>
        <div class='col-xs-6'>
          <table class="table table-striped">
            <?php
            $miconexion->consulta("select g.nombre_grupo, m.nombres, m.apellidos, gm.email, m.avatar, g.owner, gm.estado 
              from grupos g, grupos_miembros gm, miembros m 
              where g.id_grupo=gm.id_grupo and gm.email = m.email and gm.id_grupo='".$id."' order by g.owner=gm.email desc");
            for ($i=0; $i < $miconexion->numregistros(); $i++) { 
              $lista3=$miconexion->consulta_lista();
              if ($i%2==0) {
                # code...
              }else{
                echo "<tr>";
                if ($lista3[4]==""){
                  echo '<td style="width:50px;"><img style="width:50px; height:50px;" src="../assets/img/user.jpg" alt="Avatar"></td>';
                }else{
                  echo "<td style='width:50px;'><img style='width:50px; height:50px;' src='images/".$lista3[3]."/".$lista3[4]."'></td>";
                }
                if ($lista3[3]==$lista3[5]) {
                  echo  "<td>".$lista3[1]." ".$lista3[2]." <strong>(Administrador)</strong><br>".$lista3[3]."</td>";
                }else{
                if ($lista3[6]=='0') {
                  echo  "<td>".$lista3[1]." ".$lista3[2]."<br>".$lista3[3]." (Invitado)</td>";
                }else{
                  echo  "<td>".$lista3[1]." ".$lista3[2]."<br>".$lista3[3]."</td>";
                }
              }
                echo "</tr>"; 
              }              
          }
             ?>            
      </table>          
    </div>          
  </div>
</div>
      </div>
    </div>
    <div class="chat page-sidebar-menu col-lg-2 col-md-2 col-sm-12 col-xs-12" style="border-left: 1px solid #EEEEEE;">
    <h4>USUARIOS CONECTADOS</h4>
    <ul style="color:#ffff; list-style: none; padding:0px;">
      <div id = "col_chat"></div>
    </ul>
  </div>
</div>