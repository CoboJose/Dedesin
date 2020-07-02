<?php 

	session_start();	
	
	if (isset($_SESSION["vehicMod"])) {
		$vehicMod = $_SESSION["vehicMod"];
		unset($_SESSION["vehicMod"]);
		
		require_once("../Gestiona/gestionBD.php");
		require_once("../Gestiona/gestionarVehiculos.php");

		$errores = validarModificarVehiculo($vehicMod);

		// Si se han detectado errores
		if (count($errores)>0) {
			// Guardo en la sesión los mensajes de error y volvemos al formulario
			$_SESSION["errores"] = $errores;
			$_SESSION["vehicMod"] = $vehicMod;
			Header('Location: ../Vista/vehiculosGerente.php');
		} 
		
		else{
			$conexion = crearConexionBD();

			$modificar = modificar_vehiculo($conexion,$vehicMod);

			cerrarConexionBD($conexion);

			if($modificar == "")
				header("Location: ../Vista/vehiculosGerente.php");
			else
			{
				$_SESSION["excepcion"] = $modificar;
				header("Location: ../Vista/error.php");
			}
		}

	} 
	else 
		Header("Location: ../Vista/vehiculosGerente.php");


	function validarModificarVehiculo($vehicMod){

		$errores=array();
		
		//Validación de Matricula
		if($vehicMod["Matricula"]=="")
			$errores[] = "<p>La matrícula no puede estar vacía</p>";
		else if(!preg_match("/^([A-Z]{2} [0-9]{4} [A-Z]{2})|([0-9]{4} [A-Z]{3})$/", $vehicMod["Matricula"]))
			$errores[] = "<p>La matrícula debe tener formato de 4 dígitos y 3 letras o 2 letras, 4 dígitos y 2 letras";

		//Validación Km Totales
		if($vehicMod["KmTotales"]==""){ 
			$errores[] = "<p>Los KmTotales no pueden estar vacíos</p>";
		}else if(!filter_var($vehicMod["KmTotales"], FILTER_VALIDATE_FLOAT)){
			$errores[] = "<p>KmTotales es incorrecto: Debe ser un número</p>";
		}
		//Validacion Fecha ITV
		if($vehicMod["ITV"]==""){ 
			$errores[] = "<p>La Fecha ITV no puede estar vacía</p>";
		}else if(!validar_fecha($vehicMod["ITV"])){
			$errores[] = "<p>Fecha ITV no es válida: ".$vehicMod["ITV"]."</p>";
		}
		//Validacion Fecha Seguro
		if($vehicMod["Seguro"]==""){ 
			$errores[] = "<p>La Fecha Seguro no puede estar vacía</p>";
		}else if(!validar_fecha($vehicMod["Seguro"])){
			$errores[] = "<p>Fecha Seguro no es válida: ".$vehicMod["Seguro"]."</p>";
		}
		//Validacion Trabajador
		if($vehicMod["NumTrabajador"]==""){ 
			$errores[] = "<p>Trabajador no puede estar vacío</p>";
		}else if(!filter_var($vehicMod["NumTrabajador"],FILTER_VALIDATE_INT)){
			$errores[] = "<p>Trabajador no es válido: ".$vehicMod["NumTrabajador"]." Debe ser un número</p>";
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

