<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Reune, Organiza y Juega</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="shortcut icon" type="image/ico" href="../assets/img/ball.png">
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
		<nav class="cont">
			<ul class="menu">
				<li><a href="#"><span class="icon-enter" style="font-size:20px;"></span><br><span style="font-size:12px;">esquezada@utpl.edu.ec</span></a></li>
			</ul>
		</nav>
	</header>
	<section class="container">
		<section class="perfil">
			pefil
		</section>
		<section class="contenido">
			contenido
		</section>
	</section>
	<footer>
		<?php include("../include/footer.php") ?>
	</footer>
</body>
</html>
<script src='../assets/js/css3-animate-it.js'></script>