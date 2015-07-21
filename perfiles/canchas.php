<!-- BEGIN PAGE HEADER-->
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<i class="fa fa-home"></i>
			<a href="perfil.php">Home</a>
			<i class="fa fa-angle-right"></i>
		</li>
		<li>
			<a href="#">Canchas</a>
		</li>
	</ul>
</div>
<!-- END PAGE HEADER-->
<!-- BEGIN DASHBOARD STATS -->
<div class="row">
	<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
		<h3 class="page-title">
			Canchas <small>Localizaci&oacute;n</small>
		</h3>
		<div class="clearfix">
		</div>
		<div class="row">
			<div class="col-md-3 col-sm-3">
				<!-- BEGIN PORTLET-->
				<div class="portlet light ">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-bubble font-red-sunglo"></i>
							<span class="caption-subject bold uppercase" style="font-size:12px; color:#4CAF50;">Canchas Disponibles</span>
						</div>
					</div>
					<div class="portlet-body" id="chats">
						<div class="scroller" style="height: 341px;" data-always-visible="1" data-rail-visible1="1">
							<ul id="cancha" style="padding-left:0; font-size:14px;">
								<li style="list-style: none; text-align:left;">
									<a href="#canchas">
										<i class="icon-map-marker" style="padding: 10px 15px; font-size:18px;"></i>
										<span class="title">Todas</span>
									</a>
								</li>
								<li style="list-style: none; text-align:left;">
									<a href="#canchas">
										<i class="icon-map-marker" style="padding: 10px 15px; font-size:18px;"></i>
										<span class="title">cancha</span>
									</a>
								</li>
								<li style="list-style: none; text-align:left;">
									<a href="#canchas">
										<i class="icon-map-marker" style="padding: 10px 15px; font-size:18px;"></i>
										<span class="title">cancha</span>
									</a>
								</li>
								<li style="list-style: none; text-align:left;">
									<a href="#canchas">
										<i class="icon-map-marker" style="padding: 10px 15px; font-size:18px;"></i>
										<span class="title">cancha</span>
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- END PORTLET-->
			</div>
			<div class="col-md-9 col-sm-9">
				<div class="portlet light ">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-bubble font-red-sunglo"></i>
							<span class="caption-subject bold uppercase" style="color: #006064;">TODAS LAS CANCHAS</span>
						</div>
					</div>
					<div class="portlet-body" id="chats">
						<div class="scroller" style="height: 341px;" data-always-visible="1" data-rail-visible1="1">
							<div id="cancha_map" style="width:100%; height: 341px;">
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="chat page-sidebar-menu col-lg-2 col-md-2" style="border-left: 1px solid #EEEEEE;">
		<h4>USUARIOS CONECTADOS</h4>
		<ul style="color:#ffff; list-style: none; padding:0px;">
			<?php include("col_chat.php"); ?>
		</ul>
	</div>
</div>
<!-- END DASHBOARD STATS -->