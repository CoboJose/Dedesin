<?php
	session_start();

	require_once("../Gestiona/gestionBD.php");
	require_once("../Gestiona/gestionaServiciosNoContratados.php");
	if(!isset($_SESSION['DNI_CIF'])){
       Header('Location: ../Vista/inicio.php');
    }
    else{
	if (isset($_SESSION["crearServicio"])){
		$contratacion = $_SESSION["crearServicio"];
		unset($_SESSION["crearServicio"]);
	}
	if (isset($_SESSION["errores"])){
		$errores = $_SESSION["errores"];
		$_SESSION["errores"]=null;
	}
	$conexion = crearConexionBD();
	
	$dni_cif = $_SESSION['DNI_CIF'];
	$servicios=consultaServiciosNoContratadosClientes($conexion, $dni_cif);}
	
    cerrarConexionBD($conexion);
	
	
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="../CSS/cabecera_cliente.css">
  <link rel="stylesheet" type="text/css" href="../CSS/pagPrincipal.css"/>
  <link rel="stylesheet" href="../CSS/pie.css">
<title>DEDESIN S.L</title>
</head>
<body>
	<header>
		<?php include_once("../Cabeceras/cabeceraCliente.php"); ?>
	</header>
	<?php
	if (isset($errores) && count($errores)>0) { 
	    	echo "<div id=\"div_errores\" class=\"error\">";
			echo "<h4> Errores en el formulario:</h4>";
    		foreach($errores as $error) echo $error; 
    		echo "</div>";
  		}
	?>
	<h2><B>Servicios Pendientes de Revisión</B></h2>
	<div class="tod">
	<?php foreach ($servicios as $servicio) {?>
		<ul>
			<li>ID: <?php echo $servicio['ID_SNC'] ?></li>
			<li>Fecha: <?php echo $servicio['FECHA'] ?></li>
			<li>Hora: <?php echo $servicio['HORA'] ?></li>
			<li>Observaciones: <?php echo $servicio['OBSERVACIONES'] ?></li>
			<li>DNI_CIF: <?php echo $servicio['DNI_CIF'] ?></li>
			<li>Tipo plaga: <?php echo $servicio['TIPOPLAGAS'] ?></li>
		</ul>
	<?php } ?>
	</div>
	</form>
	<?php include_once("pie.php"); ?>
	
</body>
</html>