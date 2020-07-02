<?php
  /*
     * #===========================================================#
     * #	Este fichero contiene las funciones de gestión
     * #	de usuarios de la capa de acceso a datos
     * #==========================================================#
     */

 function alta_usuario($conexion,$usuario) {

	try {
		$consulta = 'CALL NUEVO_CLIENTE(:DNI_CIF,:Contrasena,:Telefono,:Email,:TipoCliente, :Nombre, :FormaPago, :NumeroCuenta, :CancelacionesIndebidas)';
	
	
		$stmt=$conexion->prepare($consulta);
		$stmt->bindParam(':DNI_CIF',$usuario["DNI_CIF"]);
		$stmt->bindParam(':Contrasena',$usuario["Contrasena"]);
		$stmt->bindParam(':Telefono',$usuario["Telefono"]);
		$stmt->bindParam(':Email',$usuario["Email"]);
		$stmt->bindParam(':TipoCliente',$usuario["TipoCliente"]);
		$stmt->bindParam(':Nombre',$usuario["Nombre"]);
		$stmt->bindParam(':FormaPago',$usuario["FormaPago"]);
		$stmt->bindParam(':NumeroCuenta',$usuario["NumeroCuenta"]);
		$stmt->bindParam(':CancelacionesIndebidas',$usuario["CancelacionesIndebidas"]);
		
		
		
		$stmt->execute();
		return true;
	} 

		catch(PDOException $e) {
		return false;
		$_SESSION['error'] = $e;
	 $e->getMessage(); }
}

function modificar_usuario($conexion,$usuario) {

	try {
		$consulta = 'CALL MODIFICAR_CLIENTE(:DNI_CIF,:Contrasena,:Telefono,:Email,:TipoCliente, :Nombre, :FormaPago, :NumeroCuenta, :CancelacionesIndebidas)';
	
	
		$stmt=$conexion->prepare($consulta);
		$stmt->bindParam(':DNI_CIF',$usuario["DNI_CIF"]);
		$stmt->bindParam(':Contrasena',$usuario["Contrasena"]);
		$stmt->bindParam(':Telefono',$usuario["Telefono"]);
		$stmt->bindParam(':Email',$usuario["Email"]);
		$stmt->bindParam(':TipoCliente',$usuario["TipoCliente"]);
		$stmt->bindParam(':Nombre',$usuario["Nombre"]);
		$stmt->bindParam(':FormaPago',$usuario["FormaPago"]);
		$stmt->bindParam(':NumeroCuenta',$usuario["NumeroCuenta"]);
		$stmt->bindParam(':CancelacionesIndebidas',$usuario["CancelacionesIndebidas"]);
		
		
		
		$stmt->execute();
		return true;
	} 

		catch(PDOException $e) {
		return false;
		$_SESSION['error'] = $e;
	 $e->getMessage(); }
}

//CONSULTAS PARA HACER EL LOGIN Y SABER DE QUE TIPO ES EL USUARIO
  
function consultarCliente($conexion,$DNI_CIF,$Contrasena) {
 	$consulta = "SELECT COUNT(*) FROM Clientes WHERE DNI_CIF=:DNI_CIF AND Contrasena=:Contrasena";
	$stmt = $conexion->prepare($consulta);
	$stmt->bindParam(':DNI_CIF',$DNI_CIF);
	$stmt->bindParam(':Contrasena',$Contrasena);
	$stmt->execute();
	
 	return $stmt->fetchColumn();
}
function consultarTrabajador($conexion,$DNI,$Contrasena) {
 	$consulta = "SELECT COUNT(*) FROM Trabajadores WHERE DNI=:DNI AND Contrasena=:Contrasena";
	$stmt = $conexion->prepare($consulta);
	$stmt->bindParam(':DNI',$DNI);
	$stmt->bindParam(':Contrasena',$Contrasena);
	$stmt->execute();
	return $stmt->fetchColumn();
}
function consultarGerente($conexion,$DNI,$Contrasena) {
 	$consulta = "SELECT COUNT(*) FROM Gerentes WHERE DNI=:DNI AND Contrasena=:Contrasena";
	$stmt = $conexion->prepare($consulta);
	$stmt->bindParam(':DNI',$DNI);
	$stmt->bindParam(':Contrasena',$Contrasena);
	$stmt->execute();
	return $stmt->fetchColumn();
}
					//PROPIEDADES DE CLIENTES

function consultarNombreCliente($conexion,$DNI_CIF) {
 	$consulta = "SELECT Nombre FROM Clientes WHERE DNI_CIF=:DNI_CIF";
	$stmt = $conexion->prepare($consulta);
	$stmt->bindParam(':DNI_CIF',$DNI_CIF);
	$stmt->execute();
	return $stmt->fetchColumn();
}

function consultarTelefonoCliente($conexion,$DNI_CIF) {
 	$consulta = "SELECT Telefono FROM Clientes WHERE DNI_CIF=:DNI_CIF";
	$stmt = $conexion->prepare($consulta);
	$stmt->bindParam(':DNI_CIF',$DNI_CIF);
	$stmt->execute();
	return $stmt->fetchColumn();
}
function consultarEmailCliente($conexion,$DNI_CIF) {
 	$consulta = "SELECT Email FROM Clientes WHERE DNI_CIF=:DNI_CIF";
	$stmt = $conexion->prepare($consulta);
	$stmt->bindParam(':DNI_CIF',$DNI_CIF);
	$stmt->execute();
	return $stmt->fetchColumn();
}
function consultarNumeroCuentaCliente($conexion,$DNI_CIF) {
 	$consulta = "SELECT NumeroCuenta FROM Clientes WHERE DNI_CIF=:DNI_CIF";
	$stmt = $conexion->prepare($consulta);
	$stmt->bindParam(':DNI_CIF',$DNI_CIF);
	$stmt->execute();
	return $stmt->fetchColumn();
}
function consultarFormaPagoCliente($conexion,$DNI_CIF) {
 	$consulta = "SELECT FormaPago FROM Clientes WHERE DNI_CIF=:DNI_CIF";
	$stmt = $conexion->prepare($consulta);
	$stmt->bindParam(':DNI_CIF',$DNI_CIF);
	$stmt->execute();
	return $stmt->fetchColumn();
}
function consultarTipoClienteCliente($conexion,$DNI_CIF) {
 	$consulta = "SELECT TipoCliente FROM Clientes WHERE DNI_CIF=:DNI_CIF";
	$stmt = $conexion->prepare($consulta);
	$stmt->bindParam(':DNI_CIF',$DNI_CIF);
	$stmt->execute();
	return $stmt->fetchColumn();
}
function consultarContrasenaCliente($conexion,$DNI_CIF) {
 	$consulta = "SELECT Contrasena FROM Clientes WHERE DNI_CIF=:DNI_CIF";
	$stmt = $conexion->prepare($consulta);
	$stmt->bindParam(':DNI_CIF',$DNI_CIF);
	$stmt->execute();
	return $stmt->fetchColumn();
}
function consultarCancelacionesIndebidasCliente($conexion,$DNI_CIF) {
 	$consulta = "SELECT CancelacionesIndebidas FROM Clientes WHERE DNI_CIF=:DNI_CIF";
	$stmt = $conexion->prepare($consulta);
	$stmt->bindParam(':DNI_CIF',$DNI_CIF);
	$stmt->execute();
	return $stmt->fetchColumn();
}
//PROPIEDADES DE GERENTE
function consultarNombreGerente($conexion,$DNI_CIF) {
 	$consulta = "SELECT Nombre FROM Gerentes WHERE DNI=:DNI_CIF";
	$stmt = $conexion->prepare($consulta);
	$stmt->bindParam(':DNI_CIF',$DNI_CIF);
	$stmt->execute();
	return $stmt->fetchColumn();
}
function consultarContrasenaGerente($conexion,$DNI_CIF) {
 	$consulta = "SELECT Contrasena FROM Gerentes WHERE DNI=:DNI_CIF";
	$stmt = $conexion->prepare($consulta);
	$stmt->bindParam(':DNI_CIF',$DNI_CIF);
	$stmt->execute();
	return $stmt->fetchColumn();
}

function consultarTelefonoGerente($conexion,$DNI_CIF) {
 	$consulta = "SELECT NumeroTelefono FROM Gerentes WHERE DNI=:DNI_CIF";
	$stmt = $conexion->prepare($consulta);
	$stmt->bindParam(':DNI_CIF',$DNI_CIF);
	$stmt->execute();
	return $stmt->fetchColumn();
}
function consultarNumeroCuentaGerente($conexion,$DNI_CIF) {
 	$consulta = "SELECT NumeroCuenta FROM Gerentes WHERE DNI=:DNI_CIF";
	$stmt = $conexion->prepare($consulta);
	$stmt->bindParam(':DNI_CIF',$DNI_CIF);
	$stmt->execute();
	return $stmt->fetchColumn();
}
function consultarEmailGerente($conexion,$DNI_CIF) {
 	$consulta = "SELECT CorreoElectronico FROM Gerentes WHERE DNI=:DNI_CIF";
	$stmt = $conexion->prepare($consulta);
	$stmt->bindParam(':DNI_CIF',$DNI_CIF);
	$stmt->execute();
	return $stmt->fetchColumn();
}
//PROPIEDADES TRABAJADOR
function consultarNombreTrabajador($conexion,$DNI_CIF) {
 	$consulta = "SELECT Nombre FROM Trabajadores WHERE DNI=:DNI_CIF";
	$stmt = $conexion->prepare($consulta);
	$stmt->bindParam(':DNI_CIF',$DNI_CIF);
	$stmt->execute();
	return $stmt->fetchColumn();
}
function consultarTelefonoTrabajador($conexion,$DNI_CIF) {
 	$consulta = "SELECT NumTlf FROM Trabajadores WHERE DNI=:DNI_CIF";
	$stmt = $conexion->prepare($consulta);
	$stmt->bindParam(':DNI_CIF',$DNI_CIF);
	$stmt->execute();
	return $stmt->fetchColumn();
}
function consultarDireccionTrabajador($conexion,$DNI_CIF) {
 	$consulta = "SELECT Direccion FROM Trabajadores WHERE DNI=:DNI_CIF";
	$stmt = $conexion->prepare($consulta);
	$stmt->bindParam(':DNI_CIF',$DNI_CIF);
	$stmt->execute();
	return $stmt->fetchColumn();
}
function consultarHorasSemanalesTrabajador($conexion,$DNI_CIF) {
 	$consulta = "SELECT HorasSemanales FROM Trabajadores WHERE DNI=:DNI_CIF";
	$stmt = $conexion->prepare($consulta);
	$stmt->bindParam(':DNI_CIF',$DNI_CIF);
	$stmt->execute();
	return $stmt->fetchColumn();
}
function consultarHorasMensualesTrabajador($conexion,$DNI_CIF) {
 	$consulta = "SELECT HorasMensuales FROM Trabajadores WHERE DNI=:DNI_CIF";
	$stmt = $conexion->prepare($consulta);
	$stmt->bindParam(':DNI_CIF',$DNI_CIF);
	$stmt->execute();
	return $stmt->fetchColumn();
}

function consultarHorasExtrasTrabajador($conexion,$DNI_CIF) {
 	$consulta = "SELECT HorasExtras FROM Trabajadores WHERE DNI=:DNI_CIF";
	$stmt = $conexion->prepare($consulta);
	$stmt->bindParam(':DNI_CIF',$DNI_CIF);
	$stmt->execute();
	return $stmt->fetchColumn();
}

function consultarCuentaTrabajador($conexion,$DNI_CIF) {
 	$consulta = "SELECT NumCuentaCorriente FROM Trabajadores WHERE DNI=:DNI_CIF";
	$stmt = $conexion->prepare($consulta);
	$stmt->bindParam(':DNI_CIF',$DNI_CIF);
	$stmt->execute();
	return $stmt->fetchColumn();
}

function consultarSeguridadSocialTrabajador($conexion,$DNI_CIF) {
 	$consulta = "SELECT NumSeguridadSocial FROM Trabajadores WHERE DNI=:DNI_CIF";
	$stmt = $conexion->prepare($consulta);
	$stmt->bindParam(':DNI_CIF',$DNI_CIF);
	$stmt->execute();
	return $stmt->fetchColumn();
}
function consultarFormacionTrabajador($conexion,$DNI_CIF) {
 	$consulta = "SELECT Formacion FROM Trabajadores WHERE DNI=:DNI_CIF";
	$stmt = $conexion->prepare($consulta);
	$stmt->bindParam(':DNI_CIF',$DNI_CIF);
	$stmt->execute();
	return $stmt->fetchColumn();
}
function consultarMatriculaTrabajador($conexion,$DNI_CIF) {
 	$consulta = "SELECT Matricula FROM Trabajadores WHERE DNI=:DNI_CIF";
	$stmt = $conexion->prepare($consulta);
	$stmt->bindParam(':DNI_CIF',$DNI_CIF);
	$stmt->execute();
	return $stmt->fetchColumn();
}





