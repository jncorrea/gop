<?php 
header('Content-Type: text/html; charset=ISO-8859-1');
include("../static/site_config.php"); 
include ("../static/clase_mysql.php");
$miconexion = new clase_mysql;
$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
extract($_GET);
if(@$op==''){$op="perfil";}
  session_start();
  $_SESSION["email"]="esquezada1@utpl.edu.ec";
  global $lista;
  global $cont;
  $miconexion->consulta("select * from miembros where email = '".$_SESSION["email"]."' ");
  $cont = $miconexion->numcampos();
  for ($i=0; $i < $miconexion->numregistros(); $i++) { 
    $lista=$miconexion->consulta_lista();
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Reune, Organiza y Juega</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="shortcut icon" type="image/ico" href="../assets/img/ball.png">
	<link rel="stylesheet" href="../assets/css/bootstrap.css">
	<link rel="stylesheet" href="../assets/css/styles.css">
	<link rel="stylesheet" href="../assets/css/style.css">
	<link rel="stylesheet" href="../assets/css/animations.css" type="text/css">
	<link href='http://fonts.googleapis.com/css?family=Audiowide' rel='stylesheet' type='text/css'>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
	<script>
	$(document).ready(main); 
		var contador = 1;		 
		function main(){
			$('.menu_bar').click(function(){
				//$('nav').toggle(); 
		 
				if(contador == 1){
					$('nav').animate({
						left: '0'
					});
					contador = 0;
				} else {
					contador = 1;
					$('nav').animate({
						left: '-100%'
					});
				} 
			});
		};
	</script>
</head>
<body>
	<header>
		<div class="menu_bar">
			<a href="#" class="bt-menu"><span class="icon-grid"></span>Menu</a>
		</div>
		<nav class="cont navbar">
			<ul class="menu">
				<li><a href="#"><span class="icon-enter" style="font-size:20px;"></span><br><span style="font-size:12px; font-famiy:cursive;"><?php echo $_SESSION["email"]; ?></span></a></li>
			</ul>
		</nav>
	</header>
	<section class="contenedor">
		<section class="perfil">
			<section class="infor">
				<div class="edit">
					<a title="Editar Perfil" href="perfil.php?op=configurar"><span class="icon-pencil2"></span></a>
				</div>
				<div class="avatar">
					<?php 
						if ($lista[6]==""){
							echo '<img src="../assets/img/user.jpg" alt="Avatar">';
						}else{
							echo "<img src='images/".$_SESSION["email"]."/".$lista[6]."'>";
						}
					?>					
				</div>
				<div class="info">
					<p style="font-size:14px; font-weight: bold;"><?php echo $lista[2]." ".$lista[3]; ?></p>
					<p><?php echo $lista[0]?></p>
					<p>Celular: <?php echo $lista[4]?></p>
					<p>Posici&oacute;n: <?php echo $lista[4]?></p>
				</div>
				<div class="account">
		          <ul id="progressbar-account"> 
		            <h4 style="font: bold 90%">Avance del Perfil</h4>
		            <li id="box1">25%</li>          
		            <li id="box2">50%</li>
		            <li id="box3">75%</li>
		            <li id="box4">100%</li>
		          </ul>
		          <?php 
		            $porcentaje = 0;
		            for ($i=0; $i < $cont; $i++) { 
		              if ($lista[$i]!="") {
		                $porcentaje = $porcentaje + 14;
		              }
		            }
		            if ($porcentaje>25) {
		              echo "<script>
		                      $('li#box1').addClass('active-box');
		                    </script>";
		            }
		            if ($porcentaje>50) {
		              echo "<script>
		                      $('li#box2').addClass('active-box');
		                    </script>";
		            }
		            if ($porcentaje>75) {
		               echo "<script>
		                      $('li#box3').addClass('active-box');
		                    </script>";
		            }if ($porcentaje >= 98){
		               echo "<script>
		                      $('li#box4').addClass('active-box');                     
		                    </script>";
		            }
		           ?> 
		        </div>
			</section>
		</section>
		<section class="contenido">
			<?php 
	            switch ($op) {
	              case 'configurar':
	                include("../perfiles/configurar.php");
	                break;
	              
	              default:
	                # code...
	                break;
	            }
	        ?>
		</section>
	</section>
	<footer>
		<?php include("../static/footer.php") ?>
	</footer>
	<script type="application/javascript">    
      function archivo(evt) {
      var files = evt.target.files; // FileList object       
        //Obtenemos la imagen del campo "file". 
      for (var i = 0, f; f = files[i]; i++) {         
           //Solo admitimos imágenes.
           if (!f.type.match('image.*')) {
                continue;
           }
           var reader = new FileReader();
           
           reader.onload = (function(theFile) {
               return function(e) {
               // Creamos la imagen.
                      document.getElementById("list").innerHTML = ['<img style="width: 120px; height: 150px; border: 1px solid #000;" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
               };
           })(f);
           reader.readAsDataURL(f);
        }
      }  
      document.getElementById('avatar').addEventListener('change', archivo, false);
    </script>
</body>
</html>
<script src='../assets/js/css3-animate-it.js'></script>