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
	<i class="icon-group"></i>
	<span class="title">Mis Grupos</span>
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
                  <?php 
                    echo '<input type="hidden" class="form-control" id="owner" name="owner" value="'.$_SESSION["id"].'">'; 
                   ?>
                  <input style="width:100%; display:inline-block;" type="text" class="form-control" id="grupo" name="grupo" placeholder="Grupo..">
              </div>
            </form>
            <div class="form-horizontal" style="display:inline-block; width:30%;">
              <input  onclick='enviar_form("../include/insertarGrupo.php","form_grupo");' id="crear_grupo" style="width:100%; display:inline-block; text-align:center;" disabled="false" type="submit" class="btn btn-default" value="Crear">
            </div>
            <div id="resultado"></div>
      </div>
    </li>
		<?php
        //// declarar variables 
        $cont=0;
        $limite=0;
        
      	$miconexion->consulta("select g.nombre_grupo, g.id_grupo, g.id_user, gm.id_user from grupos g, user_grupo gm where g.id_grupo=gm.id_grupo and gm.id_user='".$_SESSION['id']."' ORDER BY g.ultima_modificacion DESC");
      	$cont = $miconexion->numcampos();
        
        $limite=$miconexion->numregistros();
        if ($limite==0) {
            echo "<li><a>A&uacute;n No Tienes Grupos.</a></li>";
        }else{
          if ($miconexion->numregistros()>4) {
            $limite=4;
            # code...
          }else{
            $limite=$miconexion->numregistros();

          }
        	for ($i=0; $i <$limite; $i++) { 
                $lista2=$miconexion->consulta_lista();
                echo "<li>";
                if ($lista2[2]==$lista2[3]) {?>
                  <a style='font-size:15px; display: inline-block; padding-right:5px;' href="javascript:VentanaConfirmacionModal('Estas seguro de eliminar este grupo ?','MensajeConfirmacion(1,<?php echo $lista2[1]; ?>)')"><i title='Eliminar Grupo' class='icon-remove'></i></a>
                <div id="FndYnnovaAlertas"></div>

                 
                	<?php
                  
                  echo 	"<a style='display: inline-block; padding-left:0px;' href='perfil.php?op=grupos&id=".$lista2[1]."'>";
                	echo 	"<i class='icon-group'></i> ".$lista2[0]."</a>";
                }else{
                	echo 	"<a style='display: inline-block; padding-left:66px;' href='perfil.php?op=grupos&id=".$lista2[1]."'>";
                	echo 	"<i class='icon-group'></i> ".$lista2[0]."</a>";
            	}				                
                echo "</li>"; 
        	}
          ?>
          <br>        
        <li>
          
          <a title="Ver Todos mis Grupos" style='' href="perfil.php?op=listar_grupos" >
            <i class="icon-group"></i> Ver Todos</a>
        </li>
          <?php
        }
        
        ?> 
        
        <div id="respuesta"></div>
	</ul>
</li>
<li>
	<a href="javascript:;">
	<i class="icon-gamepad"></i>
	<span class="title">Mis Partidos</span>
	<span class="arrow "></span>
	</a>
	<ul class="sub-menu">
    <li>
      <?php 
          $miconexion->consulta("select * from grupos where id_user='".$_SESSION['id']."'");  
          $miconexion->numregistros();
          if ($miconexion->numregistros()>0) {
       ?>
          <a title="Crear Partido" style='font-size:15px; display: inline-block; padding-right:5px;' href="perfil.php?op=crear_evento">
          <i class="icon-plus"></i> Crear Partido</a>
      <?php 
          }else{
       ?>
          <a title="Crear Partido" style='font-size:15px; display: inline-block; padding-right:5px;' href="#" onclick="mensaje();">
          <i class="icon-plus"></i> Crear Partido</a>
       <?php 
          }
        ?>
    </li>
		<?php
        	$miconexion->consulta("select p.id_grupo, p.id_partido, p.fecha_partido, p.hora_partido, p.estado_partido, p.nombre_partido
        		FROM partidos p, alineacion a
        		WHERE p.id_partido = a.id_partido and a.id_user ='".$_SESSION['id']."' and a.estado_alineacion != '2'");		            	
        	$cont = $miconexion->numcampos();
        	for ($i=0; $i < $miconexion->numregistros(); $i++) { 
                $partidos=$miconexion->consulta_lista();
                if ($partidos[4]=='1') {
                	echo "<li>";
	                $time=$partidos[2];
                  $hora=$partidos[3];
	                //$fecha = date("d M Y H:i",$time);
	                echo 	"<a title='".$time." - ".$hora."' href='perfil.php?op=alineacion&id=".$partidos[1]."'>
	                			<i class='icon-gamepad'></i>
                        ".$partidos[5]."	                			
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
	<span class="title">Centros Deportivos</span>
	</a>
</li>
<li class="heading">
	<h3 class="uppercase">Sugerencias</h3>
</li>				
<ul class="page-sidebar-menu " id="col_sugerencias" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
</ul>
<script>
  function mensaje(){
    $container = $("#container_notify").notify();  
    create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"No se puede crear Partido. <br>Primero debes crear un grupo.", imagen:"../assets/img/alert.png"});  
  }

</script>


<script type="text/javascript">


function MensajeConfirmacion(act, ident){
  
  $.get("../include/actualizar_notificaciones.php",
    { act: act, id: ident
    }, function(data){
        $("#respuesta").html(data);
    }); 

}

</script>

