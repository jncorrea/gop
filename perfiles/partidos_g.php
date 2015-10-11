<?php 
$hoy = date("Y-m-d H:i:s", time());
 ?>
<div class="col-md-6 col-sm-6">
  <div class="portlet-title">
    <div class="caption">
      <strong>PARTIDOS POR JUGAR</strong> 
    </div> 
  </div>
  <?php
  $miconexion->consulta("select p.id_partido, c.centro_deportivo, p.nombre_partido, p.fecha_partido, p.hora_partido, p.hora_fin, 
    p.estado_partido, p.id_user from partidos p, centros_deportivos c, alineacion a 
    where p.id_centro = c.id_centro and p.id_grupo ='".$id."' and TIMESTAMP(p.fecha_partido, p.hora_partido) >='".$hoy."' 
    and a.id_partido = p.id_partido and a.id_user = '".$_SESSION['id']."'
    ORDER BY p.fecha_partido, p.hora_partido ASC");
    if ($miconexion->numregistros()==0) {
      echo "<br> <h4> Actualmente no existen partidos por jugar</h4>";
    }else{
      echo '<table class="table table-hover">';
      for ($i=0; $i <$miconexion->numregistros(); $i++) {
                $grupo_partidos=$miconexion->consulta_lista();
                $estado="";
                $href="";
                if ($grupo_partidos[6]==1) {
                  $estado="<strong style='color:#4CAF50;'>Activo<strong>";
                  $href = "<a href='perfil.php?op=alineacion&id=".$grupo_partidos[0]."'><span style='font-size: 13px; color: #006064; font-weight: bold;'>".strtoupper($grupo_partidos[2])."</span></a>";
                }else if ($grupo_partidos[6]==0){
                  $estado="<strong style='color:#D2383C;'>Cancelado<strong>";
                  $href = "<a href='perfil.php?op=alineacion&id=".$grupo_partidos[0]."'><span style='font-size: 13px; color: #006064; font-weight: bold;'>".strtoupper($grupo_partidos[2])."</span></a>";
                } else if ($grupo_partidos[6]==2){
                  $estado="<strong style='color:#A2A42C;'>Reserva Pendiente<strong>";
                  $href = "<a data-toggle='modal' href='#infor_partido' onclick='actualizar_notificacion(31,".$grupo_partidos[0].");'><span style='font-size: 13px; color: #006064; font-weight: bold;'>".strtoupper($grupo_partidos[2])."</span></a>";
                } else if ($grupo_partidos[6]==3){
                  $estado="<strong style='color:#D2383C;'>Reserva Rechazada<strong>";
                  $href = "<a onclick='actualizar_notificacion(33,$grupo_partidos[0]);'><span style='font-size: 13px; color: #006064; font-weight: bold;'>".strtoupper($grupo_partidos[2])."</span></a>";
                }
                echo "<tr >";
                if ($grupo_partidos[7]==$_SESSION['id']) {
                  echo '<td class="btn-group pull-right" style="padding-left:0px; padding-right:10px;">';
                  ?>
                  <a title="Eliminar partido" data-toggle="modal" onclick="eliminar(<?php echo $grupo_partidos[0] ?>);" href="#eliminar_partido" style="display:inline-block; background-color:transparent; margin: 0;padding: 0;">
                    <i style="font-size:14px;" class="icon-remove"></i>
                  </a>
                  <?php 
                }else{
                  echo "<td style='width:19.43px;'></td>";
                  }
                  echo "<td style='width:40px; vertical-align:middle;'><img class='img-circle' style='width:30px; height:30px;' src='../assets/img/pupos.png'> <br> </td>";
                  echo  "<td style='font-size: 12px;'><br>
                    ".$href."
                    &nbsp; &nbsp;<br>
                    Fecha: ".date('d-m-Y',strtotime($grupo_partidos[3]))."<br> Hora: ".$grupo_partidos[4]."<br>
                    Centro Deportivo: ".$grupo_partidos[1]."
                  <br>Estado: ".$estado." </td>";
                  echo "</tr>";
                }
              }
         ?>                              
    </table>
</div>
<div class="col-md-6 col-sm-6">
  <div class="portlet-title">
    <div class="caption">
      <strong>PARTIDOS JUGADOS</strong> 
    </div> 
  </div>
  <?php           
  $miconexion->consulta("select p.id_partido, c.centro_deportivo, p.nombre_partido, p.fecha_partido, p.hora_partido, p.hora_fin, p.equipo_a, 
    p.equipo_b, p.res_a, p.res_b from partidos p, centros_deportivos c, alineacion a 
    where p.id_centro = c.id_centro and p.id_grupo ='".$id."' and TIMESTAMP(p.fecha_partido, p.hora_partido) <'".$hoy."'
    and a.id_partido = p.id_partido and a.id_user = '".$_SESSION['id']."' 
    ORDER BY p.fecha_partido, p.hora_partido ASC");
  if ($miconexion->numregistros()==0) {
    echo "<br><h4> No se registran partidos jugados </h4>";
  }else{
    echo '<table class="table table-hover">';
    for ($i=0; $i <$miconexion->numregistros(); $i++) {
      $partidos_jugados=$miconexion->consulta_lista(); 
      if ($partidos_jugados[8]=="") {
        $res_A="-";
      }else{
        $res_A=$partidos_jugados[8];
      }
      if ($partidos_jugados[9]=="") {
        $res_B="-";
      }else{
        $res_B=$partidos_jugados[9];
      }
        echo "<tr >";                      
        echo "<td style='width:40px; vertical-align:middle;'><img class='img-circle' style='width:30px; height:30px;' src='../assets/img/pupos.png'> <br> </td>";
          echo  "<td style='font-size: 12px;'><br>
                <a href='perfil.php?op=alineacion&id=".$partidos_jugados[0]."'><span style='font-size: 13px; color: #006064; font-weight: bold;'>".strtoupper($partidos_jugados[2])."</span></a>
                &nbsp; &nbsp;<br>
                Fecha: ".date('d-m-Y',strtotime($partidos_jugados[3]))."
                <br>Hora : ".$partidos_jugados[4]."
                <br>Centro Deportivo: ".$partidos_jugados[1]."
                <br>".$partidos_jugados[6]." ( ".$res_A." ) vs. ".$partidos_jugados[7]." ( ".$res_B." ) </td>";                  
        echo "</tr>";
    }
  }
  ?>                             
  </table>
</div>

<a data-toggle='modal' href='#editar_partido' id='lanzar_editar_partido'></a>
<div class="modal fade" id="editar_partido" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
   <div class="modal-content">
    <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
     <h4 class="modal-title">Editar Partido</h4>
    </div>
    <div class="modal-body">
      <?php $editar_cancelado="editar"; include("editar_evento.php"); ?>
    </div>
    <div class="modal-footer">
     <button type="button" class="btn default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn green-haze" style="background:#4CAF50;" onclick='enviar_form("../include/actualizar_evento.php","form_editar_evento");'>Guardar</button>
    </div>
   </div>
  </div>
</div> 