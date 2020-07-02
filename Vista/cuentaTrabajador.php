<?php  session_start();
	require_once("../Gestiona/gestionBD.php");
	require_once("../Gestiona/gestionUsuario.php");	

    $conexion = crearConexionBD();

	$usuario = $_SESSION['DNI_CIF'];
	$nombreUsuario =  consultarNombreTrabajador($conexion, $usuario);
	$telefono = consultarTelefonoTrabajador($conexion, $usuario);
  	$hsemanales = consultarHorasSemanalesTrabajador($conexion,$usuario);
  	$hmensuales = consultarHorasMensualesTrabajador($conexion,$usuario);
    $hextras = consultarHorasExtrasTrabajador($conexion,$usuario);
  	$cuenta = consultarCuentaTrabajador($conexion, $usuario);
  	$social = consultarSeguridadSocialTrabajador($conexion, $usuario);
	$formacion = consultarFormacionTrabajador($conexion, $usuario);
	$matricula = consultarMatriculaTrabajador($conexion, $usuario);
	$direccion = consultarDireccionTrabajador($conexion,$usuario);

	//}

  if(!isset($_SESSION['DNI_CIF'])){

    Header('Location: ../Vista/inicio.php');
  }
  
	if(isset($_REQUEST['salir'])){
		unset($_SESSION['DNI_CIF']);
		header('Location : ../Vista/inicio.php');
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
		<?php include_once("../Cabeceras/cabeceraTrabajador.php"); ?>
			
		</header>
	
		 <h1 class="h1">MIS DATOS</h1>
     <div class="tod">
                  <form>
                    <ul>
                        <li>DNI/CIF:               <?php echo $usuario ?> </li>
                        <li>Nombre:                  <?php echo $nombreUsuario?> </li>
                        <li>Teléfono:              <?php echo $telefono ?> </li>
                        <li>Direccion:      <?php echo $direccion ?> </li>
                        <li>Horas semanales: <?php echo $hsemanales ?> </li>
                        <li>Horas mensuales: <?php echo $hmensuales ?> </li>
                        <li>Horas extras: <?php echo $hextras ?> </li>
                        <li>Formacion: <?php echo $formacion ?> </li>
                        <li>Numero de cuenta: <?php echo $cuenta ?> </li>
                        <li>Numero de la seguridad social: <?php echo $social ?> </li>
                        <li>Matricula: <?php echo $matricula ?> </li>
                    </ul>

                </form>
        <form action="inicio.php" method="GET">
			<input type="submit" name="salir" value="Cerrar cesión">
		</form>
  </div>
	<footer>
     <?php include_once("../pie.php");
     cerrarConexionBD($conexion); ?>   
    </footer>
</body>
</html>