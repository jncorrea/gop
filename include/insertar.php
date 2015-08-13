<?php

extract($_POST); //extraer todos los valores del metodo post del formulario de ingresar
session_start();
include("../static/clase_mysql.php");
include("../static/site_config.php");
$miconexion = new clase_mysql;
$miconexion->conectar($db_name,$db_host, $db_user,$db_password);

function validatePassword1($password1){
	//NO tiene minimo de 5 caracteres o mas de 12 caracteres
	if(strlen($password1) < 5 || strlen($password1) > 12)
		return false;
	// SI longitud, NO VALIDO numeros y letras
	else if(!preg_match("/^[0-9a-zA-Z]+$/", $password1))
		return false;
	// SI rellenado, SI email valido
	else
		return true;
}

function validateUsuario($usuario){
	//NO tiene minimo de 5 caracteres o mas de 12 caracteres
	if(!preg_match("/^[0-9a-zA-Z]+$/", $usuario))
		return false;
	// SI longitud, SI caracteres A-z
	else
		return true;
}

function validatePassword2($password1, $password2){
	//NO coinciden
	if($password1 != $password2)
		return false;
	else
		return true;
}

function validateEmail($email){
	//NO hay nada escrito
	if(strlen($email) == 0)
		return false;
	// SI escrito, NO VALIDO email
	else if(!filter_var($_POST['email'], FILTER_SANITIZE_EMAIL))
		return false;
	// SI rellenado, SI email valido
	else
		return true;
}

function validateCaptcha($codCaptcha){
	//NO coinciden
	if(md5($codCaptcha) != $_SESSION['key'] )
		return false;
	else
		return true;
}

//Comprobacion de datos
//variables valores por defecto
$password1 = "";
$password2 = "";
$email = "";
$emailValue = "";
$codCaptcha = "";

$pass1= $_POST['password1'];
$pass2= $_POST['password2'];
$mail= $_POST['email'];
$user= $_POST['usuario'];
$captcha=$_POST['captcha'];

//almaceno en un array los valores recogidos del formulario
$informacion = array($pass1, $pass2, $mail);

//Validacion de datos enviados
if ($pass1 == "" && $pass2 == "" && $mail == "" && $user == "" && $captcha == "") {
	echo "<p style='color:red; text-align:center;'>Debe llenar todos los campos.</p>";
}else{
	if(!validatePassword1($_POST['password1'])){		
		$password1 = "error";
	}
	if(!validatePassword2($_POST['password1'], $_POST['password2'])){
		$password2 = "error";
	}
	if(!validateEmail($_POST['email'])){
		$email = "error";
	}
	if(!validateUsuario($_POST['usuario'])){
		$usuario = "error";
	}
	if(!validateCaptcha($_POST['captcha'])){
		$codCaptcha = "error";
		echo "<p style='color:red; text-align:center;'>No ha ingresado el codigo correcto</p>";
	}

	//Guardamos valores para que no tenga que reescribirlos	
	$emailValue = $_POST['email'];

		if($password1 != "error" && $password2 != "error" && $email != "error" && $usuario != "error" && $codCaptcha != "error"){
			$status = 1;
			$password_encriptada=md5($pass1);
		    $num=0;
		    $num2=0;
			$nombre=$user;

		    $miconexion->consulta("select email, pass, user from usuarios where user='".$nombre."'");
			$num = $miconexion->numregistros();			
			$miconexion->consulta("select email, pass, user from usuarios where email='".$mail."'");
			$num2 = $miconexion->numregistros();		
			if ($num>0) {
				echo "<p style='color:red; text-align:center;'>El usuario ya existe</p>";
			}else{
				if($num2>0){
					echo "<p style='color:red; text-align:center;'>El email ya existe</p>";
				}else{
					$list[0]='';
					$list[1]=$mail;
					$list[2]=$password_encriptada;
					$list[3]=$user;
					$sql=$miconexion->sql_ingresar1('usuarios',$list);
					if ($miconexion->consulta($sql)) {
						$_SESSION['email'] = $list[1];
						$_SESSION['user'] = $list[3];
						date_default_timezone_set('America/Guayaquil');
						$_SESSION["ultimoAcceso"]= date("Y-m-d H:i:s", time());	
						$miconexion->consulta("update usuarios set estado=1 where email = '".$_SESSION['email']."'");
						$miconexion->consulta("select id_user from usuarios where email = '".$list[1]."'");	
						$id_usu = $miconexion->consulta_lista();
						$_SESSION['id'] = $id_usu[0];					  
						$miconexion->consulta("select * from temp where email_temp = '".$list[1]."'");
						$email;
						$flag = $miconexion->numregistros();
						$sql1;
						if ($flag>0) {
							for ($i=0; $i < $flag; $i++) {
								$lista=$miconexion->consulta_lista();
								$x= "insert into user_grupo values
								('', '".$lista[1]."','".$id_usu[0]."','".date("Y-m-d H:i:s", time())."','0')";
								$sql1[$i] =$x;
							}
							for ($j=0; $j <$flag; $j++) { 
								$miconexion->consulta($sql1[$j]);
							}
							$miconexion->consulta("delete from temp where email_temp = '".$mail."'");
						}
						echo "<script>location.href = 'perfiles/perfil.php';</script>";
					}else{
						echo "Ocurrio un error. <br>No se ha podido registrar el nuevo usuario.";

					}
				}	
			}	
		}
	}
?>