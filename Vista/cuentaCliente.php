<?php 
	session_start();
	require_once("../Gestiona/gestionBD.php");
	require_once("../Gestiona/gestionUsuario.php");
	

	if(isset($_REQUEST['salir'])){
		unset($_SESSION['DNI_CIF']);
		header('Location : ../Vista/inicio.php');
	}
	if(isset($_SESSION["clMod"])){
            $clMod = $_SESSION["clMod"];
            unset($_SESSION["clMod"]);
    }
	if(isset($_SESSION['DNI_CIF'])){
		$usuario = $_SESSION['DNI_CIF'];
		
	}
  if(!isset($_SESSION['DNI_CIF'])){
        Header('Location: ../Vista/inicio.php');
    }

    $conexion = crearConexionBD();

	
	$nombreUsuario =  consultarNombreCliente($conexion, $usuario);
	$telefono = consultarTelefonoCliente($conexion, $usuario);
	$email = consultarEmailCliente($conexion, $usuario);
	$formaPago = consultarFormaPagoCliente($conexion, $usuario);
	$numeroCuenta = consultarNumeroCuentaCliente($conexion, $usuario);
    $contrasena = consultarContrasenaCliente($conexion, $usuario);
    $tipoCliente = consultarTipoClienteCliente($conexion, $usuario);
	$cancelacionesIndebidas = consultarCancelacionesIndebidasCliente($conexion, $usuario);

	//}


 ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="../CSS/pagPrincipal.css">
	<link rel="stylesheet" href="../CSS/cabecera_cliente.css">
	<link rel="stylesheet" href="../CSS/pie.css">
	<script src="https://code.jquery.com/jquery-3.4.1.js" type="text/javascript"></script>
	<script src="../JS/validacion_datos_clientes.js" type="text/javascript"></script>
    <title>DEDESIN S.L</title>
</head>
<body>
		<header>
		<?php include_once("../Cabeceras/cabeceraCliente.php"); ?>
			
		</header>
		<script>
			$(document).ready(function() {
				$("#modificarDatosClientes").on("submit", function() {
					return validateDatosCliente();
				});
			});
		</script>
		 <h1 class="h1">MIS DATOS</h1>


		  <?php if(isset($_SESSION["errores"])){?>
            <p> <?php foreach ($_SESSION["errores"] as $error) {
                echo $error;
    
            } unset($_SESSION["errores"]);?> </p>


          <?php } if(isset($_SESSION["Acierto"])){?>
            <script type="text/javascript">
              alert("Datos modificados con éxito")
            </script> 
            <?php 
            
            unset($_SESSION["Acierto"]);
          }


          if(isset($clMod)){ ?>
    <div class="tod">
		 <form id="modificarDatosClientes" method="GET" action="../Controlador/controladorClientes.php">
            
            <input id="DNI_CIF" name="DNI_CIF" type="hidden" value="<?php echo $usuario?>"/>
            <br>
            <input id="CancelacionesIndebidas" name="CancelacionesIndebidas" type="hidden" value="<?php echo $clMod['CancelacionesIndebidas']?>"/>  

            <input id="Contrasena" name="Contrasena" type="hidden" value="<?php echo $clMod['Contrasena']?>"/>

            <input id="TipoCliente" name="TipoCliente" type="hidden" value="<?php echo $clMod['TipoCliente']?>"/>


          <p>  DNI/CIF: <?php echo $clMod['DNI_CIF'];?> </p>
            <label for="Nombre">Nombre:</label>
            <input id="Nombre" name="Nombre" type="text" value="<?php echo $clMod['Nombre'] ?>" required/> <br>

             <label for="Telefono">Telefono:</label>
            <input id="Telefono" name="Telefono" type="text" value="<?php echo $clMod['Telefono'] ?>" required maxlength="9"/> <br>

             <label for="Email">Email:</label>
            <input id="Email" name="Email" type="text" value="<?php echo $clMod['Email'] ?>" required/> <br>

             <label for="FormaPago">Forma de pago:</label>
            <input id="FormaPago" name="FormaPago" type="text" value="<?php echo $clMod['FormaPago'] ?>" required/> <br>

             <label for="NumeroCuenta"> Número de cuenta bancaria:</label>
            <input id="NumeroCuenta" name="NumeroCuenta" type="text" value="<?php echo $clMod['NumeroCuenta'] ?>" maxlength="24" /> <br>


            <br>            
            <button id="grabar" name="grabar" type="submit"> Enviar</button>

        </form> 
      </div>   	
    <?php } else{
    ?>
    <div class="tod">
 		  <form method="GET" action="../Controlador/controladorClientes.php">
             <input id="DNI_CIF" name="DNI_CIF" type="hidden" value="<?php echo $usuario ?>" required/> 
             <input id="Contrasena" name="Contrasena" type="hidden" required="required" value=<?php echo $contrasena ?>/>          
             <input id="Telefono" name="Telefono" type="hidden" value="<?php echo $telefono ?>" required/> 
             <input id="Email" name="Email" type="hidden" value="<?php echo $email ?>" required/> 

            <input id="TipoCliente" name="TipoCliente" type="hidden" value="<?php echo $tipoCliente ?>" required/> <br>

            <input id="Nombre" name="Nombre" type="hidden" value="<?php echo $nombreUsuario ?>" required/> 

            <input id="FormaPago" name="FormaPago" type="hidden" value="<?php echo $formaPago ?>" required/> 

            <input id="NumeroCuenta" name="NumeroCuenta" type="hidden" value="<?php echo $numeroCuenta ?>" /> 
            <input id="CancelacionesIndebidas" name="CancelacionesIndebidas" type="hidden" value="<?php echo $cancelacionesIndebidas ?>" required/> 

	 		

                    <ul>
                        <li>DNI/CIF:               <?php echo $usuario ?> </li>
                        <li>Nombre:                  <?php echo $nombreUsuario?> </li>
                        <li>Teléfono:              <?php echo $telefono ?> </li>
                        <li>Email:      <?php echo $email ?> </li>
                        <li>Forma de pago:       <?php echo $formaPago ?> </li>
                        <li>Número de cuenta bancaria: <?php echo $numeroCuenta ?> </li>
                    </ul>

                    <button class="bye"   id="editar" name="editar" type="submit">Modificar</button>
      </form>
                <?php } ?>
      <form action="inicio.php" method="GET">
			 <input class="bye" type="submit" name="salir" value="Cerrar cesión">
		  </form>
    </div>
	<footer>
     <?php include_once("../pie.php");
     cerrarConexionBD($conexion); ?>   
    </footer>
</body>
</html>
