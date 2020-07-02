<?php

    session_start();

    require_once ("../Gestiona/gestionBD.php");
    require_once ("../Gestiona/gestionarFacturas.php");

    $conexion = crearConexionBD();

    if(isset($_SESSION['DNI_CIF'])){
        $OidCliente = $_SESSION['DNI_CIF'];
    }
    else{
      
        Header('Location: ../Vista/inicio.php');
    
    }


    if (isset($_REQUEST["factEsp"])) {
        $factEsp = consultarFacturaEspecifica($conexion,$_REQUEST["factEsp"]);
        unset($_REQUEST["factEsp"]);
    }
    else{
        if(isset($_REQUEST["ordImporte"])){
            $facturas = consultarTodasFacturasClienteImporte($conexion,$OidCliente);
        }
        else{
            $facturas = consultarTodasFacturasClienteFecha($conexion,$OidCliente);
        }
    }

    cerrarConexionBD($conexion);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../CSS/cabecera_cliente.css">
    <link rel="stylesheet" href="../CSS/pagPrincipal.css">
    <link rel="stylesheet" href="../CSS/pie.css">
    <script src="js/modal.js" type="text/javascript"></script>
<title>DEDESIN S.L</title>
    <style>
        .boton{
            width: 100%;
            color: transparent; 
            background-color: 
            transparent; 
            border-color: transparent;
            float: left;
        }
        .imgBoton{
            width: 100%;
        }
        /* Tabla */
        table {
            border-collapse: collapse;
            margin: 20px;
            margin-left: 10px;
            margin-top: 40px;
            background: black;
            opacity: 0.7;
            color: white;
        }
         th {
            background: #00FF7F;
            color: black;
        }

        th, td {
                border: 1px solid #00FF7F;
            padding: 8px;
        }

        tr:hover {
          background: #d1d1d1;
        }
        /* Tabla */
        #masInfo{
            border: black solid 0.2em;
            width: 20%;
            margin: 1em;
            background-color: lightgrey;
        }
    </style>
</head>

<body>

    <!-- Si estamos viendo datos de una factura específica entramos aquí -->
    <?php if (isset($factEsp)) { ?>
        
        <div id="masInfo">
            <h1> Factura Nº: <?php echo $factEsp["NUMEROFACTURA"] ?> </h1>

            <div id="InfoEspecifica">
                <ul>
                    <li>Fecha: <?php echo $factEsp["FECHA"] ?></li>
                    <li>Concepto: <?php echo $factEsp["CONCEPTO"] ?></li>
                    <li>Importe: <?php echo $factEsp["IMPORTE"] ?></li>
                    <li>Estado: <?php echo $factEsp["STATUS"] ?></li>
                    <li>ID Servicio: <?php echo $factEsp["ID_SC"] ?></li>
                    <br>
                    <li>Contrato: <?php echo $factEsp["CONTRATO"] ?></li>
                    <li>Fecha de Pago: <?php echo $factEsp["FECHAPAGO"] ?></li>
                    <li>Forma de Pago: <?php echo $factEsp["FORMAPAGO"] ?></li>
                    <li>Código: <?php echo $factEsp["CODIGO"] ?></li>
                    <li>Observaciones: <?php echo $factEsp["OBSERVACIONES"] ?></li>
                </ul>
            </div>
        </div>
        <a href="facturasCliente.php"><button>Volver</button></a>

    <!-- Si estamos viendo todas las facturas entramos aquí -->
    <?php }else{ ?>
    <header>
        <?php include_once("../Cabeceras/cabeceraCliente.php"); ?>
    </header>
        <h2>Mis facturas (DNI/CIF : <?php echo $OidCliente ?>) </h2>
        

            <div class="ordfi">
                <form action="facturasCliente.php" style="float: left">
                    <input type="hidden" id="ordFecha" name="ordFecha">
                    <input type="submit" value="Ordenar por Fecha">
                </form>
                <form action="facturasCliente.php" style="float: right">
                    <input type="hidden" id="ordImporte" name="ordImporte">
                    <input type="submit" value="Ordenar por Importe">
                </form>
            </div>
            <br>
            <div>
                <table bgcolor="#F1EFEF" border="2px" >
                    <tr>
                        <th>Fecha</th>
                        <th>Concepto</th> 
                        <th>Importe</th>
                        <th>Estado</th>
                        <th>ID Servicio</th>
                        <th style="width: 2em">Más Info</th>
                    </tr>
                    <?php foreach ($facturas as $factura) { ?> 
                        <tr>

                            <td> <?php echo $factura["FECHA"]; ?> </td>
                            <td> <?php echo $factura["CONCEPTO"]; ?> </td>
                            <td> <?php echo $factura["IMPORTE"]; ?> </td>
                            <td> <?php echo $factura["STATUS"]; ?> </td>
                            <td> 
                                <!-- TODO: Añadir formulario que te lleve a ese servicio contratado -->
                                <?php echo $factura["ID_SC"]; ?> 
                            </td>
                            <td>
                                <form action="facturasCliente.php">
                                    <input type="hidden" name="factEsp" value="<?php echo $factura["NUMEROFACTURA"] ?>">
                                    <button id="factEsp" type="submit" class="boton"> <img src="../Imagenes/info.png" class="imgBoton"></button>
                                </form>
                            </td>
                        </tr>
                        
                    <?php } ?>
                </table>   
            </div>

        <?php include_once("pie.php"); ?>

    <?php } ?>    

</body>

</html>

