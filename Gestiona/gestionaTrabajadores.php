<?php
function consultaTrabajadores($conexion){
	
$consulta = "SELECT * FROM Trabajadores";
return $conexion->query($consulta);
}

function consultaTrabajadorNum($conexion,$num){
$consulta = "SELECT nombre FROM Trabajadores where NumeroTrabajador = :numTrab";
$stmt = $conexion->prepare($consulta);
$stmt -> bindParam(':numTrab',$num);
$stmt -> execute();
return $stmt -> fetchAll();
}

function listarTrabajadores($conexion){

	try{
		$consulta = "SELECT NUMEROTRABAJADOR,NOMBRE FROM TRABAJADORES ORDER BY NUMEROTRABAJADOR";
    	$stmt = $conexion->query($consulta);
		return $stmt;
	}catch(PDOException $e) {
		return $e->getMessage();
    }
}
?>