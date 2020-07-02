<?php

session_start();

if (isset($_REQUEST["NUMEROFACTURA"])) {
	
	$factMod["NUMEROFACTURA"] = $_REQUEST["NUMEROFACTURA"];
	$factMod["CONTRATO"] = $_REQUEST["CONTRATO"];
	$factMod["FECHA"] = $_REQUEST["FECHA"];
	$factMod["SERIE"] = $_REQUEST["SERIE"];
	$factMod["CONCEPTO"] = $_REQUEST["CONCEPTO"];
	$factMod["BASE"] = $_REQUEST["BASE"];
	$factMod["TIPOIMPOSITIVO"] = $_REQUEST["TIPOIMPOSITIVO"];
	$factMod["IVA"] = $_REQUEST["IVA"];
	$factMod["TOTAL"] = $_REQUEST["TOTAL"];
	$factMod["FECHAPAGO"] = $_REQUEST["FECHAPAGO"];
	$factMod["IMPORTE"] = $_REQUEST["IMPORTE"];
	$factMod["FORMAPAGO"] = $_REQUEST["FORMAPAGO"];
	$factMod["CODIGO"] = $_REQUEST["CODIGO"];
	$factMod["STATUS"] = $_REQUEST["STATUS"];
	$factMod["PAGO"] = $_REQUEST["PAGO"];
	$factMod["RECEPCION"] = $_REQUEST["RECEPCION"];
	$factMod["PERSONARECEPCION"] = $_REQUEST["PERSONARECEPCION"];
	$factMod["FECHARECEPCION"] = $_REQUEST["FECHARECEPCION"];
	$factMod["OBSERVACIONES"] = $_REQUEST["OBSERVACIONES"];
	$factMod["ID_SC"] = $_REQUEST["ID_SC"];
	$factMod["DNI_CIF"] = $_REQUEST["DNI_CIF"];

	$_SESSION["factMod"] = $factMod;

	if(isset($_REQUEST["editar"])) 		Header("Location: ../Vista/facturasGerente.php");
	else if(isset($_REQUEST["grabar"])) Header("Location: ../Accion/accion_modificar_factura.php");
	else 								Header("Location: ../Accion/accion_borrar_factura.php");

}

else{
	Header("Location: ../Vista/facturasGerente.php");
}

?>