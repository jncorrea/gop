<?php 
include("../static/site_config.php"); 
include ("../static/clase_mysql.php");
session_start();
$miconexion = new clase_mysql;
$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
extract($_GET);
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
    p.estado_partido, p.id_user from partidos p, centros_deportivos c 
    where p.id_centro = c.id_centro and p.id_grupo ='".$id."' and TIMESTAMP(p.fecha_partido, p.hora_partido) >='".$hoy."' 
    ORDER BY p.fecha_partido, p.hora_partido ASC");
    if ($miconexion->numregistros()==0) {
      echo "<br> <h4> Actualmente no existen partidos por jugar</h4>";
    }else{
      echo '<table class="table table-hover">';

      for ($i=0; $i <$miconexion->numregistros(); $i++) {
      $grupo_partidos=$miconexion->consulta_lista(); 
      $estado="";
       
        if ($grupo_partidos[6]==1) {
          $estado="Activo";
          
        }else{
          $estado="Cancelado";
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
                    <a href='perfil.php?op=alineacion&id=".$grupo_partidos[0]."'><span style='font-size: 13px; color: #006064; font-weight: bold;'>".strtoupper($grupo_partidos[2])."</span></a>
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
    p.equipo_b, p.res_a, p.res_b from partidos p, centros_deportivos c 
    where p.id_centro = c.id_centro and p.id_grupo ='".$id."' and TIMESTAMP(p.fecha_partido, p.hora_partido) <'".$hoy."' 
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