<?php	
	session_start();
	
	// if (isset($_REQUEST["ID_SNC"])){
		// $snc["ID_SNC"] = $_REQUEST["ID_SC"];
		// $snc["FECHA"] = $_REQUEST["FECHA"];
		// $snc["HORA"] = $_REQUEST["HORA"];
		// $snc["LUGAR"] = $_REQUEST["LUGAR"];
		// $snc["DURACION"] = $_REQUEST["DURACION"];
		// $snc["ID_TSER"] = $_REQUEST["ID_TSER"];
		// $snc["OBSERVACIONES"] = $_REQUEST["OBSERVACIONES"];
		// $snc["DNI_CIF"] = $_REQUEST["DNI_CIF"];
		// $snc["TIPOTRATAMIENTO"] = $_REQUEST["TIPOTRATAMIENTO"];
		// $snc["TIPOSERVICIOS"] = $_REQUEST["TIPOSERVICIOS"];
		// $snc["TIPOPLAGAS"] = $_REQUEST["TIPOPLAGAS"];
		// $snc["TIPOMAQUINAS"] = $_REQUEST["TIPOMAQUINAS"];
		// $snc["TIPOMATERIALES"] = $_REQUEST["TIPOMATERIALES"];
// 		
			// $_SESSION["sncMod"] = $sncMod;
		
		if(isset($_REQUEST["enviarNuevoSNC"])) Header("Location: ../Accion/accion_nuevo_SNC.php");
		else 								Header("Location: ../Vista/excepcion.php");
	// }else{
		// header("Location: excepcion.php");
	// }
		// //Meto en la sesion la información de la Contratación
		// $_SESSION["snc"] = $snc;
// 		
		// //Creo conexion a base Datos
		// $conexion = crearConexionBD();
// 		
		// if(isset($_REQUEST["editar"])) Header("Location: sncesGerente.php");
		// elseif (isset($_REQUEST["grabar"])) Header("Location: accion_modificar_snc.php");
		// else 								Header("Location: accion_borrar_snc.php");
		
	

?>
