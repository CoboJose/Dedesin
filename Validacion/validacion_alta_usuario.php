<?php 
 session_start();
 require_once("../Gestiona/gestionBD.php");
 require_once("../Gestiona/gestionUsuario.php");

if (isset($_REQUEST['DNI_CIF'])){
		$nuevo_usuario['DNI_CIF']= $_REQUEST['DNI_CIF'];
		$nuevo_usuario['Contrasena']= $_REQUEST['Contrasena'];
		$nuevo_usuario['Confirmacion'] = $_REQUEST['Confirmacion'];
		$nuevo_usuario['Telefono']= $_REQUEST['Telefono'];
		$nuevo_usuario['Email']= $_REQUEST['Email'];
		$nuevo_usuario['TipoCliente']= $_REQUEST['TipoCliente'];
		$nuevo_usuario['Nombre']= $_REQUEST['Nombre'];	
		$nuevo_usuario['FormaPago']= $_REQUEST['FormaPago'];
		$nuevo_usuario['NumeroCuenta']= $_REQUEST['NumeroCuenta'];
		$nuevo_usuario['CancelacionesIndebidas'] = 0;

		$_SESSION['nuevo_usuario']  = $nuevo_usuario;
		 }
else{
	header("Location : ../Vista/form_alta_usuario.php");
}
	$conexion = crearConexionBD(); 
	$errores = validarDatosUsuario($conexion, $nuevo_usuario);
	cerrarConexionBD($conexion);
	
	// Si se han detectado errores
	if (count($errores)>0) {
		// Guardo en la sesión los mensajes de error y volvemos al formulario
		$_SESSION["errores"] = $errores;
		header('Location: ../Vista/form_alta_usuario.php');
	} else
		// Si todo va bien, vamos a la página de acción (inserción del usuario en la base de datos)
		Header('Location: ../Accion/accion_alta_usuario.php');


	function validarDatosUsuario($conexion, $usuario){
	$errores=array();

	if($usuario["DNI_CIF"]=="") {
		$errores[] = "<p>El DNI/CIF no puede estar vacío</p>";
	}

	else if(!preg_match("/^[0-9]{8}[A-Z]$/", $usuario["DNI_CIF"])){
		$errores[] = "<p>El DNI/CIF debe contener 8 números y una letra mayúscula: " . $usuario["DNI_CIF"] ."</p>";}

	if(strlen($usuario['Telefono']) == 8) {
		$errores[] = "<p>El número de telefono tiene que tener 9 dígitos</p>";
	}

	

	if($usuario["FormaPago"]!= "Efectivo" && 
    $usuario["FormaPago"]!= "Tarjeta"){
	$errores[] = "<p>La forma de pago debe ser Efectivo o Tarjeta</p>";
	}

	if($usuario["TipoCliente"]!= "Particular" && 
    $usuario["TipoCliente"]!= "Empresa" &&
	$usuario["TipoCliente"]!= "Administración pública"){
	$errores[] = "<p>El tipo de cliente debe ser Particular, Empresa o Administración pública </p>";
	}

	if($usuario["Nombre"]==""){ 
		$errores[] = "<p>El nombre del usuario no puede estar vacío</p>";}

	if (!filter_var($usuario["Email"], FILTER_VALIDATE_EMAIL)) {
  $errores[] = "<p>Dirección de correo inválida</p>"; 
	}
	if ($usuario["FormaPago"] == "Tarjeta" &&
	$usuario["NumeroCuenta"] =="") {
	$errores[] = "<p>Si desea pagar con tarjeta debe especificar el número de cuenta</p>";
}

	if(!isset($usuario["Contrasena"]) || strlen($usuario["Contrasena"])<8){
		$errores [] = "<p>Contraseña no válida: debe tener al menos 8 caracteres</p>";
	}
	else if(!preg_match("/[a-z]+/", $usuario["Contrasena"]) || 
		!preg_match("/[A-Z]+/", $usuario["Contrasena"]) || !preg_match("/[0-9]+/", $usuario["Contrasena"])){
		$errores[] = "<p>Contraseña no válida: debe contener letras mayúsculas y minúsculas y dígitos</p>";
	}
	else if($usuario["Contrasena"] != $usuario["Confirmacion"]){
		$errores[] = "<p>La confirmación de contraseña no coincide con la contraseña</p>";}


	return $errores;
	} 
    ?>