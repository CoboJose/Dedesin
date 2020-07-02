<?php 

	session_start();	
	
	require_once("../Gestiona/gestionBD.php");
	require_once("../Gestiona/gestionarVehiculos.php");

	if(isset($_REQUEST["Matricula"])){

		$nuevoVehiculo["Matricula"] = $_REQUEST["Matricula"];
		$nuevoVehiculo["Modelo"] = $_REQUEST["Modelo"];
		$nuevoVehiculo["KmTotales"] = $_REQUEST["KmTotales"];
		$nuevoVehiculo["NumBastidor"] = $_REQUEST["NumBastidor"];
		$nuevoVehiculo["ITV"] = $_REQUEST["ITV"];
		$nuevoVehiculo["Seguro"] = $_REQUEST["Seguro"];
		$nuevoVehiculo["NumTrabajador"] = $_REQUEST["NumTrabajador"];

		$errores = validarNuevoVehiculo($nuevoVehiculo);

		// Si se han detectado errores
		if (count($errores)>0) {
			// Guardo en la sesión los mensajes de error y volvemos al formulario
			$_SESSION["errores"] = $errores;
			$_SESSION["vehicNuevo"] = $nuevoVehiculo;
			Header('Location: ../Vista/vehiculosGerente.php');
		}
		else{
			$conexion = crearConexionBD();

			$nuevo = nuevo_vehiculo($conexion,$nuevoVehiculo);

			cerrarConexionBD($conexion);

			if($nuevo == "")
				header("Location: ../Vista/vehiculosGerente.php");
			else{
				$_SESSION["excepcion"] = $nuevo;
				header("Location: ../Vista/error.php");
				}
		}

		

	} 
	else{
		Header("Location: ../Vista/vehiculosGerente.php");
	}

	function validarNuevoVehiculo($nuevoVehiculo){

		$errores=array();

		//Validación Matricula
		if($nuevoVehiculo["Matricula"]==""){ 
			$errores[] = "<p>La Matricula no puede estar vacía</p>";
		}else if(!preg_match("/^([A-Z]{2} [0-9]{4} [A-Z]{2})|([0-9]{4} [A-Z]{3})$/", $nuevoVehiculo["Matricula"])){
			$errores[] = "<p>La Matricula es incorrecta: Debe consistir de letras y números</p>";
		}
		//Validación Modelo
		if($nuevoVehiculo["Modelo"]==""){ 
			$errores[] = "<p>El Modelo no puede estar vacío</p>";
		}	
		//Validación Km Totales
		if($nuevoVehiculo["KmTotales"]==""){ 
			$errores[] = "<p>Los KmTotales no pueden estar vacíos</p>";
		}else if(!filter_var($nuevoVehiculo["KmTotales"], FILTER_VALIDATE_FLOAT)){
			$errores[] = "<p>KmTotales es incorrecto: Debe ser un número</p>";
		}
		//Validación Bastidor
		if($nuevoVehiculo["NumBastidor"]==""){ 
			$errores[] = "<p>El NumBastidor no puede estar vacío</p>";
		}else if(!preg_match("/[A-Z]/", $nuevoVehiculo["NumBastidor"]) || !preg_match("/[0-9]/", $nuevoVehiculo["NumBastidor"])){
			$errores[] = "<p>El NumBastidor es incorrecta: Debe consistir de letras y números</p>";
		}
		//Validacion Fecha ITV
		if($nuevoVehiculo["ITV"]==""){ 
			$errores[] = "<p>La Fecha ITV no puede estar vacía</p>";
		}else if(!validar_fecha($nuevoVehiculo["ITV"])){
			$errores[] = "<p>Fecha ITV no es válida: ".$nuevoVehiculo["ITV"]."</p>";
		}
		//Validacion Fecha Seguro
		if($nuevoVehiculo["Seguro"]==""){ 
			$errores[] = "<p>La Fecha Seguro no puede estar vacía</p>";
		}else if(!validar_fecha($nuevoVehiculo["Seguro"])){
			$errores[] = "<p>Fecha Seguro no es válida: ".$nuevoVehiculo["Seguro"]."</p>";
		}
		//Validacion Trabajador
		if($nuevoVehiculo["NumTrabajador"]==""){ 
			$errores[] = "<p>Trabajador no puede estar vacío</p>";
		}else if(!filter_var($nuevoVehiculo["NumTrabajador"],FILTER_VALIDATE_INT)){
			$errores[] = "<p>Trabajador no es válido: ".$nuevoVehiculo["NumTrabajador"]." Debe ser un número</p>";
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

 ?>