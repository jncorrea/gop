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
        if($miconexion->numregistros() == 0){
              echo "<span id='mensaje' style='font-weight:bold;color:green;'>Disponible</span>";
              echo "<script> document.getElementById('crear_grupo').disabled=false; </script>";
        }else{
              echo "<span id='mensaje' style='font-weight:bold;color:red;'>El grupo ya existe</span>";
              echo "<script> document.getElementById('crear_grupo').disabled=true; </script>";
        }
    }
?>