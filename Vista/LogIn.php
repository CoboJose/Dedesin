<?php
	session_start();
  	include_once("../Gestiona/gestionBD.php");
 	include_once("../Gestiona/gestionUsuario.php");
 	$conexion = crearConexionBD();

	if (isset($_REQUEST['DNI_CIF'])){
		$DNI_CIF= $_REQUEST['DNI_CIF'];
		$Contrasena = $_REQUEST['Contrasena'];
		

		$Gerente = consultarGerente($conexion, $DNI_CIF, $Contrasena);
		$Trabajador = consultarTrabajador($conexion, $DNI_CIF, $Contrasena);
		$Cliente = consultarCliente($conexion, $DNI_CIF, $Contrasena);

		
		if($Trabajador == 1){
			$TipoUsuario = "Trabajador";
		}

		if($Cliente == 1){
			$TipoUsuario = "Cliente";}

		
		if($Gerente == 1){
			$TipoUsuario = "Gerente";

		}

		if (isset($TipoUsuario)){
			$_SESSION['TipoUsuario'] = $TipoUsuario;
			$_SESSION['DNI_CIF'] = $_POST['DNI_CIF'];
			Header('Location: ../Vista/pagPrincipal.php');
				
		}

		else {

		echo "ERROR EN INICIAR SESIÓN, DNI/CIF O CONTRASEÑA INCORRECTO";
	
	}	}

		
		
		cerrarConexionBD($conexion);	

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<title>DEDESIN S.L</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../CSS/login.css">
  <script src="https://code.jquery.com/jquery-3.4.1.js" type="text/javascript"></script>
  <script src="../JS/validacion_login.js" type="text/javascript"></script>
  
</head>

<body>	
	<script>
		$(document).ready(function() {
			$("#login").on("submit", function() {
				return validateLogIn();
			});
		});
	</script>

	 <form id="login" class = "formulario" action="login.php" method="post" >
  <h1>Login</h1>
 
    
      <input type="text" id="DNI_CIF" placeholder="DNI/CIF" name="DNI_CIF" maxlength="9" required>

      <input type="password" id="Contrasena" placeholder="Contraseña" name="Contrasena" required>

  	  <input type="submit" name="submit" value="Enviar">
  </form>



</body>
</html>