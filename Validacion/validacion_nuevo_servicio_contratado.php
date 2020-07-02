<?php
    session_start();
	
	if (isset($_REQUEST["DNI_CIF"])) {
		// Recogemos los datos del formulario
		$nuevoServicioContratado["DNI_CIF"] = $_REQUEST["DNI_CIF"];
		$nuevoServicioContratado["NOMBRE"] = $_REQUEST["NOMBRE"];
		$nuevoServicioContratado["TELEFONO"] = $_REQUEST["TELEFONO"];
		$nuevoServicioContratado["LUGAR"] = $_REQUEST["LUGAR"];
		$nuevoServicioContratado["CANCELACIONESINDEBIDAS"] = $_REQUEST["CANCELACIONESINDEBIDAS"];
		$nuevoServicioContratado["FECHA"] = $_REQUEST["FECHA"];
		$nuevoServicioContratado["HORA"] = $_REQUEST["HORA"];
		$nuevoServicioContratado["NUMEROTRABAJADOR"] = $_REQUEST["NUMEROTRABAJADOR"];
		$nuevoServicioContratado["TIPOPLAGAS"] = $_REQUEST["TIPOPLAGAS"];
		$nuevoServicioContratado["TIPOTRATAMIENTO"] = $_REQUEST["TIPOTRATAMIENTO"];
		$nuevoServicioContratado["OBSERVACIONES"] = $_REQUEST["OBSERVACIONES"];
		$nuevoServicioContratado["TIPOMAQUINAS"] = $_REQUEST["TIPOMAQUINAS"];
		$nuevoServicioContratado["TIPOMATERIALES"] = $_REQUEST["TIPOMATERIALES"];
		$nuevoServicioContratado["TIPOSERVICIOS"] = $_REQUEST["TIPOSERVICIOS"];
		$nuevoServicioContratado["ID_T"] = $_REQUEST["ID_T"];
		$nuevoServicioContratado["DURACION"] = $_REQUEST["DURACION"];
		$nuevoServicioContratado["NUMEROFACTURA"] = $_REQUEST["NUMEROFACTURA"];
		$nuevoServicioContratado["COMPLETADO"] = $_REQUEST["COMPLETADO"];
		$nuevoServicioContratado["ID_SNC"] = $_REQUEST["ID_SNC"];		
	}else{
		Header("Location: ../Vista/ContratacionParaGerente.php");
	}
	$_SESSION["servicioContratado"] = $nuevoServicioContratado;

	$errores = validarDatosServicioContratado($nuevoServicioContratado);
	
	if (count($errores)>0) {
		$_SESSION["errores"] = $errores;
		Header('Location: ../Vista/ContratacionParaGerente.php');
	} else
		Header('Location: ../Accion/accion_crear_servicio_contratado.php');
		
	function validarDatosServicioContratado($nuevoServicioContratado){
		// Validación del NIF
		if($nuevoServicioContratado["DNI_CIF"]=="") 
			$errores[] = "<p>El NIF no puede estar vacío</p>";
		else if(!preg_match("/^[0-9]{1,8}[A-Z]$/", $nuevoServicioContratado["DNI_CIF"])){
			$errores[] = "<p>El NIF debe contener 8 números y una letra mayúscula: " . $nuevoServicioContratado["DNI_CIF"]. "</p>";
		}

		// Validación del Nombre			
		if($nuevoServicioContratado["NOMBRE"]=="") 
			$errores[] = "<p>El nombre no puede estar vacío</p>";
		
		// Validación del telefono
		if($nuevoServicioContratado["TELEFONO"]=="") 
			$errores[] = "<p>El telefono no puede estar vacío</p>";
		else if(!preg_match("/^\d{1,9}$/", $nuevoServicioContratado["TELEFONO"])){
			$errores[] = "<p>El telefono debe contener 9 números: " . $nuevoServicioContratado["TELEFONO"]. "</p>";
		}
	
		// Validacion del lugar
		if($nuevoServicioContratado["LUGAR"]=="") 
			$errores[] = "<p>El lugar no puede estar vacío</p>";
		
		// Validacion de cancelaciones indebidas
		if($nuevoServicioContratado["CANCELACIONESINDEBIDAS"]=="") 
			$errores[] = "<p>Las cancelaciones no pueden estar vacías</p>";
		else if(!preg_match("/^[0-3]{1}$/", $nuevoServicioContratado["CANCELACIONESINDEBIDAS"])){
			$errores[] = "<p>No puede contratar con más de 3 cancelaciones: " . $nuevoServicioContratado["CANCELACIONESINDEBIDAS"]. "</p>";
		}
		
		// Validacion de la fecha
		if($nuevoServicioContratado["FECHA"]==""){ 
			$errores[] = "<p>La fecha no puede estar vacía</p>";
		}else if(validar_fecha($nuevoServicioContratado["FECHA"])){
			$errores[] = "<p>La fecha debe seguir el patron DD/MM/YY: " . $nuevoServicioContratado["FECHA"]. "</p>";
		}
		
		// Validacion de la hora
		if(isset($nuevoServicioContratado["HORA"]) && !preg_match("/([01]?[0-9]|2[0-3]):[0-5][0-9]/", $nuevoServicioContratado["HORA"])){
			$errores[] = "<p>La hora debe seguir el patron hh:mm: " . $nuevoServicioContratado["HORA"]. "</p>";
		}
		
		// Validacion de numero trabajador
		if($nuevoServicioContratado["NUMEROTRABAJADOR"]=="") 
			$errores[] = "<p>El número de trabajador no puede estar vacío</p>";
		else if(!filter_var($nuevoServicioContratado["NUMEROTRABAJADOR"], FILTER_VALIDATE_INT)){
			$errores[] = "<p>El numero del trabajador debe ser un entero: " . $nuevoServicioContratado["NUMEROTRABAJADOR"]. "</p>";
		}
		
		// Validacion de id tratamiento
		if($nuevoServicioContratado["ID_T"]=="") 
			$errores[] = "<p>El id de tratamiento no puede estar vacío</p>";
		else if(!filter_var($nuevoServicioContratado["ID_T"], FILTER_VALIDATE_INT)){
			$errores[] = "<p>El id de tratamiento debe ser un entero: " . $nuevoServicioContratado["ID_T"]. "</p>";
		}
		
		// Validacion de duracion
		if($nuevoServicioContratado["DURACION"]=="") 
			$errores[] = "<p>La duracion no puede estar vacío</p>";
		else if(!preg_match("/^[0-9]|(([0-9]|[1-9][0-9]),[0-9])$/", $nuevoServicioContratado["DURACION"])){
			$errores[] = "<p>La duracion debe ser h,d: " . $nuevoServicioContratado["DURACION"]. "</p>";
		}

		// Validación de  observaciones			
		if($nuevoServicioContratado["OBSERVACIONES"]=="") 
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