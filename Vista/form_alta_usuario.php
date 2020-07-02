<?php
	session_start();

	if(isset($_SESSION['errores'])){
		$errores = $_SESSION['errores'];
		unset($_SESSION['errores']);
	}
	if (isset($_POST['DNI_CIF'])){
		$nuevo_usuario['DNI_CIF']= $_REQUEST['DNI_CIF'];
		$nuevo_usuario['Contrasena']= $_REQUEST['Contrasena'];
		$nuevo_usuario['Confirmacion'] = $_REQUEST['Confirmacion'];
		$nuevo_usuario['Telefono']= $_REQUEST['Telefono'];
		$nuevo_usuario['Email']= $_REQUEST['Email'];
		$nuevo_usuario['TipoCliente']= $_REQUEST['TipoCliente'];
		$nuevo_usuario['Nombre']= $_REQUEST['Nombre'];	
		$nuevo_usuario['FormaPago']= $_REQUEST['FormaPago'];
		$nuevo_usuario['NumeroCuenta']= $_REQUEST['NumeroCuenta'];
		$nuevo_usuario['CancelacionesIndebidas']= 0;

		$_SESSION['nuevo_usuario'] = $nuevo_usuario;		
		

			
		}	
		else{
		$nuevo_usuario['DNI_CIF']= "";
		$nuevo_usuario['Contrasena']= "";
		$nuevo_usuario['Confirmacion'] = "";
		$nuevo_usuario['Telefono']= 0;
		$nuevo_usuario['Email']= "";
		$nuevo_usuario['TipoCliente']= "";
		$nuevo_usuario['Nombre']= "";	
		$nuevo_usuario['FormaPago']= "";
		$nuevo_usuario['NumeroCuenta']= "";
		$nuevo_usuario['CancelacionesIndebidas']= 0;	
		}
		

?>

<!DOCTYPE html>
<html lang="es">
<head>
<title>DEDESIN S.L</title>
  <meta charset="utf-8">
  <meta name="viewport" content="wnameth=device-wnameth, initial-scale=1">
  <link rel="stylesheet" href="../CSS/signUp.css">
  <script src="https://code.jquery.com/jquery-3.4.1.js" type="text/javascript"></script>
  <script src="../JS/validacion_registro_clientes.js" type="text/javascript"></script>
</head>
<body>
	<script>
		$(document).ready(function() {
			$("#formulario").on("submit", function() {
				return validateDatosCliente();
			});
			$("#Contrasena").on("keyup",function(){
				passwordColor();
			});
		});
		
	</script>

  <form class="formulario" name="formulario" id="formulario" method="GET" action="../Validacion/validacion_alta_usuario.php">
  	  <h1>Registro</h1>
  	  <p>Rellene el formulario con sus datos para registrarse. Todos los campos son obligatorios</p>
  	  <?php if(isset($errores)){ ?>

  	  	<div class="error">
  	  <p>El usuario introducido ya existe en la base de datos.	</p>
		</div>
  	  <?php }  ?> 

      	<input class="datosPersonalesIn" id="DNI_CIF" name="DNI_CIF" type="text" placeholder="DNI / CIF" required maxlength="9" title="El dato introducido tiene que contener 8 dígitos y una letra." />     

      	<input class="datosPersonalesIn" id="Contrasena"  name="Contrasena" type="password" placeholder="Contraseña" required /> 
      		
      	<input class="datosPersonalesIn" id="Confirmacion"  name="Confirmacion" type="cpassword" placeholder="Confirme su contraseña" required /> 
        
      	<input class="datosPersonalesIn" id="Nombre"  name="Nombre" type="text" placeholder="Nombre y apellidos" maxlength="50" required />

      	<input class="datosPersonalesIn" id="Telefono"  name="Telefono" type="text" placeholder="Teléfono" maxlength="9" required />

      	<input class="datosPersonalesIn" id="Email"  name="Email" type="text" placeholder="Email" maxlength="25" title="Introduzca su email" required />

	  	<input class="datosPersonalesIn" id="TipoCliente"  name="TipoCliente" type="text" placeholder="Particular, Empresa o Administracion Publica" maxlength="50" required />
    
	  	<input class="datosPersonalesIn" id="FormaPago"  name="FormaPago" type="text" placeholder="Efectivo o Tarjeta" maxlength="50" required />
    
      	<input class="datosPersonalesIn"  id="NumeroCuenta"  name="NumeroCuenta" type="text" placeholder="Número de cuenta bancaria" maxlength="24"
      	title="El número de la cuenta bancaria tiene que estar conpuesto por : ES y 22 números"/> 

		<input type="submit" name="submit" value="Enviar"/>
  	</form>
	
</body>
</html>
