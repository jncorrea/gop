<table class="table table-striped">    
<?php
include("../static/site_config.php"); 
include ("../static/clase_mysql.php");
session_start();
  $miconexion = new clase_mysql;
  $miconexion->conectar($db_name,$db_host, $db_user,$db_password);  
  $miconexion->consulta("select distinct(u.email), u.user, u.avatar, u.id_user, u.sexo 
    FROM (usuarios u, user_grupo gr) 
    LEFT JOIN user_grupo gm 
    ON gr.id_grupo = gm.id_grupo 
    WHERE gm.id_user = '".$_SESSION['id']."' 
    and u.id_user = gr.id_user 
    and gm.id_user IS NOT NULL 
    and u.estado = '1'");  
  if (($miconexion->numregistros())==0) { 
    echo "<h5 style='text-align:center;' >No hay usuarios conectados</h5>";
  }else{
    for ($i=0; $i < $miconexion->numregistros(); $i++) { 
      $lista_chat=$miconexion->consulta_lista();
      if ($lista_chat[0]!=$_SESSION['email']) {        
        //echo "<tr>";
        if ($lista_chat[2]=="") {
        ?>   
        <tr> 
        <td >
          <a title='En L&iacute;nea' href='javascript:void(0)' onclick='javascript: var user = new Array("<?php echo $lista_chat[1] ?>", "<?php echo $lista_chat[3] ?>"); chatWith(user)'>
            <?php 
            if ($lista_chat[4]=="Femenino") {
              echo '<img padding: 0px; style="width:35px; height:35px; display:inline-block;" src="../assets/img/user_femenino.png"/>';
            }else{
              echo '<img padding: 0px; style="width:35px; height:35px; display:inline-block;" src="../assets/img/user_masculino.png"/>';
            }
            ?>
          </a>
        </td>
        <td>
        <a title='En L&iacute;nea' href='javascript:void(0)' onclick='javascript: var user = new Array("<?php echo $lista_chat[1] ?>", "<?php echo $lista_chat[3] ?>"); chatWith(user)'>
          <div style='line-height: 12px; display:inline-block; font-size: 90%; padding-left:5px;'><p style='font-size: 90%;'><?php echo $lista_chat[1] ?></p></div>
        </a>        
        </td>
        <td>
        <a title='En L&iacute;nea' href='javascript:void(0)' onclick='javascript: var user = new Array("<?php echo $lista_chat[1] ?>", "<?php echo $lista_chat[3] ?>"); chatWith(user)'>
          <i class="icon-circle" style="color:#4CAF50; font-size: 8px; padding-left: 15px;"></i>
        </a>
        </td>       
        </tr>
        <?php
        }else{
        ?>
        <tr>
          
        <td>
        <a title='En L&iacute;nea' href='javascript:void(0)' onclick='javascript: var user = new Array("<?php echo $lista_chat[1] ?>", "<?php echo $lista_chat[3] ?>"); chatWith(user)'>
          <img padding: 0px; style='width:35px; height:35px; display:inline-block;' src='images/<?php echo $lista_chat[1] ?>/<?php echo $lista_chat[2] ?>'></img>
        </a>
        </td>
        <td>
        <a title='En L&iacute;nea' href='javascript:void(0)' onclick='javascript: var user = new Array("<?php echo $lista_chat[1] ?>", "<?php echo $lista_chat[3] ?>"); chatWith(user)'>
          <div style='line-height: 12px; display:inline-block; font-size: 90%; padding-left:5px;'><p style='font-size: 90%;'><?php echo $lista_chat[1] ?></p></div>
        </a>        
        </td>
        <td>
        <a title='En L&iacute;nea' href='javascript:void(0)' onclick='javascript: var user = new Array("<?php echo $lista_chat[1] ?>", "<?php echo $lista_chat[3] ?>"); chatWith(user)'>
          <i class="icon-circle" style="color:#4CAF50; font-size: 8px; padding-left: 15px;"></i>
        </a>
        </td>
        </tr>
      <?php
      # code...
      }
        //echo "</tr>";
      }
    }
  }
    ?>
  </table>