<?php 

session_start();

	require_once("../Gestiona/gestionBD.php");
	require_once("../Gestiona/gestionarServiciosNoContratados.php");
	require_once("../Gestiona/gestionaTratamientos.php");
	
	$conexion = crearConexionBD();
	if(isset($_SESSION['DNI_CIF'])){
        $OidCliente = $_SESSION['DNI_CIF'];
    }
    else{
      
        Header('Location: ../Vista/inicio.php');
  
    }
	$tratamientos = listarTratamientos($conexion);
	cerrarConexionBD($conexion);
	?>
	
<!DOCTYPE html>
<html lang="es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../CSS/cabecera_cliente.css">
    <link rel="stylesheet" type="text/css" href="../CSS/pagPrincipal.css"/>
    <link rel="stylesheet" href="../CSS/pie.css">
    <script src="https://code.jquery.com/jquery-3.4.1.js" type="text/javascript"></script>
    <script src="../JS/validacion_nuevo_snc.js" type="text/javascript"></script>
	<title>DEDESIN S.L</title>
</head>

<body>
	<script>
		$(document).ready(function() {
			$("#formsnc").on("submit", function() {
				return validateSNC();
			});
		});
	</script>
<header>
   <?php include_once("../Cabeceras/cabeceraCliente.php"); ?>
</header>
<div class="todnc">
<form id="formsnc" method="POST" action="../Validacion/validacion_nuevo_snc.php">
	
	
	
   <h2 class="h2fg">Pedir nuevo servicio por el cliente: <?php echo $OidCliente ?> </h2>
    	<br />
   
			<label for="fecha">Fecha:</label>
			<input type="date" id="fecha" name="fecha" pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])" required/>
			<br />
			<label for="hora">Hora:</label>
			<input type="text" id="hora" name="hora" placeholder="HH:mm" pattern="([01][0-9]|2[0-3]|[1-9]):[0-5][0-9]" required/>
			<br />
			<label for="Observaciones">Observaciones:</label>
			<textarea id="observaciones" name="observaciones" rows="4" cols="40"  required></textarea>
			<br />
			<input type="hidden" id="duracion" name="duracion" value="" required/>
			<input type="hidden" id="dni_cif" name="dni_cif" value="<?php echo $OidCliente ?>" required/>
			<input type="hidden" id="tipoMaquinas" name="tipoMaquinas" value="" required/>
			<input type="hidden" id="tipoMateriales" name="tipoMateriales" value="" required/>
			<input type="hidden" id="tipoServicios" name="tipoServicios" value="" required/>
			<input type="hidden" id="TIPOTRATAMIENTO" name="TIPOTRATAMIENTO" value="" required/>
			<br />
			<label for="Tipo de Plaga">Tipo Plagas</label>
			<select name="TIPOPLAGAS" id="TIPOPLAGAS">
				<option value="Cucaracha">Cucaracha</option>
				<option value="Avispas">Avispa</option>
				<option value="Termitas">Termitas</option>
				<option value="Ratas">Ratas</option>
				<option value="Legionella">Legionella</option>
			</select>
    
    <br />
    <button class="but" id="enviarNuevoSNC"  type="submit" name="enviarNuevoSNC" class="enviarFormulario">
    	Enviar
    </button>
    </form>
</div>  	
  <div class="adicional">
	<p> Si no se encuentra el tipo de plaga a tratar en el campo correspondiente, es devido a que no tratamos dicha plaga.</p>
	<p> Ponga en observaciones la ubicación del lugar a tratar.</p>
	
</div>
<?php include_once("pie.php"); ?>
</body>

</html>