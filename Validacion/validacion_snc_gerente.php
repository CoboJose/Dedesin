<?php
    session_start();

if(isset($_REQUEST["id_snc"])){

	$servNC["ID_SNC"] = $_REQUEST["id_snc"];
	$servNC["FECHA"] = $_REQUEST["fecha"];
	$servNC["HORA"] = $_REQUEST["hora"];
	$servNC["DURACION"] = $_REQUEST["duracion"];
	$servNC["OBSERVACIONES"] = $_REQUEST["observaciones"];
	$servNC["DNI_CIF"] = $_REQUEST["dni_cif"];
	$servNC["TIPOTRATAMIENTO"] = $_REQUEST["tipoTratamiento"];
	$servNC["TIPOMAQUINAS"] = $_REQUEST["tipoMaquinas"];
	$servNC["TIPOMATERIALES"] = $_REQUEST["tipoMateriales"];
	$servNC["TIPOSERVICIOS"] = $_REQUEST["tipoServicios"];
	$servNC["TIPOPLAGAS"] = $_REQUEST["tipoPlagas"];

	$_SESSION["servNC"] = $servNC;
	$errores = validarSNC($servNC);
	if (count($errores)>0) {
		$_SESSION["errores"] = $errores;
		Header("Location: ../Vista/servicionNoContratadosGerente.php");
	} else
		Header("Location: ../Vista/ContratacionParaGerente.php");
}

function validarSNC($nuevoServicioNoContratado){
		// Validación ID_SNC
		if($nuevoServicioNoContratado["ID_SNC"]=="")
			$errores[] = "<p>El ID_SNC no puede estar vacío</p>";
		else if(!preg_match("/^(0|[1-9][0-9]*)$/", $nuevoServicioNoContratado["ID_SNC"]))
			$errores[] = "<p>El ID_SNC debe de ser un número entero</p>";
			
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
		if(isset($nuevoServicioNoContratado["HORA"]) && !preg_match("/^([01][0-9]|2[0-3]):[0-5][0-9]$/", $nuevoServicioNoContratado["HORA"])){
			$errores[] = "<p>La hora debe seguir el patron hh:mm: " . $nuevoServicioNoContratado["HORA"]. "</p>";
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