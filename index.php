<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Reune, Organiza y Juega</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="shortcut icon" type="image/ico" href="assets/img/ball.png">
	<link rel="stylesheet" href="assets/css/styles.css">
	<link rel="stylesheet" href="assets/css/style.css">
	<link rel="stylesheet" href="assets/css/animations.css" type="text/css">
	<link href='http://fonts.googleapis.com/css?family=Audiowide' rel='stylesheet' type='text/css'>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
	<style>
	    #map{
	        height: 350px;
	        width: 100%;
	        margin: 0;
	        padding: 0;
	    }
	</style>
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
			 $('ul.menu li a').click(function(){
				$('li a').removeClass("active");
				$('.icon').remove();
				$(this).addClass("active");
				$(this).append("<div class='icon'></div>");
			})
		};
	</script>
	<script >
        function initialize() {
          var myLatlng = new google.maps.LatLng(-2.524406, -78.929772);
          var mapOptions = {
            zoom: 7,
            center: myLatlng,
            styles: [{"stylers":[{"hue":"#ff1a00"},{"invert_lightness":true},{"saturation":-100},{"lightness":33},{"gamma":0.5}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#2D333C"}]}]
          }
          var map = new google.maps.Map(document.getElementById('map'), mapOptions);
	        //var marcador = new google.maps.LatLng({{a.latitud}}, {{a.longitud}});
	        var marcador = new google.maps.LatLng(-2.845979, -79.154102);
	        var marker = new google.maps.Marker({
	              position: marcador,
	              map: map,
	              title: 'cancha',
	              icon:'assets/img/google.png'
	          });
	          google.maps.event.addListener(marker, 'click', function(){
	                var popup = new google.maps.InfoWindow();
	                popup.setContent(note);
	                popup.open(map, this);
	          })
        }
        google.maps.event.addDomListener(window, 'load', initialize);
    </script>
</head>
<body>
	<header>
		<div class="menu_bar">
			<a href="#" class="bt-menu"><span class="icon-grid"></span>Menu</a>
		</div>
		<nav class="cont">
			<ul class="menu">
				<li><a href="#" class="active">Home
				</a></li>
				<li><a href="#">Contact</a></li>
				<li><a href="#">Sing up</a></li>
				<li><a href="#">Sing in</a></li>
			</ul>
		</nav>
	</header>
	<nav class="animatedParent" style="background:url(assets/img/soccer.png); width:100%;">
		<section id="navbar" class="animated bounceIn">
			Bienvenido
		</section>
	</nav>
	<section class="content animatedParent" style="background:url(assets/img/slider.png);">
		<div class="fondo">
			<section class="animated bounceInLeft">
				<a href="#"><img src="assets/img/ball.png" alt="SoccerBall"></a>
				<p>Reune</p>
			</section>
			<section class="animated bounceInUp">
				<a href="#"><img src="assets/img/ball.png" alt="SoccerBall"></a>
				<p>Organiza</p>
			</section>
			<section class="animated bounceInRight">
				<a href="#"><img src="assets/img/ball.png" alt="SoccerBall"></a>
				<p>Juega</p>
			</section>
		</div>
	</section>
	<section id="map"></section>
	<footer>
		<?php include("include/footer.php") ?>
	</footer>
</body>
</html>
<script src='assets/js/css3-animate-it.js'></script>