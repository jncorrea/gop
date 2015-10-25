<?php    
    $miconexion->consulta("select id_grupo, nombre_grupo, logo from grupos");            
    for ($i=0; $i < $miconexion->numregistros(); $i++) { 
        $datos=$miconexion->consulta_lista();
        $grupos[$datos[0]]=$datos[1];
        $grupos_img[$datos[0]]=$datos[2];
    }
?>
<div class="table-scrollable">
    <table class="table table-hover table-light">
        <thead>
            <tr>
                <th width="10" > # </th>
                <th> Partidos </th>
                <th width="30"> Opciones </th>
            </tr>
        </thead>
        <tbody>
            <?php                
                $miconexion->consulta("select id_etapa, etapa FROM etapas WHERE id_campeonato = ".$id);
                for ($i=0; $i < $miconexion->numregistros(); $i++) { 
                    $datos=$miconexion->consulta_lista();
                    $etapas[$i]=$datos[0];
                }
                for ($i=0; $i < count($etapas); $i++) {    
            ?>
            <tr>
                <td> <?php echo "Etapa".($i+1) ?> </td>
                <td>
                    <?php 
                        $miconexion->consulta("select p.id_partido, p.nombre_partido, p.equipo_a, p.equipo_b, p.fecha_partido, p.hora_partido, p.res_a, p.res_b from partidos p, etapa_partidos ep where p.id_partido = ep.id_partido and ep.id_etapa = ".$etapas[$i]);
                        for ($j=0; $j < $miconexion->numregistros(); $j++) { 
                            $partidos=$miconexion->consulta_lista();
                            $fecha = date("d M Y",strtotime($partidos[4]));
                            $hora = date("H:i",strtotime($partidos[5]));
                     ?>                    
                        <div class="dashboard-stat2 col-lg-4 col-md-4 col-sm-4 col-xs-5 user-info" style="border: 1px solid #dddddd;">
                            <div class="display">
                                <div class="number">
                                    
                                    <?php 
                                        $fecha_p = date("Y-m-d H:i:s", strtotime($partidos[4]." ".$partidos[5]."-0500"));
                                        if ($fecha_p > date("Y-m-d H:i:S", time()) ){
                                     ?>
                                        <icon title="Por Jugar" class ='icon-circle' style = "color : #D8BD2A; Font-size: 11px;"></icon> <small title="<?php echo $partidos[1]; ?>"><?php echo nombres($partidos[1],13) ?></small><br><small style="font-size:80%;"><?php echo $fecha." ".$hora; ?></small>
                                    <?php }else{ ?>
                                        <icon title="Jugado" class ='icon-circle' style = "color : #4CAF50; Font-size: 11px;"></icon> <small title="<?php echo $partidos[1]; ?>"><?php echo nombres($partidos[1],13) ?></small><br><small style="font-size:80%;"><?php echo $fecha." ".$hora; ?></small> 
                                    <?php } ?>                                
                                </div>
                                <div class="icon">
                                    <span class="icon-pencil"></span>
                                </div>
                            </div>
                            <div class="progress-info">
                                <div class="row list-separated profile-stat" style="text-align:center;">
                                    <div class="col-md-5 col-sm-4 col-xs-6">
                                        <small title="<?php echo $grupos[$partidos[2]]; ?>" style="font-size:80%;"><?php echo nombres($grupos[$partidos[2]],8); ?> </small>
                                        <p>(<?php echo $partidos[6]; ?>)</p>
                                        <?php 
                                            if ($grupos_img[$partidos[2]]=="") { ?>
                                                <img class='img-circle' style='margin-left:10%; width:60px; height:60px;' src='../assets/img/soccer1.png'>
                                            <?php }else{ ?>
                                                <img class='img-circle' style='margin-left:10%; width:60px; height:60px;' src='<?php echo "images/grupos/"."$partidos[2]".$grupos_img[$partidos[2]] ?>'>
                                        <?php } ?>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-2">
                                        <br>VS                                        
                                    </div>
                                    <div class="col-md-5 col-sm-4 col-xs-6">
                                        <small title="<?php echo $grupos[$partidos[3]]; ?>" style="font-size:80%;"><?php echo nombres($grupos[$partidos[3]],8); ?></small>
                                        <p>(<?php echo $partidos[7]; ?>)</p>
                                        <?php 
                                            if ($grupos_img[$partidos[3]]=="") { ?>
                                                <img class='img-circle' style='margin-left:10%; width:60px; height:60px;' src='../assets/img/soccer1.png'>
                                            <?php }else{ ?>
                                                <img class='img-circle' style='margin-left:10%; width:60px; height:60px;' src='<?php echo "images/grupos/"."$partidos[3]".$grupos_img[$partidos[3]] ?>'>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    <?php } ?>
                </td>
                <td>
                    <a class="btn green-haze" onclick="set_etapa('<?php echo $etapas[$i]; ?>')" data-toggle="modal" href="perfil.php?op=campeonato&id=<?php echo $id; ?>&e=<?php echo $etapas[$i]; ?>&num=<?php echo $i; ?>#nuevo_partido" title="Nuevo Partido" style="background:#4CAF50; float: right; border-radius: 50% !important; margin-right:20px;"><i class="icon-plus"></i></a>                    
                </td>                    
            </tr>
            <?php }  ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="nuevo_partido" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
     <div class="modal-content">
      <div class="modal-header">
       <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
       <h4 class="modal-title">Nuevo Partido</h4>
      </div>
      <div class="modal-body">
        <div class="portlet-title">
          <div class="caption">
            <i class="icon-bubble font-red-sunglo"></i>
            <span style="color: red; font-size:11px; padding:10px;">
              * Campos requeridos
            </span>
          </div>
        </div>
        <hr>
        <form  method="post" action="" id="form_nuevo_evento" enctype="multipart/form-data" class="form-horizontal">
          <input type="hidden" name="bd" value="2">
          <div class="form-group">
            <label for="Nombre_Partido" class="col-xs-12 col-sm-2 control-label" required><span style="color:red;">* </span>Nombre del Partido:</label>
            <div class="col-sm-9" style="padding-top:12px;">
              <input type="text" class="form-control" id="nombre" name="nombre_partido" placeholder="Da un nombre al partido..">
            </div>
          </div>
          <div class="form-group">
            <label for="Descripcion" class="col-xs-12 col-sm-2 control-label">Descripci&oacute;n:</label>
            <div class="col-sm-9">
              <textarea type="text" class="form-control" id="descripcion" name="descripcion_partido" placeholder="Describe tu partido.."></textarea>
            </div>
          </div>
            <div class="form-group">
              <label for="Fecha" class="col-xs-12 col-sm-2 control-label"><span style="color:red;">* </span>Cuando: </label>
              <div class="col-xs-12 col-sm-4" id="datepairExample">
                <input type="text" class="date start form-control" id="dateformatExample" name="fecha_partido" placeholder="yyyy-mm-dd" min="08-10-2015" required />
              </div>
              <label for="Hora" class="col-xs-12 col-sm-2 control-label"><span style="color:red;">* </span>Hora: </label>
              <div class="col-xs-12 col-sm-3">
                <input type="text" class="time start form-control" id="timeformatExample" name="hora_partido" data-scroll-default="12:00:00" placeholder="00:00:00" required/>
              </div>
              <div id="alerta"></div>
            </div>   
            <div id="error" style="margin-left:5%; color:red; font-size:90%;"></div>
            <br>
            <article>                      
            <script>     
                $('#datepairExample .date').datepicker({
                    'format': 'yyyy-m-d',
                    'autoclose': true,                        
                });
                $(function() {
                    $( "#dateformatExample" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
                    $( "#dateformatExample" ).datepicker( "option", "yearRange", "-99:+0" );
                    $( "#dateformatExample" ).datepicker( "option", "minDate", "+0m +0d" );
                    $( "#dateformatExample" ).datepicker('setDate', new Date());
                });           
            </script> 
            <script>
                $(function() {
                  $('#timeformatExample').timepicker({ 'timeFormat': 'H:i:s'});
                });
            </script>
          </article>          
          <div class="form-group">
            <label for="equipoA" class="col-xs-12 col-sm-2 control-label">Equipos:</label>
            <div class="col-xs-5 col-sm-4">
                <select style="border-radius:5px;" id="equipoA" name="equipo_a" class="form-control">
                    <?php 
                        if (@$_GET['num'] == 0) {
                            $miconexion->consulta("select g.id_grupo, g.nombre_grupo from grupos_campeonato c, grupos g where c.id_grupo = g.id_grupo and c.id_campeonato=".$id);
                            $miconexion->opciones(0);
                        }else {
                            $miconexion->consulta("select p.id_partido, p.equipo_a, p.equipo_b, p.res_a, p.res_b from etapa_partidos ep, partidos p where ep.id_partido = p.id_partido and id_etapa = ".(@$_GET['e']-1));
                        }
                    ?>
                </select>
            </div>
            <label for="equipoB" class="col-xs-1 col-sm-1 control-label">vs. </label>
            <div class="col-xs-5 col-sm-4">
                <select style="border-radius:5px;" id="equipoB" name="equipo_b" class="form-control">
                    <?php 
                        $miconexion->consulta("select g.id_grupo, g.nombre_grupo from grupos_campeonato c, grupos g where c.id_grupo = g.id_grupo and c.id_campeonato=".$id);
                        $miconexion->opciones(0);
                    ?>
                </select>
            <input type="hidden" id="id_etapa" name="etapa">
            </div>
          </div>               
          <div id="respuesta"></div>
        </form>
      </div>
      <div class="modal-footer">
       <button type="button" class="btn default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn green-haze" style="background:#4CAF50;" onclick='enviar_form("../include/insertar_evento.php","form_nuevo_evento");'>Guardar</button>
      </div>
     </div>
     <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div> 

<script>
    function set_etapa(etapa){
        document.getElementById("id_etapa").value=etapa;
    }
</script>

<?php 
    function nombres($nombre, $limit){
        $mostrar ="";
        for ($i=0; $i < strlen($nombre); $i++) {
            $mostrar.=$nombre[$i];
            if ($i-1==$limit) {
                $mostrar.="..";
                break;
            }
        }
        return $mostrar;
    }
 ?>