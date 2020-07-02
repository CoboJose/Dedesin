<?php
  /*
     * #===========================================================#
     * #	Este fichero contiene las funciones de gestión
     * #	de usuarios de la capa de acceso a datos
     * #==========================================================#
     */

 function alta_usuario($conexion,$usuario) {
	// BUSCA LA OPERACIÓN ALMACENADA "INSERTAR_USUARIO" EN SQL
	// 			PARA SABER CUÁLES SON SUS PARÁMETROS.
	// RECUERDA QUE SE INVOCA MEDIANTE 'CALL' EN PL/SQL
	// RECUERDA QUE EL FORMATO DE FECHA PARA ORACLE ES "d/m/Y"
	// UTILIZA EL MÉTODO "PREPARE" DEL OBJETO PDO
	// RECUERDA EL TRY/CATCH
	$fechaNacimiento = date('d/m/Y', strtotime($usuario["fechaNacimiento"]));
	
	try {
		$consulta = "CALL INSERTAR_USUARIO(:nif, :nombre, :ape, :fec, :email, :pass, :perfil)";
//		$consulta = "CALL INSERTAR_USUARIO(:nif, :nombre, :ape, NULL, :email, :pass, :perfil)"; Poner así si la fecha da problemas
		$stmt=$conexion->prepare($consulta);
		$stmt->bindParam(':nif',$usuario["nif"]);
		$stmt->bindParam(':nombre',$usuario["nombre"]);
		$stmt->bindParam(':ape',$usuario["apellidos"]);
		$stmt->bindParam(':fec',$fechaNacimiento);
		$stmt->bindParam(':email',$usuario["email"]);
		$stmt->bindParam(':pass',$usuario["pass"]);
		$stmt->bindParam(':perfil',$usuario["perfil"]);
		$stmt->execute();
		return true;
	} catch(PDOException $e) {
		return false;
		// Si queremos visualizar la excepción durante la depuración:;
		// $_SESSION['excepcion'] = $e->GetMessage();
		// header("Location: excepcion.php");
	}
}

// ESTA FUNCIÓN SE EDITA EN LA SEGUNDA PARTE DE LA PRÁCTICA
function consultarUsuario($conexion,$email,$pass) {
	// SENTENCIA SELECT PARA CONTAR CUANTOS USUARIOS HAY
	// 		CON DICHO EMAIL Y PASS
	$consulta = "SELECT COUNT(*) AS TOTAL FROM USUARIOS WHERE EMAIL=:email AND PASS=:pass";
	$stmt = $conexion->prepare($consulta);
	$stmt -> bindParam(':email',$email);
	$stmt -> bindParam(':pass',$pass);
	$stmt -> execute();
	return $stmt -> fetchColumn();
	// UTILIZA EL MÉTOD "PREPARE" DEL OBJETO PDO 
	// RETORNE EL RESULTADO DEL MÉTOD "FETCHCOLUMN"

}


