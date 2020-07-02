<?php
// Grente
function consultarFacturasFecha($conexion){

	$consulta = "SELECT FACTURAS.*, SERVICIOSCONTRATADOS.ID_SC, SERVICIOSCONTRATADOS.DNI_CIF
				 FROM FACTURAS,SERVICIOSCONTRATADOS 
				 WHERE SERVICIOSCONTRATADOS.NUMEROFACTURA = FACTURAS.NUMEROFACTURA
				 ORDER BY FACTURAS.FECHA DESC" ;
	$stmt = $conexion->prepare($consulta);
	$stmt -> execute();
	return $stmt;
}

function consultarFacturasPagado($conexion){

	$consulta = "SELECT FACTURAS.*, SERVICIOSCONTRATADOS.ID_SC, SERVICIOSCONTRATADOS.DNI_CIF
				 FROM FACTURAS,SERVICIOSCONTRATADOS 
				 WHERE SERVICIOSCONTRATADOS.NUMEROFACTURA = FACTURAS.NUMEROFACTURA
				 ORDER BY FACTURAS.PAGO ASC" ;
	$stmt = $conexion->prepare($consulta);
	$stmt -> execute();
	return $stmt;
}

function consultarFacturasFechaCliente($conexion,$buscaCliente){

	$consulta = "SELECT FACTURAS.*, SERVICIOSCONTRATADOS.ID_SC, SERVICIOSCONTRATADOS.DNI_CIF
				 FROM FACTURAS,SERVICIOSCONTRATADOS 
				 WHERE SERVICIOSCONTRATADOS.NUMEROFACTURA = FACTURAS.NUMEROFACTURA
				 AND SERVICIOSCONTRATADOS.DNI_CIF = :buscaCliente
				 ORDER BY FACTURAS.FECHA DESC" ;
	$stmt = $conexion->prepare($consulta);
	$stmt -> bindParam(':buscaCliente',$buscaCliente);
	$stmt -> execute();
	return $stmt;
}

function modificar_factura($conexion,$factMod){

	$FECHA = date('d/m/Y', strtotime($factMod["FECHA"]));
	$FECHAPAGO = date('d/m/Y', strtotime($factMod["FECHAPAGO"]));
	$FECHARECEPCION = date('d/m/Y', strtotime($factMod["FECHARECEPCION"]));

	try{
		$stmt = $conexion -> prepare('CALL MODIFICAR_FACTURA(:NUMEROFACTURA,:FECHA,:SERIE,:CONCEPTO,:TIPOIMPOSITIVO,:IVA,
									 :TOTAL,:FECHAPAGO,:IMPORTE,:FORMAPAGO,:STATUS,:PAGO,:RECEPCION,:PERSONARECEPCION,
									 :FECHARECEPCION,:OBSERVACIONES)');

		$stmt -> bindParam(':NUMEROFACTURA',$factMod['NUMEROFACTURA']);
		$stmt -> bindParam(':FECHA',$FECHA);
		$stmt -> bindParam(':SERIE',$factMod['SERIE']);
		$stmt -> bindParam(':CONCEPTO',$factMod['CONCEPTO']);
		$stmt -> bindParam(':TIPOIMPOSITIVO',$factMod['TIPOIMPOSITIVO']);
		$stmt -> bindParam(':IVA',$factMod['IVA']);
		$stmt -> bindParam(':TOTAL',$factMod['TOTAL']);
		$stmt -> bindParam(':FECHAPAGO',$FECHAPAGO);
		$stmt -> bindParam(':IMPORTE',$factMod['IMPORTE']);
		$stmt -> bindParam(':FORMAPAGO',$factMod['FORMAPAGO']);
		$stmt -> bindParam(':STATUS',$factMod['STATUS']);
		$stmt -> bindParam(':PAGO',$factMod['PAGO']);
		$stmt -> bindParam(':RECEPCION',$factMod['RECEPCION']);
		$stmt -> bindParam(':PERSONARECEPCION',$factMod['PERSONARECEPCION']);
		$stmt -> bindParam(':FECHARECEPCION',$FECHARECEPCION);
		$stmt -> bindParam(':OBSERVACIONES',$factMod['OBSERVACIONES']);
		$stmt -> execute();
		return "";

	} catch(PDOException $e){
		return $e -> getMessage();
	}
}

function borrar_factura($conexion,$NUMEROFACTURA){

	try {
		$stmt=$conexion->prepare('CALL BORRAR_FACTURA(:NUMEROFACTURA)');
		$stmt->bindParam(':NUMEROFACTURA',$NUMEROFACTURA);
		$stmt->execute();
		return "";

	} catch(PDOException $e) {
		return $e->getMessage();
    }
}
// Cliente
function consultarTodasFacturasClienteFecha($conexion,$DNI_CIF){

	$consulta = "SELECT FACTURAS.FECHA,FACTURAS.CONCEPTO,FACTURAS.IMPORTE,FACTURAS.STATUS,FACTURAS.NUMEROFACTURA, SERVICIOSCONTRATADOS.ID_SC
				 FROM FACTURAS,SERVICIOSCONTRATADOS 
				 WHERE SERVICIOSCONTRATADOS.NUMEROFACTURA = FACTURAS.NUMEROFACTURA 
				 AND SERVICIOSCONTRATADOS.DNI_CIF = :DNI_CIF 
				 ORDER BY FECHA DESC" ;
	$stmt = $conexion->prepare($consulta);
	$stmt -> bindParam(':DNI_CIF',$DNI_CIF);
	$stmt -> execute();
	return $stmt;
}

function consultarTodasFacturasClienteImporte($conexion,$DNI_CIF){

	$consulta = "SELECT FACTURAS.FECHA,FACTURAS.CONCEPTO,FACTURAS.IMPORTE,FACTURAS.STATUS,FACTURAS.NUMEROFACTURA, SERVICIOSCONTRATADOS.ID_SC
				 FROM FACTURAS,SERVICIOSCONTRATADOS 
				 WHERE SERVICIOSCONTRATADOS.NUMEROFACTURA = FACTURAS.NUMEROFACTURA 
				 AND SERVICIOSCONTRATADOS.DNI_CIF = :DNI_CIF 
				 ORDER BY IMPORTE DESC" ;
	$stmt = $conexion->prepare($consulta);
	$stmt -> bindParam(':DNI_CIF',$DNI_CIF);
	$stmt -> execute();
	return $stmt;
}

// Ambos
function consultarFacturaEspecifica($conexion,$numeroFactura){

	$consulta = "SELECT FACTURAS.*, SERVICIOSCONTRATADOS.ID_SC, SERVICIOSCONTRATADOS.DNI_CIF
				 FROM FACTURAS,SERVICIOSCONTRATADOS 
				 WHERE SERVICIOSCONTRATADOS.NUMEROFACTURA = FACTURAS.NUMEROFACTURA 
				 AND FACTURAS.NUMEROFACTURA = :nf";
	$stmt = $conexion->prepare($consulta);
	$stmt -> bindParam(':nf',$numeroFactura);
	$stmt -> execute();
	return $stmt -> fetch();
}

?>