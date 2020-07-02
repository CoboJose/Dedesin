<?php

    session_start();

    require_once("../Gestiona/gestionBD.php");
    require_once("../Gestiona/gestionarServicios.php");
    require_once("../Gestiona/paginacion.php");

   if(!isset($_SESSION['DNI_CIF'])){
       Header('Location: ../Vista/inicio.php');
    }

    if (isset($_SESSION["errores"])){
        $errores = $_SESSION["errores"];
        unset($_SESSION["errores"]);
    }
    
    // Ver o modificar:
    if(isset($_SESSION["ServModGerent"])){
            $servMod = $_SESSION["ServModGerent"];
            unset($_SESSION["ServModGerent"]);
    }

    //Paginacion:
    if (isset($_SESSION["paginacion"])) $paginacion = $_SESSION["paginacion"];

    $pagina_seleccionada = isset($_GET["PAG_NUM"]) ? (int)$_GET["PAG_NUM"] : (isset($paginacion) ? (int)$paginacion["PAG_NUM"] : 1);
    $pag_tam = isset($_GET["PAG_TAM"]) ? (int)$_GET["PAG_TAM"] : (isset($paginacion) ? (int)$paginacion["PAG_TAM"] : 5);

    if ($pagina_seleccionada < 1) $pagina_seleccionada = 1;
    if ($pag_tam < 1) $pag_tam = 5;

    unset($_SESSION["paginacion"]); 

    $conexion = crearConexionBD();

    if (isset($_REQUEST["buscaFecha"])) {

        $fecha = date('d/m/Y', strtotime($_REQUEST["buscaFecha"]));
        
        $query = "SELECT SERVICIOSCONTRATADOS.*,FACTURAS.STATUS,CLIENTES.NOMBRE 
                 FROM SERVICIOSCONTRATADOS,FACTURAS,CLIENTES 
                 WHERE SERVICIOSCONTRATADOS.NUMEROFACTURA = FACTURAS.NUMEROFACTURA 
                 AND SERVICIOSCONTRATADOS.DNI_CIF = CLIENTES.DNI_CIF
                 AND SERVICIOSCONTRATADOS.FECHA = '$fecha' " ;
    }
    elseif(isset($_REQUEST["buscaCliente"])){

        $cliente = $_REQUEST["buscaCliente"];

        $query = "SELECT SERVICIOSCONTRATADOS.*,FACTURAS.STATUS,CLIENTES.NOMBRE 
                 FROM SERVICIOSCONTRATADOS,FACTURAS,CLIENTES 
                 WHERE SERVICIOSCONTRATADOS.NUMEROFACTURA = FACTURAS.NUMEROFACTURA 
                 AND SERVICIOSCONTRATADOS.DNI_CIF = CLIENTES.DNI_CIF
                 AND NOMBRE = '$cliente'
                 ORDER BY SERVICIOSCONTRATADOS.FECHA DESC" ;
    }
    elseif(isset($_REQUEST["idsc"])){
        //Si venimos desde facturasGerente
        $idsc = $_REQUEST["idsc"];
        $query = "SELECT SERVICIOSCONTRATADOS.*,FACTURAS.STATUS,CLIENTES.NOMBRE 
                 FROM SERVICIOSCONTRATADOS,FACTURAS,CLIENTES 
                 WHERE SERVICIOSCONTRATADOS.NUMEROFACTURA = FACTURAS.NUMEROFACTURA 
                 AND SERVICIOSCONTRATADOS.DNI_CIF = CLIENTES.DNI_CIF
                 AND SERVICIOSCONTRATADOS.ID_SC = '$idsc' " ;
    }
    else{
        
        $query = "SELECT SERVICIOSCONTRATADOS.*,FACTURAS.STATUS,CLIENTES.NOMBRE 
                 FROM SERVICIOSCONTRATADOS,FACTURAS,CLIENTES 
                 WHERE SERVICIOSCONTRATADOS.NUMEROFACTURA = FACTURAS.NUMEROFACTURA 
                 AND SERVICIOSCONTRATADOS.DNI_CIF = CLIENTES.DNI_CIF
                 ORDER BY SERVICIOSCONTRATADOS.FECHA DESC" ;
    }

    $total_registros = total_consulta($conexion, $query);
    $total_paginas = (int)($total_registros / $pag_tam);

    if ($total_registros % $pag_tam > 0) $total_paginas++;
    if ($pagina_seleccionada > $total_paginas) $pagina_seleccionada = $total_paginas;

    $paginacion["PAG_NUM"] = $pagina_seleccionada;
    $paginacion["PAG_TAM"] = $pag_tam;
    $_SESSION["paginacion"] = $paginacion;

    $servicios = consulta_paginada($conexion, $query, $pagina_seleccionada, $pag_tam);

    cerrarConexionBD($conexion);

    //Fin Paginación

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" type="text/css" href="../CSS/agendaGerente.css" />
    <link rel="stylesheet" href="../CSS/cabecera_gerente.css">
    <script src="https://code.jquery.com/jquery-3.4.1.js" type="text/javascript"></script>
	<script src="../JS/validacion_servicio_contratado.js" type="text/javascript"></script>
    <title>DEDESIN S.L</title>
</head>

<body>
	<script>
		$(document).ready(function() {
			$("#editarServicio").on("submit", function() {
				return validateForm();
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
    <header>
    <?php include_once("../Cabeceras/cabeceraGerenteTablas.php"); ?>
    </header>
    <!-- Editando Servicio -->
    <?php if (isset($servMod)) { ?>

        <?php if (isset($errores) && count($errores)>0) { 
                echo "<div id=\"div_errores\" class=\"error\">";
                echo "<h4> Errores en el formulario:</h4>";
                foreach($errores as $error){
                    echo $error;
                } 
                echo "</div>";
            } ?>
    

        <div>
            <form id="editarServicio" method="POST" action="../Controlador/controlador_agenda.php">
                
                <input type="hidden" name="ServModGerent" value="true">
                <input id="NOMBRE" name="NOMBRE" type="hidden" value="<?php echo $servMod['NOMBRE'] ?>" required/>
                <input id="ID_SC" name="ID_SC" type="hidden" value="<?php echo $servMod['ID_SC'];?>"/>

                <div id="datosEdit">
                <p>Cliente: <?php echo $servMod["NOMBRE"]; ?></p>  
                <p>Fecha: <?php echo $servMod["FECHA"]; ?></p> <br><br>
                </div>

                <div id="formEdit">
                    <label for="FECHA">Fecha:</label>
                    <input id="FECHA" name="FECHA" type="date" value="2020-06-12" pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])" required/> <br>
                    <label for="HORA">Hora:</label>
                    <input id="HORA" name="HORA" type="text" value="<?php echo $servMod['HORA'] ?>" placeholder="HH:mm" pattern="([01][0-9]|2[0-3]|[1-9]):[0-5][0-9]" required/> <br>
                    <label for="LUGAR">Lugar:</label>
                    <input id="LUGAR" name="LUGAR" type="text" value="<?php echo $servMod['LUGAR'] ?>" required/> <br>
                    <label for="DURACION">Duración (Horas):</label>
                    <input id="DURACION" name="DURACION" type="text" value="<?php echo $servMod['DURACION'] ?>" pattern="([0-9]|[1-9][0-9]),([0-9]|[0-9]{2})"required/> <br>

                    <label for="NUMEROTRABAJADOR">Trabajador asignado:</label>
                    <input list="OpcNUMEROTRABAJADOR" name="NUMEROTRABAJADOR" id="NUMEROTRABAJADOR" value="<?php echo $servMod['NUMEROTRABAJADOR'] ?>" pattern="([0-9]|[1-9][0-9])" required>
                    <datalist id="OpcNUMEROTRABAJADOR">
                        
                        <?php
                            $conexion = crearConexionBD();
                            $trabajadores = listarTrabajadores($conexion);
                            cerrarConexionBD($conexion);

                            foreach($trabajadores as $trabajador) {
                                echo "<option value='".$trabajador["NUMEROTRABAJADOR"]."'>".$trabajador["NOMBRE"]."</option>";
                            }
                        ?>
                    </datalist> <br>

                    <label for="TIPOTRATAMIENTO">Tratamientos:</label>
                    <input id="TIPOTRATAMIENTO" name="TIPOTRATAMIENTO" type="text" value="<?php echo $servMod['TIPOTRATAMIENTO'] ?>" required/> <br>
                    <label for="TIPOMAQUINAS">Maquinas:</label>
                    <input id="TIPOMAQUINAS" name="TIPOMAQUINAS" type="text" value="<?php echo $servMod['TIPOMAQUINAS'] ?>" required/> <br>
                    <label for="TIPOMATERIALES">Materiales:</label>
                    <input id="TIPOMATERIALES" name="TIPOMATERIALES" type="text" value="<?php echo $servMod['TIPOMATERIALES'] ?>" required/> <br>
                    <label for="TIPOSERVICIOS">Servicios:</label>
                    <input id="TIPOSERVICIOS" name="TIPOSERVICIOS" type="text" value="<?php echo $servMod['TIPOSERVICIOS'] ?>" required/> <br>
                    <label for="TIPOPLAGAS">Plagas:</label>
                    <input id="TIPOPLAGAS" name="TIPOPLAGAS" type="text" value="<?php echo $servMod['TIPOPLAGAS'] ?>" required/> <br>
                    <label for="OBSERVACIONES">Observaciones:</label>
                    <input id="OBSERVACIONES" name="OBSERVACIONES" type="text" value="<?php echo $servMod['OBSERVACIONES'] ?>" required/> <br>

                    <a>Completado: </a>
                    <label><input name="COMPLETADO" type="radio" value="Si" <?php if($servMod['COMPLETADO']=='Si') echo ' checked '; ?>/>Si</label>
                    <label><input name="COMPLETADO" type="radio" value="No" <?php if($servMod['COMPLETADO']=='No') echo ' checked '; ?>/>No</label>
                </div>

                <br>
                <button id="bNuevo" name="grabar" type="submit" class="boton2"> <img src="../Imagenes/editar.png" class="imgBoton"> </button>

            </form>

            <a href="agendaGerente.php"><button>Volver</button></a>

        </div>

    <!-- Viendo Servicios -->
    <?php } else { ?>    

        <h2>Servicios</h2>

        <br>    

        <div class="ordenar">
            <div class="orFecha">
                <form action="agendaGerente.php" id="oFecha">
                    <a>Buscar Fecha: </a>
                    <input type="date" id="buscaFecha" name="buscaFecha">
                    <input type="submit" value="Buscar"> 
                </form>
            </div>
            <div class="orCliente">
                <form action="agendaGerente.php" id="oCliente">
                    <a>Buscar Cliente: </a>
                    <input type="text" id="buscaCliente" name="buscaCliente">
                    <input type="submit" value="Buscar"> 
                </form>
            </div>  <br>
        <div class="todos">
        <a href="agendaGerente.php"><button id="oTodos">Todos</button></a> <br><br>
        </div>
        </div>
        <!-- Paginacion -->
        <nav id="nav">

            <div id="enlaces">

                <?php

                    for( $pagina = 1; $pagina <= $total_paginas; $pagina++ )

                        if ( $pagina == $pagina_seleccionada) {     ?>

                            <span class="current"><?php echo $pagina; ?></span>

                <?php } else { ?>

                            <a href="agendaGerente.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>

                <?php } ?>

            </div>



            <form method="get" action="agendaGerente.php">

                <input id="PAG_NUM" name="PAG_NUM" type="hidden" value="<?php echo $pagina_seleccionada?>"/>

                Mostrando

                <input id="PAG_TAM" name="PAG_TAM" type="number"

                    min="1" max="<?php echo $total_registros; ?>"

                    value="<?php echo $pag_tam?>" autofocus="autofocus" />

                entradas de <?php echo $total_registros?>

                <input type="submit" value="Cambiar">

            </form>

        </nav>
        <!-- Fin Paginacion -->

        <div>
            <table border="2px" bgcolor="#F1EFEF">
                <tr>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Localización</th>
                    <th>Duración</th>
                    <th>Cliente</th> 
                    <th>DNI Cliente</th>
                    <th>Factura</th>
                    <th>Estado</th>
                    <th>Trabajador</th>
                    <th>Observaciones</th>
                    <th>Completado</th>
                    <th style="width: 1em">Editar</th>
                    <th style="width: 1em">Eliminar</th>
                </tr>
                <?php foreach ($servicios as $servicio) { ?>
                    <?php
                        $conexion = CrearConexionBD(); 
                        $ID_T = consultarTratamientos($conexion,$servicio["ID_T"]);
                        $trabajador = consultarTrabajadorServicio($conexion,$servicio["NUMEROTRABAJADOR"]);
                        cerrarConexionBD($conexion);
                    ?>
                    <form action="../Controlador/controlador_agenda.php">
                        <tr class="columnas">
                            <input type="hidden" name="ServModGerent" value="true">
                            <input type="hidden" name="ID_SC" value="<?php echo $servicio['ID_SC']?>">
                            <input type="hidden" name="NOMBRE" value="<?php echo $servicio['NOMBRE']?>">
                            <input type="hidden" name="FECHA" value="<?php echo $servicio['FECHA']?>">
                            <input type="hidden" name="HORA" value="<?php echo $servicio['HORA']?>">
                            <input type="hidden" name="LUGAR" value="<?php echo $servicio['LUGAR']?>">
                            <input type="hidden" name="DURACION" value="<?php echo $servicio['DURACION']?>">
                            <input type="hidden" name="NUMEROTRABAJADOR" value="<?php echo $servicio['NUMEROTRABAJADOR']?>">
                            <input type="hidden" name="OBSERVACIONES" value="<?php echo $servicio['OBSERVACIONES']?>">
                            <input type="hidden" name="COMPLETADO" value="<?php echo $servicio['COMPLETADO']?>">
                            <input type="hidden" name="TIPOTRATAMIENTO" value="<?php echo $servicio['TIPOTRATAMIENTO']?>">
                            <input type="hidden" name="TIPOMAQUINAS" value="<?php echo $servicio['TIPOMAQUINAS']?>">
                            <input type="hidden" name="TIPOMATERIALES" value="<?php echo $servicio['TIPOMATERIALES']?>">
                            <input type="hidden" name="TIPOSERVICIOS" value="<?php echo $servicio['TIPOSERVICIOS']?>">
                            <input type="hidden" name="TIPOPLAGAS" value="<?php echo $servicio['TIPOPLAGAS']?>">

                            <td> <?php echo $servicio["FECHA"] ?> </td>
                            <td> <?php echo $servicio["HORA"] ?> </td>
                            <td> <?php echo $servicio["LUGAR"] ?> </td>
                            <td> <?php echo $servicio["DURACION"] ." horas" ?> </td>
                            <td> <?php echo $servicio["NOMBRE"] ?> </td>
                            <td> <?php echo $servicio["DNI_CIF"] ?> </td>
                            <td> 
                                <a href="facturasGerente.php?nfactura=<?php echo $servicio['NUMEROFACTURA'] ?>" target="_blanck">
                                <?php echo $servicio["NUMEROFACTURA"] ?></a> 
                            </td>
                            <td> <?php echo $servicio["STATUS"] ?> </td>
                            <td> <?php echo $trabajador["NOMBRE"] ?> </td>
                            <td> <?php echo $servicio["OBSERVACIONES"]?> </td>
                            <td> <?php echo $servicio["COMPLETADO"]?> </td>

                            <td><button id="bEditar" name="editar" type="submit" class="boton"> <img src="../Imagenes/editar.png" class="imgBoton"></button></td>
                            <td><button id="bBorrar" name="borrar" type="submit" class="boton"> <img src="../Imagenes/borrar.png" class="imgBoton"> </button></td>
                        </tr>
                    </form>
                <?php } ?>  
                  
            </table>
        </div>

        <br>

        <div id="nuevoServicio">
        <a id="nVeh">Nuevo Servicio:</a> <a href="servicionNoContratadosGerente.php"><img src="../Imagenes/new.png" width="2%"></a>
        </div>


    <?php } ?>    

</body>
</html>                    