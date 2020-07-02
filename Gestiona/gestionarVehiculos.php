<?php

function consultaTrabajadorConDNI($conexion,$DNI){
	$consulta = "SELECT NUMEROTRABAJADOR FROM TRABAJADORES WHERE DNI = :DNI";
	$stmt = $conexion->prepare($consulta);
	$stmt -> bindParam(':DNI',$DNI);
	$stmt -> execute();
	return $stmt -> fetch();
}

function consultarVehiculosTrabajador($conexion,$OidTrabajador) {
		
    $consulta = "SELECT * FROM Vehiculos WHERE Matricula = (SELECT matricula FROM vehiculos NATURAL JOIN trabajadores where trabajadores.NUMEROTRABAJADOR=:OidTrabajador)";
	$stmt = $conexion->prepare($consulta);
	$stmt -> bindParam(':OidTrabajador',$OidTrabajador);
	$stmt -> execute();
	return $stmt;
}

function consultarVehiculosGerente($conexion){

	$consulta = "SELECT * FROM Vehiculos";
    return $conexion->query($consulta);
}
    
function consultarTrabajadorVehiculo($conexion,$Matricula){

	$consulta = "SELECT * FROM TRABAJADORES WHERE MATRICULA = :Matricula";
	$stmt = $conexion->prepare($consulta);
	$stmt -> bindParam(':Matricula',$Matricula);
	$stmt -> execute();
	return $stmt -> fetch();
}

function modificar_vehiculo($conexion,$vehicMod){

	$ITV = date('d/m/Y', strtotime($vehicMod["ITV"]));
	$Seguro = date('d/m/Y', strtotime($vehicMod["Seguro"]));

	try{
		$stmt = $conexion -> prepare('CALL MODIFICAR_VEHICULO(:Matricula,:Kmtotales,:ITV,:Seguro,:NumTrabajador)');
		$stmt -> bindParam(':Matricula',$vehicMod['Matricula']);
		$stmt -> bindParam(':Kmtotales',$vehicMod['KmTotales']);
		$stmt -> bindParam(':ITV',$ITV);
		$stmt -> bindParam(':Seguro',$Seguro);
		$stmt -> bindParam(':NumTrabajador',$vehicMod['NumTrabajador']);
		$stmt -> execute();
		return "";

	} catch(PDOException $e){
		return $e -> getMessage();
	}
}

function borrar_vehiculo($conexion,$Matricula){

	try {
		$stmt=$conexion->prepare('CALL BORRAR_VEHICULO(:Matricula)');
		$stmt->bindParam(':Matricula',$Matricula);
		$stmt->execute();
		return "";

	} catch(PDOException $e) {
		return $e->getMessage();
    }
}

function nuevo_vehiculo($conexion,$nuevoVehiculo){

	$ITV = date('d/m/Y', strtotime($nuevoVehiculo["ITV"]));
	$Seguro = date('d/m/Y', strtotime($nuevoVehiculo["Seguro"]));

	try {
		$stmt=$conexion->prepare('CALL NUEVO_VEHICULO(:Matricula,:Modelo,:KmTotales,:NumBastidor,:ITV,:Seguro,:NumTrabajador)');
		$stmt->bindParam(':Matricula',$nuevoVehiculo["Matricula"]);
		$stmt->bindParam(':Modelo',$nuevoVehiculo["Modelo"]);
		$stmt->bindParam(':KmTotales',$nuevoVehiculo["KmTotales"]);
		$stmt->bindParam(':NumBastidor',$nuevoVehiculo["NumBastidor"]);
		$stmt->bindParam(':ITV',$ITV);
		$stmt->bindParam(':Seguro',$Seguro);
		$stmt->bindParam(':NumTrabajador',$nuevoVehiculo["NumTrabajador"]);

		$stmt->execute();
		return "";

	} catch(PDOException $e) {
		return $e->getMessage();
    }
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