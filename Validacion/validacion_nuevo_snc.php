<?php
    session_start();
	
	if (isset($_REQUEST["enviarNuevoSNC"])) {
		// Recogemos los datos del formulario
		$nuevoServicioNoContratado["DNI_CIF"] = $_REQUEST["dni_cif"];
		$nuevoServicioNoContratado["FECHA"] = $_REQUEST["fecha"];
		$nuevoServicioNoContratado["HORA"] = $_REQUEST["hora"];
		$nuevoServicioNoContratado["TIPOPLAGAS"] = $_REQUEST["TIPOPLAGAS"];
		$nuevoServicioNoContratado["TIPOTRATAMIENTO"] = $_REQUEST["TIPOTRATAMIENTO"];
		$nuevoServicioNoContratado["OBSERVACIONES"] = $_REQUEST["observaciones"];
		$nuevoServicioNoContratado["TIPOMAQUINAS"] = $_REQUEST["tipoMaquinas"];
		$nuevoServicioNoContratado["TIPOMATERIALES"] = $_REQUEST["tipoMateriales"];
		$nuevoServicioNoContratado["TIPOSERVICIOS"] = $_REQUEST["tipoServicios"];
		$nuevoServicioNoContratado["DURACION"] = "0,0";		
	}else{
		Header("Location: ../Vista/NuevaContratacion.php");
	}
	$_SESSION["servicioNoContratado"] = $nuevoServicioNoContratado;

	$errores = validarDatosServicioNoContratado($nuevoServicioNoContratado);
	
	if (count($errores)>0) {
		$_SESSION["errores"] = $errores;
		Header('Location: ../Vista/NuevaContratacion.php');
	} else
		Header('Location: ../Accion/accion_nuevo_SNC.php');
		
	function validarDatosServicioNoContratado($nuevoServicioNoContratado){
		// Validación del NIF
		if($nuevoServicioNoContratado["DNI_CIF"]=="") 
			$errores[] = "<p>El NIF no puede estar vacío</p>";
		else if(!preg_match("/^[0-9]{8}[A-Z]$/", $nuevoServicioNoContratado["DNI_CIF"])){
			$errores[] = "<p>El NIF debe contener 8 números y una letra mayúscula: " . $nuevoServicioNoContratado["DNI_CIF"]. "</p>";
		}
		
		// Validacion de la fecha
		if($nuevoServicioNoContratado["FECHA"]==""){ 
			$errores[] = "<p>La fecha no puede estar vacía</p>";
		}else if(validar_fecha($nuevoServicioNoContratado["FECHA"])){
			$errores[] = "<p>La fecha debe seguir el patron DD/MM/YY: " . $nuevoServicioNoContratado["FECHA"]. "</p>";
		}
		
		// Validacion de la hora
		if(isset($nuevoServicioNoContratado["HORA"]) && !preg_match("/([01]?[0-9]|2[0-3]):[0-5][0-9]/", $nuevoServicioNoContratado["HORA"])){
			$errores[] = "<p>La hora debe seguir el patron hh:mm: " . $nuevoServicioNoContratado["HORA"]. "</p>";
		}
		
		// Validacion de duracion
		if($nuevoServicioNoContratado["DURACION"]=="") 
			$errores[] = "<p>La duracion no puede estar vacío</p>";
		else if(!preg_match("/^[0-9]|(([0-9]|[1-9][0-9]),[0-9])$/", $nuevoServicioNoContratado["DURACION"])){
			$errores[] = "<p>La duracion debe ser h,d: " . $nuevoServicioNoContratado["DURACION"]. "</p>";
		}

		// Validación de  observaciones			
		if($nuevoServicioNoContratado["OBSERVACIONES"]=="") 
			$errores[] = "<p>Las observaciones no pueden estar vacías</p>";
		
		return $errores;
	}

function validar_fecha($fecha){
		$valores = explode('-', $fecha);
		if(count($valores) == 3 && checkdate($valores[1], $valores[0], $valores[2])){
			return true;
	    }
		return false;
	}
?>