<?php
session_start();

if(isset($_REQUEST["DNI_CIF"])){

	$servicioContratado["FECHA"] = $_REQUEST["FECHA"];
	$servicioContratado["HORA"] = $_REQUEST["HORA"];
	$servicioContratado["LUGAR"] = $_REQUEST["LUGAR"];
	$servicioContratado["DURACION"] = $_REQUEST["DURACION"];
	$servicioContratado["OBSERVACIONES"] = $_REQUEST["OBSERVACIONES"];
	$servicioContratado["DNI_CIF"] = $_REQUEST["DNI_CIF"];
	$servicioContratado["NUMEROFACTURA"] = $_REQUEST["NUMEROFACTURA"];
	$servicioContratado["NUMEROTRABAJADOR"] = $_REQUEST["NUMEROTRABAJADOR"];
	$servicioContratado["ID_T"] = $_REQUEST["ID_T"];
	$servicioContratado["COMPLETADO"] = $_REQUEST["COMPLETADO"];
	$servicioContratado["TIPOTRATAMIENTO"] = $_REQUEST["TIPOTRATAMIENTO"];
	$servicioContratado["TIPOMAQUINAS"] = $_REQUEST["TIPOMAQUINAS"];
	$servicioContratado["TIPOMATERIALES"] = $_REQUEST["TIPOMATERIALES"];
	$servicioContratado["TIPOSERVICIOS"] = $_REQUEST["TIPOSERVICIOS"];
	$servicioContratado["TIPOPLAGAS"] = $_REQUEST["TIPOPLAGAS"];

	$_SESSION["servicioContratado"] = $servicioContratado;

	if(isset($_REQUEST["NUEVO"])){Header("Location: ../Accion/accion_crear_servicio_contratado.php");}

}
else{

	Header("Location: ../Vista/servicionNoContratadosGerente.php");
	
}
?>