<?php
	session_start();

	require_once("../Gestiona/gestionBD.php");
	require_once("../Gestiona/gestionUsuario.php");

	if (isset($_SESSION['nuevo_usuario'])) {

		$nuevo_usuario = $_SESSION["nuevo_usuario"];
		$conexion = crearConexionBD(); 

		if(alta_usuario($conexion,$nuevo_usuario)){
		$_SESSION['DNI_CIF'] = $nuevo_usuario['DNI_CIF'];
		$_SESSION["errores"] = null;
		$_SESSION["TipoUsuario"] = "Cliente";
		cerrarConexionBD($conexion);
		Header('Location: ../Vista/pagPrincipal.php');}

		else{
			$_SESSION["errores"] = "<p> Este usuario ya existe en la base de datos </p>";
        Header('Location: ../Vista/form_alta_usuario.php');
    }


	}
	else {
		
		header('Location : ../Vista/form_alta_usuario.php');

	}
	
	

?>
