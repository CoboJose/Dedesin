<?php
function nuevo_servicio($conexion,$servicioContratado){

	$Fecha = date('d/m/Y', strtotime($servicioContratado["FECHA"]));

	try {
		$stmt=$conexion->prepare('CALL NUEVO_SERVICIOCONTRATADO(:FECHA, :HORA, :LUGAR, :DURACION, :OBSERVACIONES, :DNI_CIF,
		:NUMEROFACTURA, :NUMEROTRABAJADOR, :ID_T, :COMPLETADO, :TIPOTRATAMIENTO, :TIPOMAQUINAS, :TIPOMATERIALES,
		:TIPOSERVICIOS, :TIPOPLAGAS)');
		$stmt->bindParam(':FECHA',$Fecha);
		$stmt->bindParam(':HORA',$servicioContratado["HORA"]);
		$stmt->bindParam(':LUGAR',$servicioContratado["LUGAR"]);
		$stmt->bindParam(':DURACION',$servicioContratado["DURACION"]);
		$stmt->bindParam(':OBSERVACIONES',$servicioContratado["OBSERVACIONES"]);
		$stmt->bindParam(':DNI_CIF',$servicioContratado["DNI_CIF"]);
		$stmt->bindParam(':NUMEROFACTURA',$servicioContratado["NUMEROFACTURA"]);
		$stmt->bindParam(':NUMEROTRABAJADOR',$servicioContratado["NUMEROTRABAJADOR"]);
		$stmt->bindParam(':ID_T',$servicioContratado["ID_T"]);
		$stmt->bindParam(':COMPLETADO',$servicioContratado["COMPLETADO"]);
		$stmt->bindParam(':TIPOTRATAMIENTO',$servicioContratado["TIPOTRATAMIENTO"]);
		$stmt->bindParam(':TIPOMAQUINAS',$servicioContratado["TIPOMAQUINAS"]);
		$stmt->bindParam(':TIPOMATERIALES',$servicioContratado["TIPOMATERIALES"]);
		$stmt->bindParam(':TIPOSERVICIOS',$servicioContratado["TIPOSERVICIOS"]);
		$stmt->bindParam(':TIPOPLAGAS',$servicioContratado["TIPOPLAGAS"]);

		$stmt->execute();
		return "";

	} catch(PDOException $e) {
		return $e->getMessage();
    }
}
?>