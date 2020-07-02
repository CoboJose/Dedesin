<?php	
	session_start();
	
	if (isset($_REQUEST["ID_SC"])){
		$contratacion["ID_SC"] = $_REQUEST["ID_SC"];
		$contratacion["FECHA"] = $_REQUEST["FECHA"];
		$contratacion["LUGAR"] = $_REQUEST["LUGAR"];
		$contratacion["DURACION"] = $_REQUEST["DURACION"];
		$contratacion["ID_TSER"] = $_REQUEST["ID_TSER"];
		$contratacion["OBSERVACIONES"] = $_REQUEST["OBSERVACIONES"];
		$contratacion["DNI_CIF"] = $_REQUEST["DNI_CIF"];
		$contratacion["NUMEROFACTURA"] = $_REQUEST["NUMEROFACTURA"];
		$contratacion["NUMEROTRABAJADOR"] = $_REQUEST["NUMEROTRABAJADOR"];
		$contratacion["ID_T"] = $_REQUEST["ID_T"];
		
			$_SESSION["contratMod"] = $contratMod;
		
		if(isset($_REQUEST["editar"])) Header("Location: ../Vista/ContratacionesGerente.php");
		elseif (isset($_REQUEST["grabar"])) Header("Location: ../Accion/accion_modificar_contratacion.php");
		else 								Header("Location: ../Accion/accion_borrar_contratacion.php");
	}else{
		header("Location: ../Vista/ContratacionesGerente.php");
	}
		//Meto en la sesion la información de la Contratación
		$_SESSION["contratacion"] = $contratacion;
		
		//Creo conexion a base Datos
		$conexion = crearConexionBD();
		
		if(isset($_REQUEST["editar"])) Header("Location: ../Vista/ContratacionesGerente.php");
		elseif (isset($_REQUEST["grabar"])) Header("Location: ../Accion/accion_modificar_contratacion.php");
		else 								Header("Location: ../Accion/accion_borrar_contratacion.php");
		
	

?>
