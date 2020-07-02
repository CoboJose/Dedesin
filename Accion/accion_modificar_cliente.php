<?php 

	session_start();	
	require_once("../Gestiona/gestionBD.php");
	require_once("../Gestiona/gestionUsuario.php");

	if (isset($_SESSION["clMod"])) {
		$clMod = $_SESSION["clMod"];
		unset($_SESSION["clMod"]);
		
		
		
		$conexion = crearConexionBD();

		if(modificar_usuario($conexion,$clMod)){
			
			$_SESSION['Acierto'] = "<p>DATOS MODIFICADOS CON ÉXITO</p>";
			header("Location: ../Vista/cuentaCliente.php");
			
			 }  
		
		else{
			$_SESSION['errores'] = "<p>ERROR INTERNO</p>";
			header('Location: ../Vista/cuentaCliente.php');
		}
		
		cerrarConexionBD($conexion);
		 	}
		else{
			header('Location : ../Vista/inicio.php');                                                                                                                                                                      
		}

		 
		



 ?>