<?php
header('Content-Type: text/html; charset=ISO-8859-1');

 class clase_mysql{
 	/*Variables para la conexion a la db*/
 	var $BaseDatos;
 	var $Servidor;
 	var $Usuario;
 	var $Clave;
 	/*Identificadores de conexion y consulta*/
 	var $Conexion_ID = 0;
 	var $Consulta_ID = 0;
 	/*Numero de error y error de textos*/
 	var $Errno = 0;
 	var $Error = "";
 	function clase_mysql(){
 		//cosntructor
 	}

 	function conectar($db, $host, $user, $pass){
 		if($db!="") $this->BaseDatos = $db;
 		if($host!="") $this->Servidor = $host;
 		if($user!="") $this->Usuario = $user;
 		if($pass!="") $this->Clave = $pass;

 		//conectamos al servidor de db
 		$this->Conexion_ID=mysql_connect($this->Servidor,$this->Usuario, $this->Clave);
 		if(!$this->Conexion_ID){
 			$this->Error="La conexion con el servidor fallida";
 			return 0;
 		}

		//Seleccionamos la base de datos
		if(!mysql_select_db($this->BaseDatos, $this->Conexion_ID)){
			$this->Error="Imposible abrir ".$this->BaseDatos;
 			return 0;
		} 	
		/*Si todo tiene exito, retorno el identificador de la conexion*/
 		return $this->Conexion_ID;
 	}	

 	//Ejecuta cualquier consulta
 	function consulta($sql=""){
 		if($sql==""){
 			$this->Error="NO hay ningun sql";
 			return 0;
 		}
 		//ejecutamos la consulta
 		$this->Consulta_ID = mysql_query($sql, $this->Conexion_ID);
 		if(!$this->Consulta_ID){
 			$this->Errno = mysql_errno();
 			$this->Error = mysql_error();
 		}
 		//retorna la consulta ejecutada
 		return $this->Consulta_ID;
 	}

 	//Devulve el numero de campos de la culsulta
 	function numcampos(){
 		return mysql_num_fields($this->Consulta_ID);
 	}

 	//Devuleve el numero de registros de la culsulta
 	function numregistros(){
 		return mysql_num_rows($this->Consulta_ID);
 	}

 	//Devuelve el nombre de un campo de la consulta
 	function nombrecampo($numcampo){
 		return mysql_field_name($this->Consulta_ID, $numcampo);
 	}

 	function consulta_lista(){
		while ($row = mysql_fetch_array($this->Consulta_ID)) {
			for ($i=0; $i < $this->numcampos(); $i++) { 
				$row[$i];
			}
			return $row;
		}
	}
	function sql_ingresar($nom, $val){		
		$cont=0;
		$sql="insert into ".$nom." values(''";
		foreach($val as $valor){ 
			$valor = $val[$cont];
			$sql =$sql.",'".$valor."'";
			$cont++;
		}
		$sql = $sql.")";
		return $sql;
	}
	function ingresar_sql($bd, $col, $val){
		$sql="insert into ".$bd." (";
		for ($i=0; $i < count($col); $i++) {
			if ($i == count($col)-1) {
				$sql .= $col[$i];
			}else{
				$sql .= $col[$i].",";
			}
		}
		$sql .= ") values ('";
		for ($i=0; $i < count($val); $i++) {
			if ($i == count($val)-1) {
				$sql .= $val[$i]."'";
			}else{
				$sql .= $val[$i]."','";
			}
		}
		$sql .= ")";
		return $sql;
	}
	function sql_ingresar1($nom, $val){
		$sql="insert into ".$nom." values(";
		for ($i=0; $i < count($val)+11; $i++) { 
			$excepcion=(count($val)+10);
						
			if ($i==$excepcion) {
				$sql =$sql."'0'";			
			}else if ($i == 13) {
				date_default_timezone_set('America/Guayaquil');
				@$fecha = date("Y-m-d H:i:s", time());
				$sql =$sql."'".@$fecha."',";
			}else if ($i == 12) {
				$sql =$sql."'1',";
			}else{
				$sql =$sql."'".@$val[$i]."',";
			}
		}
		$sql = $sql.",'".date("Y-m-d H:i:s", time())."');";
		return $sql;
	}
	
	function sql_actualizar($nom, $val, $col){
		$sql="update ".$nom." set ".$col[1]."= '".$val[1];
		for ($i=2; $i < count($val); $i++) { 
			$sql =$sql."', ".$col[$i]."= '".$val[$i];
		}		
		$sql = $sql."' where ".$col[0]." = '".$val[0]."'";
		return $sql;
	}	

	function sql_actualizar1($nom, $val, $col){
		$sql="update ".$nom." set ".$col[1]."= '".$val[1];
		for ($i=3; $i < count($val); $i++) { 
			$sql =$sql."', ".$col[$i]."= '".$val[$i];
		}		
		$sql = $sql."' where ".$col[0]." = '".$val[0]."'";
		return $sql;
	}

	function sql_actualizar_perfil($nom, $val, $col){
		$sql="update ".$nom." set ".$col[0]."= '".$val[0];
		for ($i=1; $i < count($val); $i++) { 
			$sql =$sql."', ".$col[$i]."= '".$val[$i];
		}		
		$sql = $sql."' where ".$col[1]." = '".$val[1]."'";
		return $sql;
	}

	function opciones($num){
		while ($row = mysql_fetch_array($this->Consulta_ID)) {
			if ($num == 0) {
    			echo "<option value='".$row[0]."'>".($row[1])."</option>";
			}else if ($num == 1) {
    			echo "<option value='".$row[0]."'>".$row[1].", ".$row[2]."</option>";
			}
		}
	}

	function opciones_multiples(){
		$i=0;
		while ($opcion = mysql_fetch_array($this->Consulta_ID)) {
    		echo "<input type='checkbox' name='deporte[$i]' value='".$opcion[0]."' > ".$opcion[1]."<br> ";
    		$i++;
		}
	}
	function opciones_multiples_centros(){
		$i=0;
		while ($opcion = mysql_fetch_array($this->Consulta_ID)) {
    		echo "<input type='checkbox' name='centro[$i]' value='".$opcion[0]."' > ".$opcion[2]."<br> ";
    		$i++;
		}
	}

	function tabla_horario($array){
		for ($i=0; $i < count($array); $i++) { 
			if ($i==0) {
				echo '
				<tr>
					<td rowspan = "'.count($array).'" style="text-align:center; vertical-align: middle;">'.$array[$i][0].'</td>
					<td>'.$array[$i][1].' - '.$array[$i][2].'</td>
					<td style="text-align:center; vertical-align: middle;"><a href="#" title="Editar"><i class="icon-pencil"></i></a></td>
					<td style="text-align:center; vertical-align: middle;"><a href="#" title="Eliminar"><i class="icon-remove"></i></a></td>
				</tr>';
			}else {
				echo '
				<tr>
					<td>'.$array[$i][1].' - '.$array[$i][2].'</td>
					<td style="text-align:center; vertical-align: middle;"><a href="#" title="Editar"><i class="icon-pencil"></i></a></td>
					<td style="text-align:center; vertical-align: middle;"><a href="#" title="Eliminar"><i class="icon-remove"></i></a></td>
				</tr>';
			}
		}
	}

}
?>
