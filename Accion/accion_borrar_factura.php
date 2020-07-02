<?php	

	session_start();	
	
	if (isset($_SESSION["factMod"])) {
		$facturaBorrar = $_SESSION["factMod"];
		unset($_SESSION["factMod"]);
		
		require_once("../Gestiona/gestionBD.php");
		require_once("../Gestiona/gestionarFacturas.php");
		
		$conexion = crearConexionBD();

		$numFactura = $facturaBorrar['NUMEROFACTURA'];

		$borrar = borrar_factura($conexion,$numFactura);
		
		cerrarConexionBD($conexion);

		if($borrar == "")
			header("Location: ../Vista/facturasGerente.php");
		else
		{
			$_SESSION["excepcion"] = $borrar;
			header("Location: ../Vista/error.php");
		}

	}
	else
		Header("Location: ../Vista/facturasGerente.php"); 
?>