<?php 
	session_start();
	require_once("../Gestiona/gestionBD.php");
	require_once("../Gestiona/gestionUsuario.php");
	
   if(!isset($_SESSION['DNI_CIF'])){
       Header('Location: ../Vista/inicio.php');
    }
    else{

	$usuario = $_SESSION['DNI_CIF'];
	$tipoUsuario = $_SESSION['TipoUsuario'];
	$conexion = crearConexionBD();
	if($tipoUsuario == "Cliente"){
	$nombreUsuario =  consultarNombreCliente($conexion, $usuario);	
	}

	if($tipoUsuario == "Trabajador"){
	$nombreUsuario =  consultarNombreTrabajador($conexion, $usuario);	
	}
	
	if($tipoUsuario == "Gerente"){
	$nombreUsuario =  consultarNombreGerente($conexion, $usuario);	
	}
	}
	
	cerrarConexionBD($conexion);//}

if(isset($_SESSION['salir'])){
	unset($usuario);
	unset($_SESSION['DNI_CIF']);
	header('Location : ../Vista/inicio.php');}
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
    <title>DEDESIN S.L</title>
</head>
<body style="min-height: 100vh">
	<header>
		<?php
			if($tipoUsuario == "Cliente"){
			include_once("../Cabeceras/cabeceraCliente.php");	
			}

			if($tipoUsuario == "Trabajador"){
			include_once("../Cabeceras/cabeceraTrabajador.php");	
			}
	
			if($tipoUsuario == "Gerente"){
			include_once("../Cabeceras/cabeceraGerente.php");	
			}
		 ?>
				
	</header>
	<br>
	<article>
	<div class="tod"> 
	 	<div class="bienvenido">
		 <h2 class="h2fg">Bienvenido <?php echo $nombreUsuario . " "  ?> a la página web de Dedesin S.L</h2>
		</div>
		<div class="info"> 
		 <p>Desde esta página web puede:</p>
		 <br>
		 <ul>
			 <li>Solicitar un servicio, específicando su problema en el
				  apartado de Contrataciones</li>
			<li>Observar y analizar las facturas de un servicio ya contratado,
				en el apartado de Facturas
			</li>
			<li>Ver sus propios datos y modificarlos, en el apartado de Mis datos.</li>
		 </ul>
		</div>
	</div>
	</article>
	 
	 <script type="text/javascript">
	 function actual() {
         fecha=new Date(); //Actualizar fecha.
         hora=fecha.getHours(); //hora actual
         minuto=fecha.getMinutes(); //minuto actual
         segundo=fecha.getSeconds(); //segundo actual
         if (hora<10) { //dos cifras para la hora
            hora="0"+hora;
            }
         if (minuto<10) { //dos cifras para el minuto
            minuto="0"+minuto;
            }
         if (segundo<10) { //dos cifras para el segundo
            segundo="0"+segundo;
            }
         //ver en el recuadro del reloj:
         mireloj = hora+" : "+minuto+" : "+segundo;	
				 return mireloj; 
         }
	function actualizar() { //función del temporizador
   mihora=actual(); //recoger hora actual
   mireloj=document.getElementById("reloj"); //buscar elemento reloj
   mireloj.innerHTML=mihora; //incluir hora en elemento
	 }
	setInterval(actualizar,1000); //iniciar temporizador	
	 </script>
	 <div id="reloj" class="reloj">00 : 00 : 00
</div>

			<?php include_once("../pie.php"); ?>
	
</body>
</html>