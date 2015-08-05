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
      $miconexion->consulta("select  m.avatar, c.comentario, m.email, c.fecha, m.user  from comentarios c, miembros m where c.email=m.email and c.id_partido=".$id." order by c.fecha desc");
    ?>
    <span class="caption-subject font-blue-madison bold uppercase">Comentarios</span>
    <span class="caption-helper"><?php echo $miconexion->numregistros() ?> comentario(s)</span>
    </div>
  <div style="position: relative; overflow: hidden; width: auto; height: 305px;" class="slimScrollDiv">
    <div data-initialized="1" class="" style="height: 305px; overflow: hidden; width: auto;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
      <div class="general-item-list scroller" style="height: 441px;" data-always-visible="1" data-rail-visible1="1">          
        <?php for ($i=0; $i <$miconexion->numregistros(); $i++) { 
                    $lista_comen=$miconexion->consulta_lista(); ?>
        <div class="item">
          <div class="item-head">
            <div class="item-details">
              <?php if ($lista_comen[0]=="") {
              ?>
              <img class="item-pic" src="../assets/img/user.png">
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