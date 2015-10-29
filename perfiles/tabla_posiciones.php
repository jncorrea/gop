<?php
	date_default_timezone_set('America/Guayaquil');
	$hoy = date("Y-m-d H:i:s", time());
	extract($_GET);
	$id_campeonato=$_GET['id'];
?>

<div class="col-lg-12">
	<h2 style="text-align:center;"> TABLA DE POSICIONES </h2><br>


	<section id="no-more-tables">
        <table class="table table-bordered table-striped table-condensed cf">
            <thead class="cf">
                <tr>
                                      
                <th class="success" title="Posici&oacute;n">POS</th>
                <th class="success">Nombre del Grupo</th>
                <th class="success" title="Partidos Jugados">PJ</th>
                <th class="success" title="Partidos Ganados">PG</th>
                <th class="success" title="Partidos Empatados">PE</th>
                <th class="success" title="Partidos Perdidos">PP</th>
                <th class="success" title="Goles a favor">GF</th>
                <th class="success" title="Goles en contra">GC</th>
                <th class="success">PUNTOS</th>
                <th class="success" title="Goles de diferencia">GD</th>
             </tr>

            </thead>
            <tbody>
            
            	<?php
            	// declaración de variables
            	$lista_grupos_camp=0;
            	$grupos_cam[0]=0;
            	
            	$logo_grupo="";
            	$nom_grupo="";
            	$miconexion->consulta("select id_grupo from grupos_campeonato where id_campeonato=".$id_campeonato." ");			    
			    $x=0;
			    $num_grupos_camp=$miconexion->numregistros();

		if ($num_grupos_camp==0) {
			echo "<tr> <th colspan='10'> <h4 style='text-align:center;'> No hay Grupos Participantes para construir la tabla de Posiciones </h4></th></tr>";
			    
		}else{
						    
			    for ($i=0; $i <$num_grupos_camp; $i++) { 
			    	$lista_grupos_camp=$miconexion->consulta_lista();
			    	$grupos_camp[$i]=$lista_grupos_camp[0];
			    }			    

				for ($i=0; $i <count($grupos_camp) ; $i++) { 
										
					$ganados=0;
				    $perdidos=0;
				    $empate=0;
				    $jugados=0;
				    $goles_afavor=0;
				    $goles_encontra=0;
				    $goles_diferencia=0;
				    $mi_num_grupo=0;

			    	$miconexion->consulta("select equipo_a, res_a, res_b from partidos where equipo_a=".$grupos_camp[$i]."  and id_campeonato=".$id_campeonato." ");
			    	$mi_num_grupo=$miconexion->numregistros();

			    	if ($mi_num_grupo>0) {
			    		
			    		for ($j=0; $j <$mi_num_grupo ; $j++) {
			    		$resultados=$miconexion->consulta_lista(); 
			    		if ($resultados[1]>$resultados[2]) {
			    			$ganados++;
			    			$goles_encontra=$goles_encontra + $resultados[2];
			    		}elseif ($resultados[1]<$resultados[2]) {
			    			$perdidos++;
			    			$goles_encontra=$goles_encontra + $resultados[2];
			    			
			    		}else{
			    			$empate++;
			    			$goles_encontra=$goles_encontra + $resultados[2];
			    		}
			    		$goles_afavor=$goles_afavor + $resultados[1];
			    		

			    		}		    				    	
			    	}
			    	
			    	$mi_num_grupo=0;
			    	$miconexion->consulta("select equipo_b, res_a, res_b from partidos where equipo_b=".$grupos_camp[$i]." and id_campeonato=".$id_campeonato."");
			    	$mi_num_grupo=$miconexion->numregistros();
			    	if ($mi_num_grupo>0) {
			    		
			    		for ($j=0; $j <$mi_num_grupo ; $j++) {
			    		$resultados=$miconexion->consulta_lista(); 
			    		if ($resultados[2]>$resultados[1]) {
			    			$goles_encontra=$goles_encontra+$resultados[1];
			    			$ganados++;
			    		}elseif ($resultados[2]<$resultados[1]) {
			    			$perdidos++;
			    			$goles_encontra=$goles_encontra+$resultados[1];

			    		}else{
			    			$empate++;
			    			$goles_encontra=$goles_encontra + $resultados[2];
			    		}
			    		$goles_afavor=$goles_afavor + $resultados[2];
			    		
			    		}		    				    	
			    	}
			    	$jugados=$ganados + $perdidos + $empate;
			    	$goles_diferencia=$goles_afavor - $goles_encontra;
			    	$puntos=($ganados*3)+($empate*1);


			    	$matriz[$i]['id_grupo']=$grupos_camp[$i];
			    	$matriz[$i]['pj']=$jugados;
			    	$matriz[$i]['pg']=$ganados;
			    	$matriz[$i]['pe']=$empate;
			    	$matriz[$i]['pp']=$perdidos;
			    	$matriz[$i]['gf']=$goles_afavor;
			    	$matriz[$i]['gc']=$goles_encontra;
			    	$matriz[$i]['puntos']=$puntos;
			    	$matriz[$i]['gd']=$goles_diferencia;

			}
		
		// Obtener una lista de columnas
		foreach ($matriz as $valor) {
		    $puntos_f[] = $valor['puntos'];
		    $goles_gd[] = $valor['gd'];
		}

		// ORDENAMOS LA MATRIZ CON PUNTOS descendiente, Y GOLES A FAVOR DESCENDIENTE
		// Agregar $matriz como el último parámetro, para ordenar por la clave común
		array_multisort($puntos_f, SORT_DESC, $goles_gd, SORT_DESC, $matriz);

			$m=1;
			foreach($matriz as $valor) {
				$miconexion->consulta("select nombre_grupo, logo from grupos where id_grupo=".$valor['id_grupo']."");
				$lista_consulta=$miconexion->consulta_lista();
				$nom_grupo=$lista_consulta[0];
				$logo_grupo=$lista_consulta[1];				

			echo "<tr>";
			echo '<td class="numeric" data-title="POS">'.$m.'';
				if ($logo_grupo!="") {
					echo '<td class="numeric" data-title="Nombre"><img alt="Imagen de grupo"  class="img-circle" style="width:40px; height:40px;" src="images/grupos/'.$valor['id_grupo'].'/'.$logo_grupo.'" > '.$nom_grupo. '</td>';
				}else{
					echo '<td class="numeric" data-title="Nombre"><img alt="Imagen de grupo" class="img-circle" style="width:40px; height:40px;" src="../assets/img/soccer1.png" > '.$nom_grupo. '</td>';
				}
	        echo '<td class="numeric" data-title="PJ">'.$valor['pj'].'</td>
	        <td class="numeric" data-title="PG">'.$valor['pg'].'</td>
	        <td class="numeric" data-title="PE">'.$valor['pe'].'</td>
	        <td class="numeric" data-title="PP">'.$valor['pp'].'</td>
	        <td class="numeric" data-title="GF">'.$valor['gf'].'</td>
	        <td class="numeric" data-title="GC">'.$valor['gc'].'</td>
	        <td class="success" data-title="PUNTOS">'.$valor['puntos'].'</td>
	        <td class="numeric" data-title="GD">'.$valor['gd'].'</td>
			';
			echo "</tr>";
			$m++;
			}
	}
	?>
                </tbody>
                </table>
                <h5> * Partido Ganado: 3 pts <br> * Partido Empatado: 1 pts <br> * Partido Perdido: 0 pts</h5>
        </section>


                      
 </div>