<?php

    session_start();

    require_once ("../Gestiona/gestionBD.php");
    require_once ("../Gestiona/gestionarVehiculos.php");

    $conexion = crearConexionBD();

    if(isset($_SESSION['DNI_CIF'])){
        $Trabajador = consultaTrabajadorConDNI($conexion,$_SESSION['DNI_CIF']);
        $OidTrabajador = $Trabajador['NUMEROTRABAJADOR'];
    }
    else{
       Header('Location: ../Vista/inicio.php');
    }

    $vehiculo = consultarVehiculosTrabajador($conexion,$OidTrabajador);

    cerrarConexionBD($conexion);
    
?>
    
<!DOCTYPE html>
<html lang="es">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../CSS/cabecera_cliente.css">
    <link rel="stylesheet" type="text/css" href="../CSS/vehiculosGerente.css" />
    <link rel="stylesheet" href="../CSS/pie.css">
    <title>DEDESIN S.L</title>
    
    <style>
       
        .Vehiculo{
            border: black outset 0.15em;
            border-color: black;
            border-radius: 1.5em;
            background-color: #00FF7F;
            opacity: 0.8;
            width: 20%;
            padding: 0.5%;
            float: center;
            margin: 1%;
            margin-right: 20%;
            border-top: black solid 0.75em;

            position: absolute;
            top: 20%;
            left: 40%;   
        }
        #vehiculo{
            border-left: black solid 0.1em;
            float: right;
            width: 10%;
        }
    </style>

</head>

<body>
	<header>
        <?php include_once("../Cabeceras/cabeceraTrabajador.php"); ?>
    </header>
    <h2>Vehículo asignado a Trabajador con DNI: <?php echo $_SESSION['DNI_CIF'] ?> </h1>

    <div class="Vehiculo">
    <ul>

        <?php foreach($vehiculo as $vehic) { ?>

        <li>Matrícula:               <?php echo $vehic["MATRICULA"] ?> </li>
        <li>Modelo:                  <?php echo $vehic["MARCAMODELO"] ?> </li>
        <li>Km totales:              <?php echo $vehic["KMTOTALES"] ?> </li>
        <li>Número de bastidor:      <?php echo $vehic["NUMBASTIDOR"] ?> </li>
        <li>Fecha Próxima ITV:       <?php echo $vehic["FECHAPROXITV"] ?> </li>
        <li>Fecha Expiración seguro: <?php echo $vehic["FECHAEXPSEGURO"] ?> </li>

        <img src="../Imagenes/vehiculo.png" id="vehiculo">
        
        <?php } ?>
        
    </ul>
    </div>
	
	<?php include_once("pie.php"); ?>
	
</body>

</html>