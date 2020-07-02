<?php

//Gerente:
function modificar_servicio_gerente($conexion,$servMod){

	$FECHA = date('d/m/Y', strtotime($servMod["FECHA"]));

	try{
		$stmt = $conexion -> prepare('CALL MODIFICAR_SERVICIO_GERENTE(:ID_SC,:FECHA,:HORA,:LUGAR,:DURACION,:NUMEROTRABAJADOR,:OBSERVACIONES,:COMPLETADO,
									 :TIPOTRATAMIENTO,:TIPOMAQUINAS,:TIPOMATERIALES,:TIPOSERVICIOS,:TIPOPLAGAS)');

		$stmt -> bindParam(':ID_SC',$servMod['ID_SC']);
		$stmt -> bindParam(':FECHA',$FECHA);
		$stmt -> bindParam(':HORA',$servMod['HORA']);
		$stmt -> bindParam(':LUGAR',$servMod['LUGAR']);
		$stmt -> bindParam(':DURACION',$servMod['DURACION']);
		$stmt -> bindParam(':NUMEROTRABAJADOR',$servMod['NUMEROTRABAJADOR']);
		$stmt -> bindParam(':OBSERVACIONES',$servMod['OBSERVACIONES']);
		$stmt -> bindParam(':COMPLETADO',$servMod['COMPLETADO']);
		$stmt -> bindParam(':TIPOTRATAMIENTO',$servMod['TIPOTRATAMIENTO']);
		$stmt -> bindParam(':TIPOMAQUINAS',$servMod['TIPOMAQUINAS']);
		$stmt -> bindParam(':TIPOMATERIALES',$servMod['TIPOMATERIALES']);
		$stmt -> bindParam(':TIPOSERVICIOS',$servMod['TIPOSERVICIOS']);
		$stmt -> bindParam(':TIPOPLAGAS',$servMod['TIPOPLAGAS']);
		$stmt -> execute();
		return "";

	} catch(PDOException $e){
		return $e -> getMessage();
	}
}

function borrar_servicio($conexion,$ID_SC){

	try {
		$stmt=$conexion->prepare('CALL BORRAR_SERVICIO(:ID_SC)');
		$stmt->bindParam(':ID_SC',$ID_SC);
		$stmt->execute();
		return "";

	} catch(PDOException $e) {
		return $e->getMessage();
    }
}

function consultarTrabajadorServicio($conexion,$NUMEROTRABAJADOR){

	$consulta = "SELECT NOMBRE FROM TRABAJADORES WHERE NUMEROTRABAJADOR = :NUMEROTRABAJADOR";
	$stmt = $conexion->prepare($consulta);
	$stmt -> bindParam(':NUMEROTRABAJADOR',$NUMEROTRABAJADOR);
	$stmt -> execute();
	return $stmt -> fetch();
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

//Trabajador
function consultaTrabajadorConDNI($conexion,$DNI){
	$consulta = "SELECT NUMEROTRABAJADOR FROM TRABAJADORES WHERE DNI = :DNI";
	$stmt = $conexion->prepare($consulta);
	$stmt -> bindParam(':DNI',$DNI);
	$stmt -> execute();
	return $stmt -> fetch();
}

function consultarServiciosTrabajadorFechaDesc($conexion,$numTrabajador){

	
	$consulta = "SELECT SERVICIOSCONTRATADOS.*,CLIENTES.NOMBRE 
				 FROM SERVICIOSCONTRATADOS,CLIENTES 
				 WHERE SERVICIOSCONTRATADOS.DNI_CIF = CLIENTES.DNI_CIF
				 AND SERVICIOSCONTRATADOS.NUMEROTRABAJADOR = :numTrabajador
				 ORDER BY SERVICIOSCONTRATADOS.FECHA DESC" ;
	$stmt = $conexion->prepare($consulta);
	$stmt -> bindParam(':numTrabajador',$numTrabajador);
	$stmt -> execute();
	return $stmt;
}
function consultarServiciosTrabajadorFechaAsc($conexion,$numTrabajador){

	
	$consulta = "SELECT SERVICIOSCONTRATADOS.*,CLIENTES.NOMBRE 
				 FROM SERVICIOSCONTRATADOS,CLIENTES 
				 WHERE SERVICIOSCONTRATADOS.DNI_CIF = CLIENTES.DNI_CIF
				 AND SERVICIOSCONTRATADOS.NUMEROTRABAJADOR = :numTrabajador
				 ORDER BY SERVICIOSCONTRATADOS.FECHA ASC" ;
	$stmt = $conexion->prepare($consulta);
	$stmt -> bindParam(':numTrabajador',$numTrabajador);
	$stmt -> execute();
	return $stmt;
}
function consultarServiciosTrabajadorDurDesc($conexion,$numTrabajador){

	
	$consulta = "SELECT SERVICIOSCONTRATADOS.*,CLIENTES.NOMBRE 
				 FROM SERVICIOSCONTRATADOS,CLIENTES 
				 WHERE SERVICIOSCONTRATADOS.DNI_CIF = CLIENTES.DNI_CIF
				 AND SERVICIOSCONTRATADOS.NUMEROTRABAJADOR = :numTrabajador
				 ORDER BY DURACION DESC" ;
	$stmt = $conexion->prepare($consulta);
	$stmt -> bindParam(':numTrabajador',$numTrabajador);
	$stmt -> execute();
	return $stmt;
}
function consultarServiciosTrabajadorDurAsc($conexion,$numTrabajador){

	
	$consulta = "SELECT SERVICIOSCONTRATADOS.*,CLIENTES.NOMBRE 
				 FROM SERVICIOSCONTRATADOS,CLIENTES 
				 WHERE SERVICIOSCONTRATADOS.DNI_CIF = CLIENTES.DNI_CIF
				 AND SERVICIOSCONTRATADOS.NUMEROTRABAJADOR = :numTrabajador
				 ORDER BY DURACION ASC" ;
	$stmt = $conexion->prepare($consulta);
	$stmt -> bindParam(':numTrabajador',$numTrabajador);
	$stmt -> execute();
	return $stmt;
}
function consultarServiciosTrabajadorBuscarFecha($conexion,$numTrabajador,$fechaOld){

	$fecha = date('d/m/Y', strtotime($fechaOld));

	$consulta = "SELECT SERVICIOSCONTRATADOS.*,CLIENTES.NOMBRE 
				 FROM SERVICIOSCONTRATADOS,CLIENTES 
				 WHERE SERVICIOSCONTRATADOS.DNI_CIF = CLIENTES.DNI_CIF
				 AND SERVICIOSCONTRATADOS.NUMEROTRABAJADOR = :numTrabajador
				 AND SERVICIOSCONTRATADOS.FECHA = :fecha" ;
	$stmt = $conexion->prepare($consulta);
	$stmt -> bindParam(':numTrabajador',$numTrabajador);
	$stmt -> bindParam(':fecha',$fecha);
	$stmt -> execute();
	return $stmt;
}

function modificar_servicio_trabajador($conexion,$servMod){

	try{
		$stmt = $conexion -> prepare('CALL MODIFICAR_SERVICIO_TRABAJADOR(:ID_SC,:OBSERVACIONES,:COMPLETADO)');
		$stmt -> bindParam(':ID_SC',$servMod['ID_SC']);
		$stmt -> bindParam(':OBSERVACIONES',$servMod['OBSERVACIONES']);
		$stmt -> bindParam(':COMPLETADO',$servMod['COMPLETADO']);
		$stmt -> execute();
		return "";

	} catch(PDOException $e){
		return $e -> getMessage();
	}
}

//Ambos

function consultarTratamientos($conexion,$ID_T){

	$consulta = "SELECT * FROM TRATAMIENTOS 
				 WHERE ID_T = :ID_T";
	$stmt = $conexion->prepare($consulta);
	$stmt -> bindParam(':ID_T',$ID_T);
	$stmt -> execute();
	return $stmt -> fetch();
}

?>