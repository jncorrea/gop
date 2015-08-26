<?php 
  include("../static/site_config.php"); 
  include ("../static/clase_mysql.php");
  extract($_GET);
  session_start();
  $miconexion = new clase_mysql;
  $miconexion->conectar($db_name,$db_host, $db_user,$db_password); 
?>
<!-- BEGIN PORTLET -->
<div class="caption caption-md">
    <i class="icon-bar-chart theme-font hide"></i>
    <?php
    switch ($comen) {
      case 'a':
        $miconexion->consulta("select  u.avatar, c.comentario, u.email, c.fecha_publicacion, u.user, u.sexo  from comentarios c, usuarios u where c.id_user=u.id_user and c.id_partido=".$id." order by c.fecha_publicacion desc");
        break;
      
      case 'g':
        $miconexion->consulta("select  u.avatar, c.comentario, u.email, c.fecha_publicacion, u.user, u.sexo  from comentarios c, usuarios u where c.id_user=u.id_user and c.id_grupo=".$id." order by c.fecha_publicacion desc");
        break;
    }
    ?>
    <span class="caption-subject font-blue-madison bold uppercase">Comentarios</span>
    <span class="caption-helper"><?php echo $miconexion->numregistros() ?> comentario(s)</span>
    </div>
  <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 305px;">
    <div class="scroller" style="height: 305px; overflow: hidden; width: auto;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2" data-initialized="1">
      <div class="general-item-list">        
        <?php for ($i=0; $i <$miconexion->numregistros(); $i++) { 
                    $lista_comen=$miconexion->consulta_lista(); ?>
        <div class="item">
          <div class="item-head">
            <div class="item-details">
              <?php if ($lista_comen[0]=="") {
                if ($lista_comen[5]=="Femenino") {
                  echo '<img alt="Avatar" class="item-pic" src="../assets/img/user_femenino.png"/>';
                }else{
                  echo '<img alt="Avatar" class="item-pic" src="../assets/img/user_masculino.png"/>';
                }
              ?>
              <a href="#" class="item-name primary-link"><?php echo $lista_comen[4] ?></a>
              <span class="item-label"><?php echo $lista_comen[3] ?></span>
              <?php }else{ ?>
              <img class="item-pic" src="images/<?php echo $lista_comen[2] ?>/<?php echo $lista_comen[0] ?>">
              <a href="#" class="item-name primary-link"><?php echo $lista_comen[4] ?></a>
              <span class="item-label"><?php echo $lista_comen[3] ?></span>
              <?php } ?>
            </div>
          </div>
          <div class="item-body">
            <?php echo $lista_comen[1]; ?>
          </div>          
        </div>
      <?php } ?>
      </div>
    </div>
  </div>