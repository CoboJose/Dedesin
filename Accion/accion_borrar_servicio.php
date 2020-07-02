<?php	

	session_start();	
	
	if (isset($_SESSION["ServModGerent"])) {
		$servBorrar = $_SESSION["ServModGerent"];
		unset($_SESSION["ServModGerent"]);
		
		require_once("../Gestiona/gestionBD.php");
		require_once("../Gestiona/gestionarServicios.php");
		
		$conexion = crearConexionBD();

		$ID_SC = $servBorrar['ID_SC'];

		$borrar = borrar_servicio($conexion,$ID_SC);
		
		cerrarConexionBD($conexion);

		if($borrar == "")
			header("Location: ../Vista/agendaGerente.php");
		else
		{
			$_SESSION["excepcion"] = $borrar;
			header("Location: ../Vista/error.php");
		}

	}
	else
		Header("Location: ../Vista/agendaGerente.php"); 
?>