<?php 

	session_start();	
	
	if (isset($_SESSION["factMod"])) {
		$factMod = $_SESSION["factMod"];
		unset($_SESSION["factMod"]);
		
		require_once("../Gestiona/gestionBD.php");
		require_once("../Gestiona/gestionarFacturas.php");

		$errores = validarModificarFactura($factMod);

		// Si se han detectado errores
		if (count($errores)>0) {
			// Guardo en la sesión los mensajes de error y volvemos al formulario
			$_SESSION["errores"] = $errores;
			$_SESSION["factMod"] = $factMod;
			Header('Location: ../Vista/facturasGerente.php');
		} 
		else{
			$conexion = crearConexionBD();

			$modificar = modificar_factura($conexion,$factMod);

			cerrarConexionBD($conexion);

			if($modificar == "")
				header("Location: ../Vista/facturasGerente.php");
			else
			{
				$_SESSION["excepcion"] = $modificar;
				header("Location: ../Vista/error.php");
			}	
		}
	} 
	else 
		Header("Location: ../Vista/facturasGerente.php"); 


	function validarModificarFactura($factMod){

		$errores=array();

		//Validacion Fecha
		if($factMod["FECHA"]==""){ 
			$errores[] = "<p>La Fecha no puede estar vacía</p>";
		}else if(!validar_fecha($factMod["FECHA"])){
			$errores[] = "<p>Fecha no es válida: ".$factMod["FECHA"]."</p>";
		}
		//Validacion Serie
		if($factMod["SERIE"]==""){ 
			$errores[] = "<p>SERIE no puede estar vacío</p>";
		}
		//Validacion Concepto
		if($factMod["CONCEPTO"]==""){ 
			$errores[] = "<p>CONCEPTO no puede estar vacío</p>";
		}
		//Validacion Tipo Impositivo
		if($factMod["TIPOIMPOSITIVO"]==""){ 
			$errores[] = "<p>Los TIPOIMPOSITIVO no pueden estar vacíos</p>";
		}else if(!filter_var($factMod["TIPOIMPOSITIVO"], FILTER_VALIDATE_INT)){
			$errores[] = "<p>TIPOIMPOSITIVO es incorrecto: Debe ser un número</p>";
		}
		//Validacion IVA
		if($factMod["IVA"]==""){ 
			$errores[] = "<p>Los IVA no pueden estar vacíos</p>";
		}else if(!filter_var($factMod["IVA"], FILTER_VALIDATE_INT)){
			$errores[] = "<p>IVA es incorrecto: Debe ser un número</p>";
		}
		//Validacion Total
		if($factMod["TOTAL"]==""){ 
			$errores[] = "<p>Los TOTAL no pueden estar vacíos</p>";
		}else if(!filter_var($factMod["TOTAL"], FILTER_VALIDATE_INT)){
			$errores[] = "<p>TOTAL es incorrecto: Debe ser un número</p>";
		}
		//Validacion Fecha Pago
		if($factMod["FECHAPAGO"]==""){ 
			$errores[] = "<p>La Fecha FECHAPAGO no puede estar vacía</p>";
		}else if(!validar_fecha($factMod["FECHAPAGO"])){
			$errores[] = "<p>Fecha FECHAPAGO no es válida: ".$factMod["FECHAPAGO"]."</p>";
		}
		//Validacion Importe
		if($factMod["IMPORTE"]==""){ 
			$errores[] = "<p>Los IMPORTE no pueden estar vacíos</p>";
		}else if(!preg_match("/[0-9]/",$factMod["IMPORTE"])){
			$errores[] = "<p>IMPORTE es incorrecto: Debe ser un número</p>";
		}
		//Validacion Forma Pago
		if($factMod["FORMAPAGO"]==""){ 
			$errores[] = "<p>FORMAPAGO no puede estar vacío</p>";
		}
		//Validacion Estado
		if($factMod["STATUS"]==""){ 
			$errores[] = "<p>STATUS no puede estar vacío</p>";
		}
		//Validacion Pago
		if($factMod["PAGO"]==""){ 
			$errores[] = "<p>PAGO no puede estar vacío</p>";
		}else if(!preg_match("/[0-1]/", $factMod["PAGO"])){
			$errores[] = "<p>La PAGO es incorrecta: Debe ser 1 o 0</p>";
		}
		//Validacion Recepcion
		if($factMod["RECEPCION"]==""){ 
			$errores[] = "<p>RECEPCION no puede estar vacío</p>";
		}else if(!preg_match("/[0-1]/", $factMod["RECEPCION"])){
			$errores[] = "<p>RECEPCION es incorrecta: Debe ser 1 o 0</p>";
		}
		//Validacion Persona Recepcion
		if($factMod["PERSONARECEPCION"]==""){ 
			$errores[] = "<p>PERSONARECEPCION no puede estar vacío</p>";
		}
		//Validacion Fecha Recepcion
		if($factMod["FECHARECEPCION"]==""){ 
			$errores[] = "<p>La Fecha FECHARECEPCION no puede estar vacía</p>";
		}else if(!validar_fecha($factMod["FECHARECEPCION"])){
			$errores[] = "<p>Fecha FECHARECEPCION no es válida: ".$factMod["FECHARECEPCION"]."</p>";
		}
		//Validacion Observaciones
		if($factMod["OBSERVACIONES"]==""){ 
			$errores[] = "<p>OBSERVACIONES no puede estar vacío</p>";
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