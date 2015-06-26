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
		$miconexion->consulta("select count(*) from grupos where nombre_grupo=".$b);
		$cont = $miconexion->numcampos();
		echo $cont;
        if($miconexion->numregistros() == 0){
              echo "<span style='font-weight:bold;color:green;'>Disponible.</span>";
        }else{
              echo "<span style='font-weight:bold;color:red;'>El nombre de usuario ya existe.</span>";
        }
	}     
?>