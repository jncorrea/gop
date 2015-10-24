<?php                
    for ($i=0; $i < $miconexion->numregistros(); $i++) { 
        $datos=$miconexion->consulta_lista();
        $grupos[$datos[0]]=$datos[1]; 
    }
?>
<div class="table-scrollable">
    <table class="table table-hover table-light">
        <thead>
            <tr>
                <th width="10" > Etapa </th>
                <th> Partidos </th>
                <th width="30"> Opciones </th>
            </tr>
        </thead>
        <tbody>
            <?php                
                $miconexion->consulta("select id_etapa, etapa FROM etapas WHERE id_campeonato = ".$id);
                for ($i=0; $i < $miconexion->numregistros(); $i++) { 
                    $etapas=$miconexion->consulta_lista();
            ?>
            <tr>
                <td> <?php echo ($i+1) ?> </td>
                <td>
                    <?php 
                        $miconexion->consulta("select p.id_partido, p.nombre_partido, p.equipo_a, p.equipo_b from partidos p, etapa_partidos ep where p.id_partido = ep.id_partido and ep.id_etapa = ".$etapas[0]);
                        for ($i=0; $i < $miconexion->numregistros(); $i++) { 
                            $partidos=$miconexion->consulta_lista();
                     ?>                    
                        <div class="dashboard-stat2 col-lg-4 col-md-4 col-sm-4 col-xs-5 user-info" style="border: 1px solid #dddddd;">
                            <div class="display">
                                <div class="number">
                                    <small><?php echo $partidos[1]; ?></small>
                                    <span title="Jugado" class="label label-sm label-success img-circle" style="font-size:5px;"> </span>                                
                                </div>
                                <div class="icon">
                                    <span class="icon-pencil"></span>
                                </div>
                            </div>
                            <div class="progress-info">
                                <div class="row list-separated profile-stat">
                                    <div class="col-md-4 col-sm-4 col-xs-6">
                                        <small><?php echo $grupos[$partidos[2]]; ?></small>
                                        <img class='img-circle' style='width:60px; height:60px;' src='../assets/img/soccer1.png'>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-6">
                                        VS
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-6">
                                        <small><?php echo $grupos[$partidos[3]]; ?></small>
                                        <img class='img-circle' style='width:60px; height:60px;' src='../assets/img/soccer1.png'>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    <?php } ?>
                </td>
                <td>
                    <a class="btn green-haze" onclick="set_etapa('<?php echo $etapas[0]; ?>')" data-toggle="modal" href="#nuevo_partido" title="Nuevo Partido" style="background:#4CAF50; float: right; border-radius: 50% !important; margin-right:20px;"><i class="icon-plus"></i></a>                    
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
                        $miconexion->consulta("Select id_grupo, nombre_grupo from grupos");
                        $miconexion->opciones(0);
                    ?>
               </select>
            </div>
            <label for="equipoB" class="col-xs-1 col-sm-1 control-label">vs. </label>
            <div class="col-xs-5 col-sm-4">
              <select style="border-radius:5px;" id="equipoA" name="equipo_b" class="form-control">
                <?php 
                    $miconexion->consulta("Select id_grupo, nombre_grupo from grupos");
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