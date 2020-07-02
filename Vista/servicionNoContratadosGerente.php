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
	
	$servicios=consultaServiciosNoContratados($conexion);}
	
    cerrarConexionBD($conexion);
	
	
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>DEDESIN S.L</title>
  <link rel="stylesheet" href="../CSS/cabecera_gerente.css">
  <link rel="stylesheet" type="text/css" href="../CSS/sncGerente.css"/>
  <script src="https://code.jquery.com/jquery-3.4.1.js" type="text/javascript"></script>
  <script src="../JS/validacion_gerente_snc.js" type="text/javascript"></script>
</head>
<body>
	<script>
		$(document).ready(function() {
			$("#crearServicio").on("submit", function() {
				return validateSNC();
			});
		});
	</script>
	<header>
		<?php include_once("../Cabeceras/cabeceraGerente.php"); ?>
	</header>
	<?php
	if (isset($errores) && count($errores)>0) { 
	    	echo "<div id=\"div_errores\" class=\"error\">";
			echo "<h4> Errores en el formulario:</h4>";
    		foreach($errores as $error) echo $error; 
    		echo "</div>";
  		}
	?>
	<h1><B>Servicios Pendientes de Revisión</B></h1>
	<div class="serv">
	<?php foreach ($servicios as $servicio) {?>
		<form id="crearServicio" name="crearServicio" method="GET" action="../Validacion/validacion_snc_gerente.php">
			<div class="pav">
			<label>Servicio con ID: <?php echo $servicio['ID_SNC'] ?></label>
			<input type="hidden" id="id_snc" name="id_snc" value="<?php echo $servicio['ID_SNC'] ?>" required/>
			<input type="hidden" id="fecha" name="fecha" value="<?php echo $servicio['FECHA'] ?>" required/>
			<input type="hidden" id="hora" name="hora" value="<?php echo $servicio['HORA'] ?>" pattern="/^([01][0-9]|2[0-3]):[0-5][0-9]$/" required/>
			<input type="hidden" id="duracion" name="duracion" value="<?php echo $servicio['DURACION'] ?>" required/>
			<input type="hidden" id="observaciones" name="observaciones" value="<?php echo $servicio['OBSERVACIONES'] ?>" required/>
			<input type="hidden" id="dni_cif" name="dni_cif" value="<?php echo $servicio['DNI_CIF'] ?>" pattern="/^[0-9]{8}[A-Z]$/" required/>
			<input type="hidden" id="tipoTratamiento" name="tipoTratamiento" value="<?php echo $servicio['TIPOTRATAMIENTO'] ?>" required/>
			<input type="hidden" id="tipoMaquinas" name="tipoMaquinas" value="<?php echo $servicio['TIPOMAQUINAS'] ?>" required/>
			<input type="hidden" id="tipoMateriales" name="tipoMateriales" value="<?php echo $servicio['TIPOMATERIALES'] ?>" required/>
			<input type="hidden" id="tipoServicios" name="tipoServicios" value="<?php echo $servicio['TIPOSERVICIOS'] ?>" required/>
			<input type="hidden" id="tipoPlagas" name="tipoPlagas" value="<?php echo $servicio['TIPOPLAGAS'] ?>" required/>
			<input type="submit" name="crear" id="crear" value="Ver y crear servicio" />
			</div>
		</form>
	<?php } ?>
	</form>
</div>
		
	
</body>
</html>