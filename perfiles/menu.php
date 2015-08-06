<?php 
include("../static/site_config.php"); 
include ("../static/clase_mysql.php");
$miconexion = new clase_mysql;
$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
session_start();
?>
<script>
   var consulta;
         
  //hacemos focus
  $("#grupo").focus();
                                             
  //comprobamos si se pulsa una tecla
  $("#grupo").keyup(function(e){
         //obtenemos el texto introducido en el campo
         consulta = $("#grupo").val();
                                  
         //hace la búsqueda
         $("#resultado").delay(1000).queue(function(n) {  
         document.getElementById('crear_grupo').disabled=true;    
                                       
                $.ajax({
                  type: "POST",
                  url: "../include/comprobar.php",
                  data: "b="+consulta,
                  dataType: "html",
                  error: function(){
                        alert("error petición ajax");
                  },
                  success: function(data){     
                        $("#resultado").html(data);
                        n();
                	}                         
            });
                          
        });
                            
  });
</script>
<li class="sidebar-toggler-wrapper">
	<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
	<div class="sidebar-toggler">
	</div>
	<!-- END SIDEBAR TOGGLER BUTTON -->
</li>
<li class="start active open">
	<a href="perfil.php">
		<i class="icon-home"></i>
		<span class="title">Home</span>
		<span class="selected"></span>
		<span class="open"></span>
	</a>
</li>
<li>
	<a href="javascript:;">
	<i class="icon-plus-sign-alt"></i>
	<span class="title">Operaciones</span>
	<span class="arrow "></span>
	</a>
	<ul class="sub-menu">
		<li>
			<a title="Crear Grupo" style='font-size:15px; display: inline-block; padding-right:5px;' href="#" onclick="mostrar('crearGrupo'); return false" >
        	<i class="icon-plus"></i> Crear Grupo</a>
        	<div id="crearGrupo" style="display:none;">
            <form method="post" action=""class="form-horizontal" id="form_grupo" style="display:inline-block; width:65%;">
              <div class="form-horizontal" style="display:inline-block; padding-left:10px; width:100%;">
                  <input type="hidden" class="form-control" id="bd" name="bd" value="grupos">
                  <input style="width:100%; display:inline-block;" type="text" class="form-control" id="grupo" name="grupo" placeholder="Grupo..">
                  <?php 
                    echo '<input type="hidden" class="form-control" id="owner" name="owner" value="'.$_SESSION["email"].'">'; 
                   ?>
              </div>
            </form>
            <div class="form-horizontal" style="display:inline-block; width:30%;">
              <input  onclick='enviar_form("../include/insertarGrupo.php","form_grupo");' id="crear_grupo" style="width:100%; display:inline-block; text-align:center;" disabled="false" type="submit" class="btn btn-default" value="Crear">
            </div>
            <div id="resultado"></div>
  		</div>
		</li>
		<li>
			<a title="Crear Partido" style='font-size:15px; display: inline-block; padding-right:5px;' href="perfil.php?op=crear_evento">
        	<i class="icon-plus"></i> Crear Partido</a>
		</li>	
	</ul>
</li>
<li>
	<a href="javascript:;">
	<i class="icon-group"></i>
	<span class="title">Mis Grupos</span>
	<span class="arrow "></span>
	</a>
	<ul class="sub-menu">
		<?php
        	$miconexion->consulta("select g.nombre_grupo, g.id_grupo, g.owner, gm.email from grupos g, grupos_miembros gm where g.id_grupo=gm.id_grupo and gm.email='".$_SESSION['email']."'");
        	$cont = $miconexion->numcampos();
        	for ($i=0; $i < $miconexion->numregistros(); $i++) { 
                $lista2=$miconexion->consulta_lista();
                echo "<li>";
                if ($lista2[2]==$lista2[3]) {?>
                	<a style='font-size:15px; display: inline-block; padding-right:5px;' onclick='actualizar_notificacion("1","<?php echo $lista2[1]?>")'>
                	<i title='Eliminar Grupo' class='icon-remove'></i></a>
                	<?php
                  echo 	"<a style='display: inline-block; padding-left:0;' href='perfil.php?op=grupos&id=".$lista2[1]."'>";
                	echo 	"<i class='icon-group'></i> ".$lista2[0]."</a>";
                }else{
                	echo 	"<a style='display: inline-block; padding-left:66px;' href='perfil.php?op=grupos&id=".$lista2[1]."'>";
                	echo 	"<i class='icon-group'></i> ".$lista2[0]."</a>";
            	}				                
                echo "</li>"; 
        	}
        ?> 
	</ul>
</li>
<li>
	<a href="javascript:;">
	<i class="icon-gamepad"></i>
	<span class="title">Mis Partidos</span>
	<span class="arrow "></span>
	</a>
	<ul class="sub-menu">
		<?php
        	$miconexion->consulta("select p.id_grupo, p.id_partido, p.fecha, p.estado 
        		FROM partidos p, convocatoria c
        		WHERE p.id_partido = c.id_partido and c.email ='".$_SESSION['email']."' and c.estado != 2");		            	
        	$cont = $miconexion->numcampos();
        	for ($i=0; $i < $miconexion->numregistros(); $i++) { 
                $partidos=$miconexion->consulta_lista();
                if ($partidos[3]=='1') {
                	echo "<li>";
	                $time=strtotime($partidos[2]);
	                $fecha = date("d M Y H:i",$time);
	                echo 	"<a href='perfil.php?op=alineacion&id=".$partidos[1]."'>
	                			<i class='icon-gamepad'></i>
	                			".$fecha."
	                		</a>";				                
	                echo "</li>"; 
                }
        	}
           ?>   
	</ul>
</li>
<li>
	<a href="perfil.php?op=canchas">
	<i class="icon-map-marker"></i>
	<span class="title">Canchas</span>
	</a>
</li>
<li class="heading">
	<h3 class="uppercase">Sugerencias</h3>
</li>				
<ul class="page-sidebar-menu " id="col_sugerencias" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
</ul>