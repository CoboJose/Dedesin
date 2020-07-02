<?php
	session_start();

	require_once("../Gestiona/gestionBD.php");
	require_once("../Gestiona/gestionaClientes.php");
	require_once("../Gestiona/gestionaTrabajadores.php");
	require_once("../Gestiona/gestionaServiciosNoContratados.php");
	require_once("../Gestiona/gestionaTratamientos.php");
	
	if(!isset($_SESSION['DNI_CIF'])){

		Header('Location: ../Vista/inicio.php');
	}
	else{
	if (isset($_SESSION["servNC"])){
		$servicio = $_SESSION["servNC"];
		unset($_SESSION["servNC"]);
	}
	else{
		Header("Location: ../Vista/servicionNoContratadosGerente.php");
	}
}
	$dni_cif = $servicio["DNI_CIF"];
	$conexion = crearConexionBD();
	$cliente = consultaCliente($conexion, $dni_cif);
	$trabajadores = listarTrabajadores($conexion);
	$tratamientos = listarTratamientos($conexion);
	
    cerrarConexionBD($conexion);
	
	
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js" type="text/javascript"></script>
  <script src="../JS/validacion_servicio_contratado.js" type="text/javascript"></script>
  <link rel="stylesheet" type="text/css" href="../CSS/sncGerente.css"/>
<title>DEDESIN S.L</title>
</head>
<body>
	<header>
	<?php include_once("../Cabeceras/cabeceraGerente.php"); ?>
	</header>
	<script>
		$(document).ready(function() {
			$("#crearServicio").on("submit", function() {
				return validateForm();
			});
		});
	</script>
	<!-- Formulario de creacion de SC -->
	<h1><B>NUEVA CONTRATACION</B></h1>
	<div class="contrat">
	<form id="crearServicio" name="crearServicio" onsubmit="return validateForm()" method="GET" action="../Validacion/validacion_nuevo_servicio_contratado.php">
		<div class="datos_cliente">
			<label><?php echo "DNI/CIF del cliente: ".$servicio['DNI_CIF'] ?></label>		
			<input id="DNI_CIF" name="DNI_CIF" type="hidden" value="<?php echo $servicio['DNI_CIF'] ?>" pattern="/^[0-9]{8}[A-Z]$/" required/><br>
			<label><?php echo "Nombre del cliente: ".$cliente["NOMBRE"] ?></label>
			<input id="NOMBRE" name="NOMBRE" type="hidden" value="<?php echo $cliente['NOMBRE'] ?>" required/><br>
			<label><?php echo "Telefono del cliente: ".$cliente["TELEFONO"] ?></label>
			<input id="TELEFONO" name="TELEFONO" type="hidden" value="<?php echo $cliente['TELEFONO'] ?>" pattern="/^\d{9}$/" required/><br>
			<label><?php echo "Dirección del cliente: "?></label>
			<input id="LUGAR" name="LUGAR" type="text" required/><br>
			<label><?php echo "Cancelaciones indebidas: ".$cliente["CANCELACIONESINDEBIDAS"] ?></label>
			<input id="CANCELACIONESINDEBIDAS" name="CANCELACIONESINDEBIDAS" type="hidden" 
			value="<?php echo $cliente['CANCELACIONESINDEBIDAS']; ?>" required/>
		</div>
		<div class="info">
			<label><?php echo "Fecha: ".$servicio["FECHA"]; ?></label>
			<input type="hidden" name="FECHA" id="FECHA" value="<?php echo $servicio['FECHA']?>" pattern="/[0-3][0-9]-[01][0-2]-[0-2][0-9][0-9][0-9]/" required/><br>
			<label><?php echo "Duracion (Horas): "?></label>
			<input type="text" name="DURACION" id="DURACION" value="<?php echo $servicio['DURACION'];?>" placeholder="1,2" pattern="[0-9]|(([0-9]|[1-9][0-9]),[0-9])" required/><br>
			<label><?php echo "Hora: ".$servicio["HORA"]; ?></label>
			<input type="hidden" name="HORA" id="HORA" value="<?php echo $servicio['HORA']?>" pattern="/([01]?[0-9]|2[0-3]):[0-5][0-9]/"/><br>
			<label for="trabajador">Trabajador:</label>
				<select name="NUMEROTRABAJADOR" id="NUMEROTRABAJADOR" pattern="/\d/" required>
				<?php foreach ($trabajadores as $trabajador) {?>
					<option value="<?php echo $trabajador['NUMEROTRABAJADOR'] ?>"><?php echo $trabajador['NOMBRE'] ?></option>
				<?php } ?>
				</select><br/>
		</div>
		<div class="esp">
		<h2><b>Tratamiento:</b></h2>
		</div>
		<div>
			<label><?php echo "Tipo plaga: " ?></label>
			<input type="text" name="TIPOPLAGAS" id="TIPOPLAGAS" value="<?php echo $servicio['TIPOPLAGAS']?> "/><br>
			<label><?php echo "Tipo tratamiento: " ?></label>
			<input type="text" name="TIPOTRATAMIENTO" id="TIPOTRATAMIENTO" value="<?php echo $servicio['TIPOTRATAMIENTO']?> "/><br>
		</div>
		<div class="esp">
		<br><a><b>Información adicional:</b></a><br>
		</div>
		<div>
			<label><?php echo "Observaciones: ".$servicio["OBSERVACIONES"];?></label>
			<input id="OBSERVACIONES" name="OBSERVACIONES" type="hidden" value="<?php echo $servicio['OBSERVACIONES'] ?>" required/><br>
			<label><?php echo "Tipo maquina: " ?></label>
			<input type="text" name="TIPOMAQUINAS" id="TIPOMAQUINAS" value="<?php echo $servicio['TIPOMAQUINAS']?> "/><br>
			<label><?php echo "Tipo material: " ?></label>
			<input type="text" name="TIPOMATERIALES" id="TIPOMATERIALES" value="<?php echo $servicio['TIPOMATERIALES']?> "/><br>
			<label><?php echo "Tipo servicio: " ?></label>
			<input type="text" name="TIPOSERVICIOS" id="TIPOSERVICIOS" value="<?php echo $servicio['TIPOSERVICIOS']?> "/><br>
			<label for="tratamiento">Peligro y protección:</label>
				<select name="ID_T" id="ID_T" pattern="/\d/" required>
				<?php foreach ($tratamientos as $tratamiento) {?>
					<option value="<?php echo $tratamiento['ID_T'] ?>"><?php echo $tratamiento['PELIGRO'] ?></option>
				<?php } ?>
				</select><br/>
			<!-- Parámetros que faltan para crear el SC -->
			<input type="hidden" name="NUMEROFACTURA" id="NUMEROFACTURA" value="1" pattern="/\d/"/>
			<input type="hidden" name="COMPLETADO" id="COMPLETADO" value="No"/>
			<input type="hidden" name="ID_SNC" id="ID_SNC" value="<?php echo $servicio['ID_SNC']?>"/>
			
		</div>
		<button id="NUEVO" name="NUEVO" type="submit"><p class="but">CREAR</p></button>
	</form>
	</div>
	
</body>
</html>