<?php 
 session_start();
 	require_once("../Gestiona/gestionBD.php");
	require_once("../Gestiona/gestionUsuario.php");	

	$DNI_CIF = $_SESSION['DNI_CIF'];

	if(!isset($DNI_CIF)){
	header("Location : ../Vista/form_alta_usuario.php");
	}	

	else{
		$usuario = $_SESSION['clMod'];
		$usuario['DNI_CIF']= $_REQUEST['DNI_CIF'];
		$usuario['Contrasena']= $_REQUEST['Contrasena'];
		$usuario['Confirmacion'] = $_REQUEST['Confirmacion'];
		$usuario['Telefono']= $_REQUEST['Telefono'];
		$usuario['Email']= $_REQUEST['Email'];
		$usuario['TipoCliente']= $_REQUEST['TipoCliente'];
		$usuario['Nombre']= $_REQUEST['Nombre'];	
		$usuario['FormaPago']= $_REQUEST['FormaPago'];
		$usuario['NumeroCuenta']= $_REQUEST['NumeroCuenta'];
		$usuario['CancelacionesIndebidas'] = 0;

	$usuario = $_SESSION['clMod'];
	$conexion = crearConexionBD(); 
	$errores = validarDatosUsuario($conexion, $usuario);

	cerrarConexionBD($conexion);
	
	
	if (count($errores)>0) {
		
		$_SESSION["errores"] = $errores;
		header('Location: ../Vista/cuentaCliente.php');
	} else
		
		Header('Location: ../Accion/accion_modificar_cliente.php');}


	function validarDatosUsuario($conexion, $usuario){
	$errores=array();

	if(strlen($usuario['Telefono']) == 8) {
		$errores[] = "<p>El número de telefono tiene que tener 9 dígitos</p>";
	}
	if(!is_numeric($usuario['Telefono'])) {
		$errores[] = "<p>El número de teléfono tiene que ser dígitos sus componentes</p>";
	}

	if($usuario["FormaPago"]!= "Efectivo" && 
    $usuario["FormaPago"]!= "Tarjeta"){
	$errores[] = "<p>La forma de pago debe ser Efectivo o Tarjeta</p>";
	}

	if (!filter_var($usuario["Email"], FILTER_VALIDATE_EMAIL)) {
  $errores[] = "<p>Dirección de correo inválida</p>"; 
}

	if($usuario["Nombre"]==""){ 
		$errores[] = "<p>El nombre del usuario no puede estar vacío</p>";}


	if ($usuario["FormaPago"] == "Tarjeta" &&
	$usuario["NumeroCuenta"] =="") {
	$errores[] = "<p>Si desea pagar con tarjeta debe especificar el número de cuenta</p>";
}
	return $errores;
	} 
    ?>