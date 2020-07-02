<?php
     
function consultarTodosSNC($conexion) {
	$consulta = "SELECT * FROM ID_SD, FECHA, TIPOSERVICIO, DURACION,OBSERVACIONES, AÑO, ID_SC"
		. " ORDER BY FECHA";
    return $conexion->query($consulta);
}
  
function quitar_SNC($conexion,$ID_SD) {
	try {
		$stmt=$conexion->prepare('CALL QUITAR_SNC(:ID_SD)');
		$stmt->bindParam(':ID_SD',$ID_SD);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}

function modificar_parametros($conexion,$sncontratMod ) {
	try {
		$stmt=$conexion->prepare('CALL MODIFICAR_PARAMETROS(:ID_SD,:FECHA,:TIPOSERVICIO,:DURACION,:OBSERVACIONES,
		:AÑO,:ID_SC)');
		$stmt->bindParam(':ID_SD',$sncontratMod['ID_SD']);
		$stmt->bindParam(':FECHA',$sncontratMod['FECHA']);
		$stmt->bindParam(':DURACION',$sncontratMod['DURACION']);
		$stmt->bindParam(':TIPOSERVICIO',$sncontratMod['TIPOSERVICIO']);
		$stmt->bindParam(':OBSERVACIONES',$sncontratMod['OBSERVACIONES']);
		$stmt->bindParam(':AÑO',$sncontratMod['AÑO']);
		$stmt->bindParam(':ID_SC',$sncontratMod['ID_SC']);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}
function nuevo_SNC($conexion,$nuevoSNC){

	$FECHA = date('d/m/Y', strtotime($nuevoSNC["FECHA"]));
	

	try {
		$stmt=$conexion->prepare('CALL NUEVO_SNC(:FECHA,:HORA,:DURACION,:OBSERVACIONES,:DNI_CIF,:TIPOTRATAMIENTO,
		:TIPOMAQUINAS,:TIPOMATERIALES,:TIPOSERVICIOS,:TIPOPLAGAS)');
		$stmt->bindParam(':FECHA',$FECHA);
		$stmt->bindParam(':HORA',$nuevoSNC["HORA"]);
		$stmt->bindParam(':DURACION',$nuevoSNC["DURACION"]);
		$stmt->bindParam(':OBSERVACIONES',$nuevoSNC["OBSERVACIONES"]);
		$stmt->bindParam(':DNI_CIF',$nuevoSNC["DNI_CIF"]);
		$stmt->bindParam(':TIPOTRATAMIENTO',$nuevoSNC["TIPOTRATAMIENTO"]);
		$stmt->bindParam(':TIPOMAQUINAS',$nuevoSNC["TIPOMAQUINAS"]);
		$stmt->bindParam(':TIPOMATERIALES',$nuevoSNC["TIPOMATERIALES"]);
		$stmt->bindParam(':TIPOSERVICIOS',$nuevoSNC["TIPOSERVICIOS"]);
		$stmt->bindParam(':TIPOPLAGAS',$nuevoSNC["TIPOPLAGAS"]);

		$stmt->execute();
		return "";

	} catch(PDOException $e) {
		return $e->getMessage();
    }
}

	
?>