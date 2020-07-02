<?php

	session_start();
	
	if (isset($_SESSION["servicioContratado"])) {
		$servicioContratado = $_SESSION["servicioContratado"];
		$_SESSION["servicioContratado"]=null;
		$_SESSION["errores"]=null;
	}else{
		header("Location: ../Vista/contratacionesGerente.php");
	}	
	
	require_once("../Gestiona/gestionBD.php");
	require_once("../Gestiona/gestionaServiciosContratados.php");
	require_once("../Gestiona/gestionaServiciosNoContratados.php");

	if(isset($servicioContratado["DNI_CIF"])){

		$conexion = crearConexionBD();
		//Crea el servicio contratado
		$nuevo = nuevo_servicio($conexion,$servicioContratado);
		//Elimina el servicio no contratado
		$id_snc = $servicioContratado["ID_SNC"];
		$eliminar = eliminarServiciosNoContratados($conexion,$id_snc);
		

		cerrarConexionBD($conexion);

		if($nuevo == "")
			header("Location: ../Vista/agendaGerente.php");
		else{
			$_SESSION["excepcion"] = $nuevo;
			header("Location: ../Vista/error.php");
			}

	} 
	else{
		Header("Location: ../Vista/contratacionesGerente.php");
	}	

?>