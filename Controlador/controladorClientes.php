<?php
session_start();

if(isset($_REQUEST["DNI_CIF"])){

	$clMod["DNI_CIF"] = $_REQUEST["DNI_CIF"];
	$clMod["Contrasena"] = $_REQUEST["Contrasena"];
	$clMod["Telefono"] = $_REQUEST["Telefono"];
	$clMod["Email"] = $_REQUEST["Email"];
	$clMod["TipoCliente"] = $_REQUEST["TipoCliente"];
	$clMod["Nombre"] = $_REQUEST["Nombre"];
	$clMod["FormaPago"] = $_REQUEST["FormaPago"];
	$clMod["NumeroCuenta"] = $_REQUEST["NumeroCuenta"];
	$clMod["CancelacionesIndebidas"] = $_REQUEST["CancelacionesIndebidas"];

	$_SESSION["clMod"] = $clMod;

	if(isset($_REQUEST["editar"])){
		Header("Location: ../Vista/cuentaCliente.php");
	}
	 else if(isset($_REQUEST["grabar"])){
	 	Header("Location: ../Validacion/validacion_modificacion_cliente.php");
	}
}


?>