<?php

    session_start();

    require_once ("../Gestiona/gestionBD.php");
    require_once ("../Gestiona/gestionarFacturas.php");

    $conexion = crearConexionBD();

    if(!isset($_SESSION['DNI_CIF'])){

        Header('Location: ../Vista/inicio.php');
    }
    else{

    if (isset($_SESSION["errores"])){
        $errores = $_SESSION["errores"];
        unset($_SESSION["errores"]);
    }

    if(isset($_REQUEST["nfactura"])){
        $nfactura = $_REQUEST["nfactura"];
    }
    if (isset($_REQUEST["factEsp"])) {
        $factEsp = $_REQUEST["factEsp"];
    }
    if (isset($_REQUEST["ordPagado"])) {
        $ordPagado = $_REQUEST["ordPagado"];
    }
    if (isset($_REQUEST["buscaCliente"])) {
        $buscaCliente = $_REQUEST["buscaCliente"];
    }
    if(isset($_SESSION["factMod"])){
            $factMod = $_SESSION["factMod"];
            unset($_SESSION["factMod"]);
    }
    
    if(isset($nfactura))
        $factEsp = consultarFacturaEspecifica($conexion,$nfactura);

    elseif(isset($factEsp))
        $factEsp = consultarFacturaEspecifica($conexion,$factEsp);

    elseif(isset($buscaCliente))
        $facturas = consultarFacturasFechaCliente($conexion,$buscaCliente);

    else{
        if(isset($_REQUEST["ordPagado"])){
            $facturas = consultarFacturasPagado($conexion);
        }
        else{
            $facturas = consultarFacturasFecha($conexion);
        }
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
    <link rel="stylesheet" href="../CSS/cabecera_gerente.css">
    <link rel="stylesheet" type="text/css" href="../CSS/pagPrincipal.css"/>
    <link rel="stylesheet" href="../CSS/pie.css">
    <script src="https://code.jquery.com/jquery-3.4.1.js" type="text/javascript"></script>
    <script src="../JS/validacion_modificacion_factura.js" type="text/javascript"></script>
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
	<script>
		$(document).ready(function() {
			$("#modificarFactura").on("submit", function() {
				return validateFactura();
			});
			$("#bBorrar").on("click", function() {
  				if(confirm("¿Está seguro que desea borrarlo?")){
                	return true;
                }else{
                	return false;
                }
			});
		});
	</script>

    <!-- Si estamos modificando factura -->

    <?php if (isset($factMod)) { ?> 
        
        <?php if (isset($errores) && count($errores)>0) { 
                echo "<div id=\"div_errores\" class=\"error\">";
                echo "<h4> Errores en el formulario:</h4>";
                foreach($errores as $error){
                    echo $error;
                } 
                echo "</div>";
            } ?>

        <div>
            <form id="modificarFactura" method="POST" action="../Controlador/controlador_facturas.php">
                
                <div id="infoEdit">
                    <ul>
                        <li>Numero Factura: <?php echo $factMod['NUMEROFACTURA'];?></li>
                        <li>Cliente: <?php echo $factMod['DNI_CIF'];?></li>
                        <li>Fecha: <?php echo $factMod['FECHA'];?></li>
                        <li>Fecha de Pago: <?php echo $factMod['FECHAPAGO'];?></li>
                        <li>Fecha de Recepción: <?php echo $factMod['FECHARECEPCION'];?></li>

                    </ul>
                </div>
                <div id="formEdit">
                    <input id="NUMEROFACTURA" name="NUMEROFACTURA" type="hidden" value="<?php echo $factMod['NUMEROFACTURA'];?>"/>
                    <label for="FECHA">Fecha:</label>
                    <input id="FECHA" name="FECHA" type="date" value="2020-05-25" required/> <br>
                    <label for="SERIE">Serie:</label>
                    <input id="SERIE" name="SERIE" type="text" value="<?php echo $factMod['SERIE'] ?>" required/> <br>
                    <label for="CONCEPTO">Concepto:</label>
                    <input id="CONCEPTO" name="CONCEPTO" type="text" value="<?php echo $factMod['CONCEPTO'] ?>" required/> <br>
                    <label for="TIPOIMPOSITIVO">Tipo impositivo:</label>
                    <input id="TIPOIMPOSITIVO" name="TIPOIMPOSITIVO" type="number" value="<?php echo $factMod['TIPOIMPOSITIVO'] ?>" required/> <br>
                    <label for="IVA">IVA:</label>
                    <input id="IVA" name="IVA" type="number" value="<?php echo $factMod['IVA'] ?>" required/> <br>
                    <label for="TOTAL">Total:</label>
                    <input id="TOTAL" name="TOTAL" type="number" value="<?php echo $factMod['TOTAL'] ?>" required/> <br>
                    <label for="FECHAPAGO">Fecha de Pago:</label>
                    <input id="FECHAPAGO" name="FECHAPAGO" type="date" value="2018-06-10" required/> <br>
                    <label for="IMPORTE">Importe:</label>
                    <input id="IMPORTE" name="IMPORTE" type="text" value="<?php echo $factMod['IMPORTE'] ?>" required/> <br>
                    <label for="FORMAPAGO">Forma de Pago:</label>
                    <input id="FORMAPAGO" name="FORMAPAGO" type="text" value="<?php echo $factMod['FORMAPAGO'] ?>" required/> <br>
                    <label for="STATUS">Estado:</label>
                    <input id="STATUS" name="STATUS" type="text" value="<?php echo $factMod['STATUS'] ?>" required/> <br>
                    <label><input id="PAGO" name="PAGO" type="radio" value="1" <?php if($factMod['PAGO']=='1') echo ' checked '; ?>/>Si</label>
                    <label><input id="PAGO" name="PAGO" type="radio" value="0" <?php if($factMod['PAGO']=='0') echo ' checked '; ?>/>No</label><br>
                    <label for="RECEPCION">Recepcion:</label>
                    <input id="RECEPCION" name="RECEPCION" type="number" max="1" min="0" value="<?php echo $factMod['RECEPCION'] ?>" required/> <br>
                    <label for="PERSONARECEPCION">Persona de Recepción:</label>
                    <input id="PERSONARECEPCION" name="PERSONARECEPCION" type="text" value="<?php echo $factMod['PERSONARECEPCION'] ?>" required/> <br>
                    <label for="FECHARECEPCION">Fecha recepción:</label>
                    <input id="FECHARECEPCION" name="FECHARECEPCION" type="date" value="2018-07-15" required/> <br>
                    <label for="OBSERVACIONES">Observaciones:</label>
                    <input id="OBSERVACIONES" name="OBSERVACIONES" type="text" value="<?php echo $factMod['OBSERVACIONES'] ?>" required/> <br>

                </div>
                <br>
                <button id="bGrabar" name="grabar" type="submit" class="boton2"> <img src="../Imagenes/new.png" class="imgBoton2"></button>
                
            </form>

            <a href="facturasGerente.php"><button>Volver</button></a>

        </div>

    <!-- Si estamos viendo datos de una factura específica entramos aquí -->
    <?php } elseif (isset($factEsp)) { ?>
        
        <div class="tod">
            <h1> Factura Nº: <?php echo $factEsp["NUMEROFACTURA"] ?> </h1>

            <form action="../Controlador/controlador_facturas.php" method="POST">
                <input type="hidden" name="NUMEROFACTURA" value="<?php echo $factEsp['NUMEROFACTURA']?>">
                <input type="hidden" name="CONTRATO" value="<?php echo $factEsp['CONTRATO']?>">
                <input type="hidden" name="FECHA" value="<?php echo $factEsp['FECHA']?>">
                <input type="hidden" name="SERIE" value="<?php echo $factEsp['SERIE']?>">
                <input type="hidden" name="CONCEPTO" value="<?php echo $factEsp['CONCEPTO']?>">
                <input type="hidden" name="BASE" value="<?php echo $factEsp['BASE']?>">
                <input type="hidden" name="TIPOIMPOSITIVO" value="<?php echo $factEsp['TIPOIMPOSITIVO']?>">
                <input type="hidden" name="IVA" value="<?php echo $factEsp['IVA']?>">
                <input type="hidden" name="TOTAL" value="<?php echo $factEsp['TOTAL']?>">
                <input type="hidden" name="FECHAPAGO" value="<?php echo $factEsp['FECHAPAGO']?>">
                <input type="hidden" name="IMPORTE" value="<?php echo $factEsp['IMPORTE']?>">
                <input type="hidden" name="FORMAPAGO" value="<?php echo $factEsp['FORMAPAGO']?>">
                <input type="hidden" name="CODIGO" value="<?php echo $factEsp['CODIGO']?>">
                <input type="hidden" name="STATUS" value="<?php echo $factEsp['STATUS']?>">
                <input type="hidden" name="PAGO" value="<?php echo $factEsp['PAGO']?>">
                <input type="hidden" name="RECEPCION" value="<?php echo $factEsp['RECEPCION']?>">
                <input type="hidden" name="PERSONARECEPCION" value="<?php echo $factEsp['PERSONARECEPCION']?>">
                <input type="hidden" name="FECHARECEPCION" value="<?php echo $factEsp['FECHARECEPCION']?>">
                <input type="hidden" name="OBSERVACIONES" value="<?php echo $factEsp['OBSERVACIONES']?>">
                <input type="hidden" name="DNI_CIF" value="<?php echo $factEsp['DNI_CIF']?>">
                <input type="hidden" name="ID_SC" value="<?php echo $factEsp['ID_SC']?>">

                <div id="InfoEspecifica">
                    <ul>
                        <li>Cliente: <?php echo $factEsp["DNI_CIF"] ?></li>
                        <li>Numero Factura: <?php echo $factEsp["NUMEROFACTURA"] ?></li>
                        <li>Contrato: <?php echo $factEsp["CONTRATO"] ?></li>
                        <li>Fecha: <?php echo $factEsp["FECHA"] ?></li>
                        <li>Serie: <?php echo $factEsp["SERIE"] ?></li>
                        <li>Concepto: <?php echo $factEsp["CONCEPTO"] ?></li>
                        <li>Base: <?php echo $factEsp["BASE"] ?></li>
                        <li>Tipo Impositivo: <?php echo $factEsp["TIPOIMPOSITIVO"] ?></li>
                        <li>IVA: <?php echo $factEsp["IVA"] ?></li>
                        <li>Total: <?php echo $factEsp["TOTAL"] ?></li>
                        <li>Fecha Pago: <?php echo $factEsp["FECHAPAGO"] ?></li>
                        <li>Importe: <?php echo $factEsp["IMPORTE"] ?></li>
                        <li>Forma Pago: <?php echo $factEsp["FORMAPAGO"] ?></li>
                        <li>Código: <?php echo $factEsp["CODIGO"] ?></li>
                        <li>Estado: <?php echo $factEsp["STATUS"] ?></li>
                        <li>Pago: <?php echo $factEsp["PAGO"] ?></li>
                        <li>Recepción: <?php echo $factEsp["RECEPCION"] ?></li>
                        <li>Persona Recepción: <?php echo $factEsp["PERSONARECEPCION"] ?></li>
                        <li>Fecha Recepción: <?php echo $factEsp["FECHARECEPCION"] ?></li>
                        <li>Observaciones: <?php echo $factEsp["OBSERVACIONES"] ?></li>
                        <li>ID Servicio: <?php echo $factEsp["ID_SC"] ?></li>
                        
                    </ul>
                </div>

                <button id="bEditar" name="editar" type="submit" class="boton2"> <img src="../Imagenes/editar.png" class="imgBoton2"></button>
                <button id="bBorrar" name="borrar" type="submit" class="boton2"> <img src="../Imagenes/borrar.png" class="imgBoton2"></button>
            </form>

            <a href="facturasGerente.php"><button>Volver</button></a>
        </div>

    <!-- Si estamos viendo todas las facturas entramos aquí -->
    <?php }else{ ?>
    <header>
        <?php include_once("../Cabeceras/cabeceraGerente.php"); ?>
    </header>
    <div class="todfg">
        <h2 class="h2fg">Facturas de Clientes </h2>
        

            <div class="fg1">
                <form action="facturasGerente.php" style="float: left;">
                    <input type="hidden" id="ordFecha" name="ordFecha">
                    <input type="submit" value="Ordenar por Fecha">
                </form>
            </div>
            <div class="fg2">
                <form action="facturasGerente.php" style="float: right;">
                    <input type="hidden" id="ordPagado" name="ordPagado">
                    <input type="submit" value="Ordenar por Pagado">
                </form>
            </div>
            <br>
            <div class="fg3">
                    <form action="facturasGerente.php">
                    <input type="text" id="buscaCliente" name="buscaCliente">
                    <input type="submit" value="Buscar Cliente">
                </form>
                </div>
    </div>
            <br>
            <div class="tablafacg">
                <table bgcolor="#F1EFEF" border="2px" >
                    <tr>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Numero Factura</th>
                        <th>Concepto</th> 
                        <th>Importe</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>ID Servicio</th>
                        <th>Observaciones</th>
                        <th style="width: 2em">Más Info</th>
                        <th style="width: 2em">Editar</th>
                        <th style="width: 2em">Borrar</th>
                    </tr>
                    <?php foreach ($facturas as $factura) { ?> 
                        
                        <form action="../Controlador/controlador_facturas.php" method="POST">
                            <input type="hidden" name="NUMEROFACTURA" value="<?php echo $factura['NUMEROFACTURA']?>">
                            <input type="hidden" name="CONTRATO" value="<?php echo $factura['CONTRATO']?>">
                            <input type="hidden" name="FECHA" value="<?php echo $factura['FECHA']?>">
                            <input type="hidden" name="SERIE" value="<?php echo $factura['SERIE']?>">
                            <input type="hidden" name="CONCEPTO" value="<?php echo $factura['CONCEPTO']?>">
                            <input type="hidden" name="BASE" value="<?php echo $factura['BASE']?>">
                            <input type="hidden" name="TIPOIMPOSITIVO" value="<?php echo $factura['TIPOIMPOSITIVO']?>">
                            <input type="hidden" name="IVA" value="<?php echo $factura['IVA']?>">
                            <input type="hidden" name="TOTAL" value="<?php echo $factura['TOTAL']?>">
                            <input type="hidden" name="FECHAPAGO" value="<?php echo $factura['FECHAPAGO']?>">
                            <input type="hidden" name="IMPORTE" value="<?php echo $factura['IMPORTE']?>">
                            <input type="hidden" name="FORMAPAGO" value="<?php echo $factura['FORMAPAGO']?>">
                            <input type="hidden" name="CODIGO" value="<?php echo $factura['CODIGO']?>">
                            <input type="hidden" name="STATUS" value="<?php echo $factura['STATUS']?>">
                            <input type="hidden" name="PAGO" value="<?php echo $factura['PAGO']?>">
                            <input type="hidden" name="RECEPCION" value="<?php echo $factura['RECEPCION']?>">
                            <input type="hidden" name="PERSONARECEPCION" value="<?php echo $factura['PERSONARECEPCION']?>">
                            <input type="hidden" name="FECHARECEPCION" value="<?php echo $factura['FECHARECEPCION']?>">
                            <input type="hidden" name="OBSERVACIONES" value="<?php echo $factura['OBSERVACIONES']?>">
                            <input type="hidden" name="DNI_CIF" value="<?php echo $factura['DNI_CIF']?>">
                            <input type="hidden" name="ID_SC" value="<?php echo $factura['ID_SC']?>">

                            <tr>
                                <td> <?php echo $factura["FECHA"]; ?> </td>
                                <td> <?php echo $factura["DNI_CIF"]; ?> </td>
                                <td> <?php echo $factura["NUMEROFACTURA"]; ?> </td>
                                <td> <?php echo $factura["CONCEPTO"]; ?> </td>
                                <td> <?php echo $factura["IMPORTE"]; ?> </td>
                                <td> <?php echo $factura["TOTAL"]; ?> </td>
                                <td> <?php echo ($factura["PAGO"]==1) ? "Pagado" : "En Deuda" ?> </td>
                                <td> <a class="aSC"href="agendaGerente.php?idsc=<?php echo $factura["ID_SC"]?>"><?php echo $factura["ID_SC"]; ?></a> </td>
                                <td> <?php echo $factura["OBSERVACIONES"]; ?> </td>
                                <td>
                                    <a href="facturasGerente.php?nfactura=<?php echo $factura['NUMEROFACTURA'] ?>"><img src="../Imagenes/info.png" style="width:70%"></a>
                                </td>

                                <td><button id="bEditar" name="editar" type="submit" class="boton"> <img src="../Imagenes/editar.png" class="imgBoton"></button></td>
                                <td><button id="bBorrar" name="borrar" type="submit" class="boton"> <img src="../Imagenes/borrar.png" class="imgBoton"> </button></td>
                             
                            </tr>
                        </form>
                        
                    <?php } ?>
                </table>   
            </div>

        

    <?php } ?>    

</body>

</html>