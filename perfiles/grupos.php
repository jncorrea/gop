  <?php 
      $miconexion->consulta("select * from grupos g
        where g.id_grupo='".$id."'");
        $nom=$miconexion->consulta_lista();
   ?>
<div class="page-bar">
  <ul class="page-breadcrumb">
    <li>
      <i class="icon-home"></i>
      <a href="perfil.php">Home</a>
      <i class="icon-angle-right"></i>
    </li>
    <li>
      <a href="#">Grupo <?php echo $nom[1]; ?></a>
    </li>
  </ul> 
</div>
<!-- END PAGE HEADER-->
<!-- BEGIN DASHBOARD STATS -->
<div class="row">
  <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
    <h3 class="page-title">
      <?php echo strtoupper($nom[1]); ?><small> Miembros del Grupo</small>
    </h3>
    <div class="portlet light ">
      <div style="float:right;">
        <a  class="btn red" href="perfil.php?act=2&id=<?php echo $id ?>"> Abandonar Grupo..</a> 
      </div>
      <div class="col-xs-12 col-md-12">
      <?php if ($nom[2]==$_SESSION['email']): ?>        
          <h3>Invitar <a title="A&ntilde;adir miembro" style="font-size:20px;" href="#" onclick="mostrar('invite'); return false" >
            <i class="icon-plus-sign"></i></a>
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
                <button style="width:20%; display:inline-block;" type="submit" class="btn btn-default"><i class="icon-plus-sign"></i></button>
              </div>
            </form>
          </div>
      <?php endif ?>         

      <div class="row" style="padding-top:20px;">
        <div class='col-lg-4 col-md-4 col-sm-6 col-xs-12'>
          <table class="table table-striped">
            <?php
            $miconexion->consulta("select g.nombre_grupo, m.nombres, m.apellidos, gm.email, m.avatar, g.owner, gm.estado 
              from grupos g, grupos_miembros gm, miembros m 
              where g.id_grupo=gm.id_grupo and gm.email = m.email and gm.id_grupo='".$id."' order by g.owner=gm.email desc");
            for ($i=0; $i < $miconexion->numregistros(); $i++) { 
              $lista3=$miconexion->consulta_lista();
                echo "<tr>";
                if ($lista3[4]==""){
                  echo '<td style="width:40px;"><img class="img-circle" style="width:40px; height:40px;" src="../assets/img/user.jpg" alt="Avatar"></td>';
                }else{
                  echo "<td style='width:40px;'><img class='img-circle' style='width:40px; height:40px;' src='images/".$lista3[3]."/".$lista3[4]."'></td>";
                }
                if ($lista3[3]==$lista3[5]) {
                  echo  "<td style='font-size: 9px;'><span style='font-size: 11px; color: #006064; font-weight: bold;'>".strtoupper($lista3[1]." ".$lista3[2])."</span> <strong>(Administrador)</strong><br>".$lista3[3]."</td>";
                  echo "<td style='width:19.43px;'></td>";
                }else{
                if ($lista3[6]=='0') {
                  echo  "<td style='font-size: 9px;'><span style='font-size: 11px; color: #006064; font-weight: bold;'>".strtoupper($lista3[1]." ".$lista3[2])."</span><br>".$lista3[3]." (Invitado)</td>";
                  echo "<td style='width:19.43px;'></td>";
                }else{
                  if ($lista3[5]==$_SESSION['email']){ 
                  echo  "<td style='font-size: 9px;'><span style='font-size: 11px; color: #006064; font-weight: bold;'>".strtoupper($lista3[1]." ".$lista3[2])."</span><br>".$lista3[3]."</td>";
                  echo '<td class="btn-group pull-right" style="padding-left:0px; padding-right:10px;">
                      <button aria-expanded="false" style="width:100%; display:inline-block; background-color:transparent; margin: 0;padding: 0;"  type="button" class="btn btn-xs dropdown-toggle hover-initialized" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
                      <i style="font-size:14px;" class="icon-cog"></i>
                      </button>
                      <ul class="dropdown-menu pull-right" role="menu">
                        <li>
                          <a href="perfil.php?op=grupos&act=4&id='.$id.'&usm='.$lista3[3].'" style="width:100%; display:inline-block; font-size:11px;" class="btn btn-default">
                            Nombrar Administrador
                          </a>
                        </li>
                        <li>
                          <a href="perfil.php?op=grupos&act=3&id='.$id.'&usm='.$lista3[3].'"  style="width:100%; display:inline-block; font-size:11px;" class="btn btn-default">
                            Eliminar del grupo
                          </a>
                        </li>
                      </ul>
                  </td>';
                  }else{
                    echo  "<td style='font-size: 9px;'><span style='font-size: 11px; color: #006064; font-weight: bold;'>".strtoupper($lista3[1]." ".$lista3[2])."</span><br>".$lista3[3]."</td>";
                    echo "<td style='width:19.43px;'></td>";
                  }
                }
              }
                echo "</tr>";
              }
             ?>            
        </table>
        </div>
        <div class='col-lg-8 col-md-8 col-sm-6 col-xs-12'>
          Aqui van los comentarios
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