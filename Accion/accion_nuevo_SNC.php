<?php 

	session_start();	
	
	require_once("../Gestiona/gestionBD.php");
	require_once("../Gestiona/gestionarServiciosNoContratados.php");

	if(isset($_SESSION["servicioNoContratado"])){

		$SNC = $_SESSION["servicioNoContratado"];
		unset($_SESSION["servicioNoContratado"]);
		$nuevoSNC["FECHA"] = $SNC["FECHA"];
		$nuevoSNC["HORA"] = $SNC["HORA"];
		$nuevoSNC["DURACION"] = $SNC["DURACION"];
		$nuevoSNC["OBSERVACIONES"] = $SNC["OBSERVACIONES"];
		$nuevoSNC["DNI_CIF"] = $SNC["DNI_CIF"];
		$nuevoSNC["TIPOTRATAMIENTO"] = $SNC["TIPOTRATAMIENTO"];
		$nuevoSNC["TIPOMAQUINAS"] = $SNC["TIPOMAQUINAS"];
		$nuevoSNC["TIPOMATERIALES"] = $SNC["TIPOMATERIALES"];
		$nuevoSNC["TIPOSERVICIOS"] = $SNC["TIPOSERVICIOS"];
		$nuevoSNC["TIPOPLAGAS"] = $SNC["TIPOPLAGAS"];
		

		$conexion = crearConexionBD();

		$nuevo = nuevo_SNC($conexion,$nuevoSNC);

		cerrarConexionBD($conexion);

		if($nuevo == ""){
			header("Location: ../Vista/serviciosNoContratadosClientes.php");
		}else{
			$_SESSION["excepcion"] = $nuevo;
			header("Location: ../Vista/excepcion.php");
			}

	} 
	else{
		Header("Location: ../Vista/MisContrataciones.php");
	}	

 ?>