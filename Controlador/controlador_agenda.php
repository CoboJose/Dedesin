<?php

session_start();

require_once("../Gestiona/gestionBD.php");

// Si venimos desde Agenda Gerente
if (isset($_REQUEST["ServModGerent"])) {
	
	$servMod["ID_SC"] = $_REQUEST["ID_SC"];
	$servMod["NOMBRE"] = $_REQUEST["NOMBRE"];
	$servMod["FECHA"] = $_REQUEST["FECHA"];
	$servMod["HORA"] = $_REQUEST["HORA"];
	$servMod["LUGAR"] = $_REQUEST["LUGAR"];
	$servMod["DURACION"] = $_REQUEST["DURACION"];
	$servMod["NUMEROTRABAJADOR"] = $_REQUEST["NUMEROTRABAJADOR"];
	$servMod["OBSERVACIONES"] = $_REQUEST["OBSERVACIONES"];
	$servMod["COMPLETADO"] = $_REQUEST["COMPLETADO"];
	$servMod["TIPOTRATAMIENTO"] = $_REQUEST["TIPOTRATAMIENTO"];
	$servMod["TIPOMAQUINAS"] = $_REQUEST["TIPOMAQUINAS"];
	$servMod["TIPOMATERIALES"] = $_REQUEST["TIPOMATERIALES"];
	$servMod["TIPOSERVICIOS"] = $_REQUEST["TIPOSERVICIOS"];
	$servMod["TIPOPLAGAS"] = $_REQUEST["TIPOPLAGAS"];

	$_SESSION["ServModGerent"] = $servMod;
	
	if(isset($_REQUEST["editar"])) 		Header("Location: ../Vista/agendaGerente.php");
	elseif(isset($_REQUEST["grabar"]))  Header("Location: ../Accion/accion_modificar_servicio.php");
	else                           		Header("Location: ../Accion/accion_borrar_servicio.php");
}
// Si venimos desde Agenda Trabajador
elseif(isset($_REQUEST["ServModTrab"])){

	$servMod["ID_SC"] = $_REQUEST["ID_SC"];
	$servMod["OBSERVACIONES"] = $_REQUEST["OBSERVACIONES"];
	$servMod["COMPLETADO"] = $_REQUEST["COMPLETADO"];

	$_SESSION["ServModTrab"] = $servMod;
	
	Header("Location: ../Accion/accion_modificar_servicio.php");
}
// Si no deberíamos estar aquí
else{
	Header("Location: ../Vista/error.php");
}


?>