<div id = "col_chat">  
<?php
  session_start();
  include("../static/site_config.php"); 
  include ("../static/clase_mysql.php");
  $miconexion = new clase_mysql;
  $miconexion->conectar($db_name,$db_host, $db_user,$db_password);
  $miconexion->consulta("select distinct(m.email), m.user, m.avatar from miembros m
                        left join grupos_miembros gm
                        ON m.email = gm.email
                        where gm.email IS NOT NULL
                        and m.email !='".$_SESSION['email']."'");  
  if (($miconexion->numregistros()-1)==0) { 
    echo "<h5 style='text-align:center;' >No hay usuarios conectados</h5>";
  }else{
    for ($i=0; $i < $miconexion->numregistros(); $i++) { 
      $lista_chat=$miconexion->consulta_lista();
      if($lista_chat[0]!=$_SESSION['email']){ 
        if ($lista_chat[2]=="") {
        ?>    
        <a title='En L&iacute;nea' href='javascript:void(0)' onclick='javascript: var user = new Array("<?php echo $lista_chat[1] ?>", "<?php echo $i ?>"); chatWith(user)'>
        <img padding: 0px; style='width:35px; height:35px; display:inline-block;' src='../assets/img/user.jpg'></img>
            <div style='line-height: 12px; display:inline-block; font-size: 80%; padding-left:5px;'><p style='font-size: 90%;'><?php echo $lista_chat[1] ?></p></div>
        <img padding: 0px; style='width:15px; height:15px; display:inline-block;' src='../assets/img/conectado.png'></img>                
        </a><br>
        <?php
        }else{
        ?>
        <a title='En L&iacute;nea' href='javascript:void(0)' onclick='javascript: var user = new Array("<?php echo $lista_chat[1] ?>", "<?php echo $i ?>"); chatWith(user)'>
        <img padding: 0px; style='width:35px; height:35px; display:inline-block;' src='images/<?php echo $lista_chat[0] ?>/<?php echo $lista_chat[2] ?>'></img>
            <div style='line-height: 12px; display:inline-block; font-size: 80%; padding-left:5px;'><p style='font-size: 90%;'><?php echo $lista_chat[1] ?></p></div>
        <img padding: 0px; style='width:15px; height:15px; display:inline-block;' src='../assets/img/conectado.png'></img>  
        </a><br>
      <?php
        }
      }
    }
  }
    ?>
</div>