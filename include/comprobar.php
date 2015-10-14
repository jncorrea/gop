<?php 	
	$user = $_POST['b'];
	   
	if(!empty($user)) {
	    comprobar($user);
	  }
	   
	 function comprobar($b) {
  		include("../static/clase_mysql.php");
		include("../static/site_config.php");
		$miconexion = new clase_mysql;
		$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
		@$miconexion->consulta("select * from grupos where nombre_grupo='$b'");
        if($miconexion->numregistros() == 0){?>
              <span id='mensaje' style='font-weight:bold;color:green;'>Nombre Disponible</span>
              <script> document.getElementById('btn_crear_grupo').disabled=false; </script>
        <?php }else{ ?>
              <span id='mensaje' style='font-weight:bold;color:red;'>El grupo ya existe</span>
              <script> document.getElementById('btn_crear_grupo').disabled=true; </script>
            <?php
        }
    }
?>