<?php

	session_start();	
	
	require_once("../Gestiona/gestionBD.php");
	require_once("../Gestiona/gestionarServicios.php");

	// Si venimos de agenda Gerente
	if(isset($_SESSION["ServModGerent"])){
		
		$servMod = $_SESSION["ServModGerent"];
		unset($_SESSION["ServModGerent"]);

		$errores = validarModificarServicio($servMod);

		// Si se han detectado errores
		if (count($errores)>0) {
			// Guardo en la sesión los mensajes de error y volvemos al formulario
			$_SESSION["errores"] = $errores;
			$_SESSION["ServModGerent"] = $servMod;
			Header('Location: ../Vista/agendaGerente.php');
		}
		else{
			$conexion = crearConexionBD();

			$modificar = modificar_servicio_gerente($conexion,$servMod);

			cerrarConexionBD($conexion);

			if($modificar == "")
				Header("Location: ../Vista/agendaGerente.php");
			else
			{
				$_SESSION["excepcion"] = $modificar;
				header("Location: ../Vista/error.php");
			}
		}	
	}

	// Si venimos de agenda Trabajador
	elseif(isset($_SESSION["ServModTrab"])){

		$servMod = $_SESSION["ServModTrab"];
		unset($_SESSION["ServModTrab"]);

		$conexion = crearConexionBD();

		if (!($servMod["COMPLETADO"]=="Si" || $servMod["COMPLETADO"]=="No")) {
			// Guardo en la sesión los mensajes de error y volvemos al formulario
			$_SESSION["errores"] = "Completado debe ser Si o No";
			Header('Location: ../Vista/agendaTrabajador.php');
		}
		else{
			$modificar = modificar_servicio_trabajador($conexion,$servMod);

			cerrarConexionBD($conexion);

			if($modificar == "")
				Header("Location: ../Vista/agendaTrabajador.php");
			else
			{
				$_SESSION["excepcion"] = $modificar;
				header("Location: ../Vista/error.php");
			}
		}
	}

	else{
		Header("Location: ../Vista/error.php");
	}

	function validarModificarServicio($servMod){

		$errores=array();

		//Validación Fecha
		if($servMod["FECHA"]==""){ 
			$errores[] = "<p>La fecha no puede estar vacía</p>";
		}else if(!preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $servMod["FECHA"])){
			$errores[] = "<p>La fecha debe seguir el patron DD/MM/YYYY: " . $servMod["FECHA"]. "</p>";
		}
		//Validación Hora
		if(isset($servMod["HORA"]) && !preg_match("/([01][0-9]|2[0-3]|[1-9]):[0-5][0-9]/", $servMod["HORA"])){
			$errores[] = "<p>La hora debe seguir el patron hh:mm: " . $servMod["HORA"]. "</p>";
		}
		//Validación Lugar
		if($servMod["LUGAR"]==""){ 
			$errores[] = "<p>El LUGAR no puede estar vacío</p>";
		}
		//Validación Duracion
		if($servMod["DURACION"]=="") 
			$errores[] = "<p>La duracion no puede estar vacío</p>";
		else if($servMod["DURACION"]==strval(floatval($servMod["DURACION"]))){
			$errores[] = "<p>La duracion debe ser un número con decimales: " . $servMod["DURACION"]. "</p>";
		}
		//Validación Trabajador
		$conexion = crearConexionBD();
		$error = validarNumTrabajador($conexion, $servMod["NUMEROTRABAJADOR"]);		
		cerrarConexionBD($conexion);
		if($error!="")
			$errores[] = $error;
		//Validación Tratamientos
		if($servMod["TIPOTRATAMIENTO"]==""){ 
			$errores[] = "<p>El TRATAMIENTOS no puede estar vacío</p>";
		}
		//Validación Máquinas
		if($servMod["TIPOMAQUINAS"]==""){ 
			$errores[] = "<p>El MAQUINAS no puede estar vacío</p>";
		}
		//Validación Materiales
		if($servMod["TIPOMATERIALES"]==""){ 
			$errores[] = "<p>El MATERIALES no puede estar vacío</p>";
		}
		//Validación Servicios
		if($servMod["TIPOSERVICIOS"]==""){ 
			$errores[] = "<p>El SERVICIOS no puede estar vacío</p>";
		}
		//Validación Plagas
		if($servMod["TIPOPLAGAS"]==""){ 
			$errores[] = "<p>El PLAGAS no puede estar vacío</p>";
		}
		//Validación Observaciones
		if($servMod["OBSERVACIONES"]==""){ 
			$errores[] = "<p>Observaciones no puede estar vacío</p>";
		}
		//Validación Completado
		if(!($servMod["COMPLETADO"]=="Si" || $servMod["COMPLETADO"]=="No")){ 
			$errores[] = "<p>Completado debe ser Si o No</p>";
		}
		return $errores;
	}	 

	function validar_fecha($fecha){
		$valores = explode('-', $fecha);
		if(count($valores) == 3 && checkdate($valores[1], $valores[2], $valores[0])){
			return true;
	    }
		return false;
	}

	function validarNumTrabajador($conexion, $numeroTrabajador){
	$error="";
	$trabajador = consultaTrabajadorNum($conexion, $numeroTrabajador);
	$cont = 0;
	foreach($trabajador as $m){
		$cont = $cont + 1;
	}
	if($cont != 1){
		$error =  "<p>El número de trabajador no es válido</p>";
	}
	return $error;
}	

	function consultaTrabajadorNum($conexion,$num){
		$consulta = "SELECT nombre FROM Trabajadores where NumeroTrabajador = :numTrab";
		$stmt = $conexion->prepare($consulta);
		$stmt -> bindParam(':numTrab',$num);
		$stmt -> execute();
		return $stmt -> fetchAll();
	}

?>