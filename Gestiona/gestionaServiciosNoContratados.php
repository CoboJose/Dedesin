<?php

function consultaServiciosNoContratados($conexion){
try{
	$consulta = "SELECT * FROM SERVICIOSNOCONTRATADOS ORDER BY ID_SNC";
    $stmt = $conexion->query($consulta);
	return $stmt;
}catch(PDOException $e) {
		return $e->getMessage();
    }
}

function consultaServiciosNoContratadosClientes($conexion, $dni_cif){
try{
	$consulta = "SELECT * FROM SERVICIOSNOCONTRATADOS WHERE DNI_CIF=:dni_cif ORDER BY ID_SNC";
    $stmt = $conexion->prepare($consulta);
	$stmt->bindParam(':dni_cif',$dni_cif);
	$stmt->execute();
	return $stmt;
}catch(PDOException $e) {
		return $e->getMessage();
    }
}

function eliminarServiciosNoContratados($conexion,$id_snc){
	try {
		$consulta = "CALL BORRAR_SERVICIO_NO_CONTRATADO(:id_snc)";
		$stmt=$conexion->prepare($consulta);
		$stmt->bindParam(':id_snc',$id_snc);
		$stmt->execute();
		return "";

	} catch(PDOException $e) {
		return $e->getMessage();
    }
}


?>