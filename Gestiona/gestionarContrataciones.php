<?php
     
function consultarTodosContrataciones($conexion) {
	$consulta = "SELECT * FROM ID_SC, FECHA, LUGAR, DURACION, ID_TSER, OBSERVACIONES, DNI_CIF,
	NUMEROFACTURA, NUMEROTRABAJADOR, ID_T"
		. " ORDER BY FECHA, DNI_CIF";
    return $conexion->query($consulta);
}
  
function quitar_contratacion($conexion,$ID_SC) {
	try {
		$stmt=$conexion->prepare('CALL QUITAR_CONTRATACION(:ID_SC)');
		$stmt->bindParam(':ID_SC',$ID_SC);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}

function modificar_parametros($conexion,$contratMod ) {
	try {
		$stmt=$conexion->prepare('CALL MODIFICAR_PARAMETROS(:ID_SC,:FECHA,:LUGAR,:DURACION,:ID_TSER,:OBSERVACIONES,
		:DNI_CIF,:NUMEROFACUTA,:NUMEROTRABAJADOR,:ID_T)');
		$stmt->bindParam(':ID_SC',$contratMod['ID_SC']);
		$stmt->bindParam(':FECHA',$contratMod['FECHA']);
		$stmt->bindParam(':LUGAR',$contratMod['LUGAR']);
		$stmt->bindParam(':DURACION',$contratMod['DURACION']);
		$stmt->bindParam(':ID_TSER',$contratMod['ID_TSER']);
		$stmt->bindParam(':OBSERVACIONES',$contratMod['OBSERVACIONES']);
		$stmt->bindParam(':DNI_CIF',$contratMod['DNI_CIF']);
		$stmt->bindParam(':NUMEROFACTURA',$contratMod['NUMEROFACTURA']);
		$stmt->bindParam(':NUMEROTRABAJADOR',$contratMod['NUMEROTRABAJADOR']);
		$stmt->bindParam(':ID_T',$contratMod['ID_T']);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}
function consultarContratacionesCliente($conexion,$OidCliente) {
		
    $consulta = "SELECT * FROM ServiciosContratados WHERE DNI_CIF = 
    (SELECT DNI_CIF FROM clientes where clientes.DNI_CIF=:OidCliente)";
	$stmt = $conexion->prepare($consulta);
	$stmt -> bindParam(':OidCliente',$OidCliente);
	$stmt -> execute();
	return $stmt;
}
	
?>