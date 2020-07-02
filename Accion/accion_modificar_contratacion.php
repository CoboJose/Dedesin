<?php	
	session_start();	
	
	if (isset($_SESSION["contratMod"])) {
		$contratMod = $_SESSION["contratMod"];
		unset($_SESSION["contratMod"]);
		
		require_once("../Gestiona/gestionBD.php");
		require_once("../Gestiona/gestionarContrataciones.php");
		
		//En gestionarContrataciones tengo creado el modificar_parametros al que le paso todos y cada uno de los parámetros de la Contratación
		$conexion = crearConexionBD();		
		$excepcion = modificar_parametros($conexion, $vehiculoMod);
		cerrarConexionBD($conexion);
			
		if ($excepcion == "") {
			header("Location: ../Vista/ContratacionesGerente.php");
		}else{
			$_SESSION["excepcion"] = $excepcion;
			header("Location: ../Vista/error.php");
		}

	} 
	else 
		Header("Location: ../Vista/ContratacionesGerente.php");
			// $_SESSION["excepcion"] = $excepcion;
			// $_SESSION["destino"] = "ContratacionesGerente.php";
			// Header("Location: excepcion.php");
		// }
		// else
			// Header("Location: ContratacionesGerente.php");
	// } 
	// else Header("Location: ContratacionesGerente.php"); // Se ha tratado de acceder directamente a este PHP
?>
