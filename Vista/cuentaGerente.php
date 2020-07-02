<?php  session_start();
	require_once("../Gestiona/gestionBD.php");
	require_once("../Gestiona/gestionUsuario.php");
	

	if(!isset($_SESSION['DNI_CIF'])){

		Header('Location: ../Vista/inicio.php');
	}
	else{
	if(isset($_REQUEST['salir'])){
		unset($_SESSION['DNI_CIF']);
		header('Location : ../Vista/inicio.php');
	}
	 if(isset($_SESSION["geMod"])){
            $clMod = $_SESSION["geMod"];
            unset($_SESSION["geMod"]);
    }

    $conexion = crearConexionBD();

	$usuario = $_SESSION['DNI_CIF'];
	$nombreUsuario =  consultarNombreGerente($conexion, $usuario);
	$telefono = consultarTelefonoGerente($conexion, $usuario);
    $contrasena = consultarContrasenaGerente($conexion,$usuario);
    $cuenta = consultarNumeroCuentaGerente($conexion, $usuario);
	$email = consultarEmailGerente($conexion, $usuario);

	}


 ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="../CSS/pagPrincipal.css">
	<link rel="stylesheet" href="../CSS/cabecera_cliente.css">
	<link rel="stylesheet" href="../CSS/pie.css">
    <title>DEDESIN S.L</title>
</head>
<body>
		<header>
		<?php include_once("../Cabeceras/cabeceraGerente.php"); ?>
			
		</header>
	
		 <h1>MIS DATOS</h1>
          <div class="tod">
          	 	<form>
                    <ul>
                        <li>DNI/CIF:               <?php echo $usuario ?> </li>
                        <li>Nombre:                  <?php echo $nombreUsuario?> </li>
                        <li>Teléfono:              <?php echo $telefono ?> </li>
                        <li>Email:      <?php echo $email ?> </li>
                        <li>Número de cuenta bancaria: <?php echo $cuenta ?> </li>
                    </ul>

                </form>
        <form action="inicio.php" method="GET">
			<input type="submit" name="salir" value="Cerrar cesión">
		</form>
	</div>
	<footer>
     <?php include_once("pie.php");
     cerrarConexionBD($conexion); ?>   
    </footer>
</body>
</html>