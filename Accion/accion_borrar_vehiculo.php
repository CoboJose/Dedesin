<?php	

	session_start();	
	
	if (isset($_SESSION["vehicMod"])) {
		$vehicMod = $_SESSION["vehicMod"];
		unset($_SESSION["vehicMod"]);
		
		require_once("../Gestiona/gestionBD.php");
		require_once("../Gestiona/gestionarVehiculos.php");
		
		$conexion = crearConexionBD();

		$matricula = $vehicMod['Matricula'];

		$borrar = borrar_vehiculo($conexion,$matricula);
		
		cerrarConexionBD($conexion);

		if($borrar == "")
			header("Location: ../Vista/vehiculosGerente.php");
		else
		{
			$_SESSION["excepcion"] = $borrar;
			header("Location: ../Vista/error.php");
		}

	}
	else
		Header("Location: ../Vista/vehiculosGerente.php"); 
?>