<?php
function listarTratamientos($conexion){

	try{
		$consulta = "SELECT ID_T,PELIGRO FROM TRATAMIENTOS ORDER BY ID_T";
    	$stmt = $conexion->query($consulta);
		return $stmt;
	}catch(PDOException $e) {
		return $e->getMessage();
    }
}
?>