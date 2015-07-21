<div id = "col_chat">
  <table class="table table-striped">    
<?php
  $miconexion = new clase_mysql;
  $miconexion->conectar($db_name,$db_host, $db_user,$db_password);
  $miconexion->consulta("select distinct(m.email), m.user, m.avatar from miembros m
                        left join grupos_miembros gm
                        ON m.email = gm.email
                        where gm.email IS NOT NULL
                        and m.email !='".$_SESSION['email']."' and m.estado = 1");  
  if (($miconexion->numregistros())==0) { 
    echo "<h5 style='text-align:center;' >No hay usuarios conectados</h5>";
  }else{
    for ($i=0; $i < $miconexion->numregistros(); $i++) { 
      $lista_chat=$miconexion->consulta_lista();
      if($lista_chat[0]!=$_SESSION['email']){ 
        //echo "<tr>";
        if ($lista_chat[2]=="") {
        ?>   
        <tr> 
        <td >
          <a title='En L&iacute;nea' href='javascript:void(0)' onclick='javascript: var user = new Array("<?php echo $lista_chat[1] ?>", "<?php echo $i ?>"); chatWith(user)'>
          <img padding: 0px; style='width:35px; height:35px; display:inline-block;' src='../assets/img/user.png'></img>
          </a>
        </td>
        <td>
        <a title='En L&iacute;nea' href='javascript:void(0)' onclick='javascript: var user = new Array("<?php echo $lista_chat[1] ?>", "<?php echo $i ?>"); chatWith(user)'>
          <div style='line-height: 12px; display:inline-block; font-size: 90%; padding-left:5px;'><p style='font-size: 90%;'><?php echo $lista_chat[1] ?></p></div>
        </a>        
        </td>
        <td>
        <a title='En L&iacute;nea' href='javascript:void(0)' onclick='javascript: var user = new Array("<?php echo $lista_chat[1] ?>", "<?php echo $i ?>"); chatWith(user)'>
          <i class="icon-circle" style="color:#4CAF50; font-size: 8px; padding-left: 15px;"></i>
        </a>
        </td>       
        </tr>
        <?php
        }else{
        ?>
        <tr>
          
        <td>
        <a title='En L&iacute;nea' href='javascript:void(0)' onclick='javascript: var user = new Array("<?php echo $lista_chat[1] ?>", "<?php echo $i ?>"); chatWith(user)'>
          <img padding: 0px; style='width:35px; height:35px; display:inline-block;' src='images/<?php echo $lista_chat[0] ?>/<?php echo $lista_chat[2] ?>'></img>
        </a>
        </td>
        <td>
        <a title='En L&iacute;nea' href='javascript:void(0)' onclick='javascript: var user = new Array("<?php echo $lista_chat[1] ?>", "<?php echo $i ?>"); chatWith(user)'>
          <div style='line-height: 12px; display:inline-block; font-size: 90%; padding-left:5px;'><p style='font-size: 90%;'><?php echo $lista_chat[1] ?></p></div>
        </a>        
        </td>
        <td>
        <a title='En L&iacute;nea' href='javascript:void(0)' onclick='javascript: var user = new Array("<?php echo $lista_chat[1] ?>", "<?php echo $i ?>"); chatWith(user)'>
          <i class="icon-circle" style="color:#4CAF50; font-size: 8px; padding-left: 15px;"></i>
        </a>
        </td>
        </tr>
      <?php
        }
        //echo "</tr>";
      }
    }
  }
    ?>
  </table>
</div>