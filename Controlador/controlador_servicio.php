<?php
session_start();

if(isset($_REQUEST["id_snc"])){

	$servNC["ID_SNC"] = $_REQUEST["id_snc"];
	$servNC["FECHA"] = $_REQUEST["fecha"];
	$servNC["HORA"] = $_REQUEST["hora"];
	$servNC["DURACION"] = $_REQUEST["duracion"];
	$servNC["OBSERVACIONES"] = $_REQUEST["observaciones"];
	$servNC["DNI_CIF"] = $_REQUEST["dni_cif"];
	$servNC["TIPOTRATAMIENTO"] = $_REQUEST["tipoTratamiento"];
	$servNC["TIPOMAQUINAS"] = $_REQUEST["tipoMaquinas"];
	$servNC["TIPOMATERIALES"] = $_REQUEST["tipoMateriales"];
	$servNC["TIPOSERVICIOS"] = $_REQUEST["tipoServicios"];
	$servNC["TIPOPLAGAS"] = $_REQUEST["tipoPlagas"];

	$_SESSION["servNC"] = $servNC;

	Header("Location: ../Vista/ContratacionParaGerente.php");

}
else{

	Header("Location: ../Vista/servicionNoContratadosGerente.php");
	
}

?>