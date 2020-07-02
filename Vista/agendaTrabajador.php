<?php

    session_start();

    require_once("../Gestiona/gestionBD.php");
    require_once("../Gestiona/gestionarServicios.php");

    //Comprobar que trabajador somos:
    $conexion = crearConexionBD();

    if(isset($_SESSION['DNI_CIF'])){
        $Trabajador = consultaTrabajadorConDNI($conexion,$_SESSION['DNI_CIF']);
        $OidTrabajador = $Trabajador['NUMEROTRABAJADOR'];
    }
    else{
    Header('Location: ../Vista/inicio.php');        
    }
    //Fin Comprobación

    if (isset($_SESSION["errores"])){
        $errores = $_SESSION["errores"];
        unset($_SESSION["errores"]);
    }

    if (isset($_REQUEST["ordenaFecha"])) {

        $fecha = $_REQUEST["ordenaFecha"];
        
        $servicios = consultarServiciosTrabajadorBuscarFecha($conexion,$OidTrabajador,$fecha);
    }
    else{

        if(isset($_REQUEST["orden"])){
        $ord = $_REQUEST["orden"];

        if($ord=='fechaAsc')
            $servicios = consultarServiciosTrabajadorFechaAsc($conexion,$OidTrabajador);
        elseif($ord=='DurDesc')
            $servicios = consultarServiciosTrabajadorDurDesc($conexion,$OidTrabajador);
        elseif($ord=='DurAsc')
            $servicios = consultarServiciosTrabajadorDurAsc($conexion,$OidTrabajador);
        else
            $servicios = consultarServiciosTrabajadorFechaDesc($conexion,$OidTrabajador);
    }
        else{
            $servicios = consultarServiciosTrabajadorFechaDesc($conexion,$OidTrabajador); 
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
    <link rel="stylesheet" type="text/css" href="../CSS/agendaGerente.css" />
    <title>DEDESIN S.L</title>
</head>

<body>
    <header>
    <?php include_once("../Cabeceras/cabeceraTrabajador.php"); ?>
    </header>
    <?php if (isset($errores) && count($errores)>0) { 
                echo "<div id=\"div_errores\" class=\"error\">";
                echo "<h4> Errores en el formulario:</h4>";
                foreach($errores as $error){
                    echo $error;
                } 
                echo "</div>";
            } ?>

    <h2>Servicios asignados a Trabajador con DNI: <?php echo $_SESSION['DNI_CIF'] ?> </h2>

    

    <div class="ordenar">
        <form action="agendaTrabajador.php">
            <h4>Ordenar por:</h4>
            <select name="orden">
                <option value="fechDesc">Fecha Descendiente</option>
                <option value="fechaAsc">Fecha Ascendiente</option>
                <option value="DurDesc">Duracion Descendiente</option>
                <option value="DurAsc">Duracion Ascendente</option>
            </select>
            <input type="submit" value="Ordenar">
        </form>

        <div>
            <form action="agendaTrabajador.php">
                <h4>Buscar Fecha:</h4>
                <input type="date" id="ordenaFecha" name="ordenaFecha">
                <input type="submit" value="Buscar"> 
            </form>
        </div> 
    </div>

    <br>    
    <div>
        <table border="2px" bgcolor="#F1EFEF">
            <tr>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Localización</th>
                <th>Duración</th>
                <th>Cliente</th>
                <th>Peligro</th>
                <th>Máscara</th>
                <th>Tratamiento</th>
                <th>Maquinas</th>
                <th>Materiales</th>
                <th>Servicios</th>
                <th>Plaga</th>
                <th>Observaciones</th>
                <th>Completado</th>
                <th style="width: 1em">Editar</th>
            </tr>
            <?php foreach ($servicios as $servicio) { ?>
                <?php
                    $conexion = CrearConexionBD(); 
                    $ID_T = consultarTratamientos($conexion,$servicio["ID_T"]);
                    cerrarConexionBD($conexion);
                ?>
                <form action="../Controlador/controlador_agenda.php">
                    <tr>
                        <input type="hidden" name="ServModTrab" value="true">
                        <input type="hidden" name="ID_SC" value="<?php echo $servicio['ID_SC']?>">

                        <td> <?php echo $servicio["FECHA"] ?> </td>
                        <td> <?php echo $servicio["HORA"] ?> </td>
                        <td> <?php echo $servicio["LUGAR"] ?> </td>
                        <td> <?php echo $servicio["DURACION"] ." horas"?> </td>
                        <td> <?php echo $servicio["NOMBRE"] ?> </td>
                        <td> <?php echo $ID_T["PELIGRO"] ?> </td>
                        <td> <?php echo $ID_T["MASCARA"] ?> </td>
                        <td> <?php echo $servicio["TIPOTRATAMIENTO"] ?> </td>
                        <td> <?php echo $servicio["TIPOMAQUINAS"] ?> </td>
                        <td> <?php echo $servicio["TIPOMATERIALES"] ?> </td>
                        <td> <?php echo $servicio["TIPOSERVICIOS"] ?> </td>
                        <td> <?php echo $servicio["TIPOPLAGAS"] ?> </td>
                        <td> <input type="text" name="OBSERVACIONES" value="<?php echo $servicio["OBSERVACIONES"]?>"> </td>
                        <td> 
                            <label><input name="COMPLETADO" type="radio" value="Si" <?php if($servicio['COMPLETADO']=='Si') echo ' checked '; ?>/>Si</label>
                            <label><input name="COMPLETADO" type="radio" value="No" <?php if($servicio['COMPLETADO']=='No') echo ' checked '; ?>/>No</label>
                        </td>
                        <td><button id="bEditar" name="editar" type="submit" class="boton"> <img src="../Imagenes/editar.png" class="imgBoton"></button></td>
                    </tr>
                </form>
            <?php } ?>  
        </table>
    </div>

        

    

</body>
</html>