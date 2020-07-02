<?php
session_start();

if(isset($_REQUEST["Matricula"])){

	$vehicMod["Matricula"] = $_REQUEST["Matricula"];
	$vehicMod["Modelo"] = $_REQUEST["Modelo"];
	$vehicMod["KmTotales"] = $_REQUEST["KmTotales"];
	$vehicMod["NumBastidor"] = $_REQUEST["NumBastidor"];
	$vehicMod["ITV"] = $_REQUEST["ITV"];
	$vehicMod["Seguro"] = $_REQUEST["Seguro"];
	$vehicMod["Trabajador"] = $_REQUEST["Trabajador"];
	$vehicMod["NumTrabajador"] = $_REQUEST["NumTrabajador"];

	$_SESSION["vehicMod"] = $vehicMod;

	if(isset($_REQUEST["editar"])) 		Header("Location: ../Vista/vehiculosGerente.php");
	else if(isset($_REQUEST["grabar"])) Header("Location: ../Accion/accion_modificar_vehiculo.php");
	else 								Header("Location: ../Accion/accion_borrar_vehiculo.php");

}
else{

	if (isset($_REQUEST["vehicNuevo"])) {
		
		$_SESSION["vehicNuevo"] = true;
		Header("Location: ../Vista/vehiculosGerente.php");
	}
	else{
		Header("Location: ../Vista/vehiculosGerente.php");
	}
	
}

?>