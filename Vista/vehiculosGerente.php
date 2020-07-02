<?php
    session_start();

    require_once ("../Gestiona/gestionBD.php");
    require_once ("../Gestiona/gestionarVehiculos.php");
    if(!isset($_SESSION['DNI_CIF'])){
       Header('Location: ../Vista/inicio.php');
    }
    else{

    if (isset($_SESSION["errores"])){
        $errores = $_SESSION["errores"];
        unset($_SESSION["errores"]);
    }

    if(isset($_SESSION["vehicMod"])){
            $vehicMod = $_SESSION["vehicMod"];
            unset($_SESSION["vehicMod"]);
    }
    if (isset($_SESSION["vehicNuevo"])){
        $vehicNuevo = $_SESSION["vehicNuevo"];
        unset($_SESSION["vehicNuevo"]);
    }
    elseif (isset($_SESSION["vehicNuevo"])) {
        $vehicNuevo = $_SESSION["vehicNuevo"];
        unset($_SESSION["vehicNuevo"]);
    }

    $conexion = crearConexionBD();

    $filas = consultarVehiculosGerente($conexion);
    }

    cerrarConexionBD($conexion);
?>
    
<!DOCTYPE html>
<html lang="es">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="../CSS/vehiculosGerente.css" />
    <script src="https://code.jquery.com/jquery-3.4.1.js" type="text/javascript"></script>
	<script src="../JS/validacion_modificar_vehiculo.js" type="text/javascript"></script>

    <title>DEDESIN S.L</title>
    </head>

<body>
	<script>
		$(document).ready(function() {
			$("#modificarVehiculo").on("submit", function() {
				return validateModificarDatosVehiculo();
			});
			$("#nuevoVehiculo").on("submit", function() {
				return validateCrearVehiculo();
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
    <?php include_once("../Cabeceras/cabeceraGerente.php"); ?>
</header>
    <h1> Vehículos </h1>

    <!-- Si pulsamos sobre modificar vehiculo entramos aquí -->
    <?php if(isset($vehicMod)){ ?>

        <div class="modVehic">
            <?php if (isset($errores) && count($errores)>0) { 
                echo "<div id=\"div_errores\" class=\"error\">";
                echo "<h4> Errores en el formulario:</h4>";
                foreach($errores as $error){
                    echo $error;
                } 
                echo "</div>";
            } ?>
        
        <form id="modificarVehiculo" method="GET" action="../Controlador/controlador_vehiculos.php">
            
            <input id="Matricula" name="Matricula" type="hidden" pattern="/^([A-Z]{2} [0-9]{4} [A-Z]{2})|([0-9]{4} [A-Z]{3})$/" value="<?php echo $vehicMod['Matricula'];?>"/> <br>
            <div id="datosVehicMod">
                Matricula: <?php echo $vehicMod['Matricula'];?>
                Modelo: <?php echo $vehicMod['Modelo'] ?> <br>
                Número de Bastidor: <?php echo $vehicMod['NumBastidor'] ?> <br>
                Trabajador: <?php echo $vehicMod['Trabajador'] ?> <br>
                Fecha ITV: <?php echo $vehicMod['ITV'] ?><br>
                Fecha Seguro: <?php echo $vehicMod['Seguro'] ?> <br><br>
            </div>
            <div id="formVehicMod">
            <label for="KmTotales">KmTotales:</label>
            <input id="KmTotales" name="KmTotales" type="number" value="<?php echo $vehicMod['KmTotales'] ?>" required/> <br>

            <label for="ITV">Fecha ITV:</label>
            <input id="ITV" name="ITV" type="date" value="2020-06-12" required/> <br> 

            <label for="Seguro">Fecha Seguro:</label>
            <input id="Seguro" name="Seguro" type="date" value="2020-05-08" required/> <br>

            <label for="NumTrabajador">Trabajador asignado:</label>
            <input list="OpcNumTrabajador" type="number" name="NumTrabajador" id="NumTrabajador" value="<?php echo $vehicMod['NumTrabajador'] ?>" required>
            <datalist id="OpcNumTrabajador">
                    
                <?php
                    $conexion = crearConexionBD();
                    $trabajadores = listarTrabajadores($conexion);
                    cerrarConexionBD($conexion);

                    foreach($trabajadores as $trabajador) {
                        echo "<option value='".$trabajador["NUMEROTRABAJADOR"]."'>".$trabajador["NOMBRE"]."</option>";
                    }
                ?>
            </datalist>
            </div>
            
            <br>            
            <button id="bGrabar" name="grabar" type="submit" class="boton"> <img src="../Imagenes/editar.png" class="imgBoton"> </button>

        </form>    

        <a href="vehiculosGerente.php"><button>Volver</button></a>
        </div>
    
    <!-- Si pulsamos sobre crear nuevo vehiculo entramos aquí -->
    <?php }elseif (isset($vehicNuevo)) { ?>
        
        <h1>Crear nuevo Vehículo</h1>

        <?php if (isset($errores) && count($errores)>0) { 
                echo "<div id=\"div_errores\" class=\"error\">";
                echo "<h4> Errores en el formulario:</h4>";
                foreach($errores as $error){
                    echo $error;
                } 
                echo "</div>";
            } ?>

        <form id="nuevoVehiculo" method="GET" action="../Accion/accion_nuevo_vehiculo.php">
            <fieldset><legend>Datos nuevo vehículo</legend> <br>

                <div><label for="Matricula">Matrícula:</label>
                <input id="Matricula" name="Matricula" type="text" placeholder="XX 0000 XX" value="<?php echo $vehicNuevo['Matricula'] ?>" required/>
                </div>

                <div><label for="Modelo">Modelo:</label>
                <input id="Modelo" name="Modelo" type="text" placeholder="Marca Modelo" value="<?php echo $vehicNuevo['Modelo'] ?>"required/>
                </div>

                <div><label for="KmTotales">Kilómetros totales:</label>
                <input id="KmTotales" name="KmTotales" type="number" placeholder="10000" value="<?php echo $vehicNuevo['KmTotales'] ?>"required/>
                </div>

                <div><label for="NumBastidor">Número de Bastidor:</label>
                <input id="NumBastidor" name="NumBastidor" type="text" placeholder="XXXXX0XX0X000000" value="<?php echo $vehicNuevo['NumBastidor'] ?>"required/>
                </div>

                <div><label for="ITV">Fecha ITV:</label>
                <input id="ITV" name="ITV" type="date" placeholder="dd/mm/yyyy" value="2020-06-12" required/>
                </div>

                <div><label for="Seguro">Fecha seguro:</label>
                <input id="Seguro" name="Seguro" type="date" placeholder="dd/mm/yyyy" value="2020-05-08" required/>
                </div>

                <div><label for="NumTrabajador">Trabajador asignado:</label>
                <input list="OpcNumTrabajador" name="NumTrabajador" type="number" id="NumTrabajador" value="<?php echo $vehicNuevo['NumTrabajador'] ?>" required>
                <datalist id="OpcNumTrabajador">
                    
                    <?php
                        $trabajadores = listarTrabajadores($conexion);

                        foreach($trabajadores as $trabajador) {
                            echo "<option value='".$trabajador["NUMEROTRABAJADOR"]."'>".$trabajador["NOMBRE"]."</option>";
                        }
                    ?>
                </datalist>
                </div>

            </fieldset>    

            <button id="bNuevo" name="grabar" type="submit" class="boton"> <img src="../Imagenes/new.png" class="imgBoton"> </button>

        </form>

        <button><a href="vehiculosGerente.php">Volver</a></button>

    <!-- En caso contrario-->
    <?php } else{ ?>

        
            
        <div id="nuevoVehiculo">
        <a id="nVeh">Nuevo vehiculo:</a> <a class="anv" href="../Controlador/controlador_vehiculos.php?vehicNuevo=true"><img src="../Imagenes/new.png" width="2%"></a>        
        </div>
        

            <?php $cont = 1; ?>

            <?php foreach($filas as $fila) { ?>

            <?php $trabajador = consultarTrabajadorVehiculo($conexion,$fila["MATRICULA"]); ?>

            
            <?php if($cont%2==0){ ?>

                <div class="VehiculosPar">
                
                <form method="GET" action="../Controlador/controlador_vehiculos.php">
                        
                    <input id="Matricula" name="Matricula" type="hidden" value="<?php echo $fila["MATRICULA"]; ?>"/>
                    <input id="Modelo" name="Modelo" type="hidden" value="<?php echo $fila["MARCAMODELO"]; ?>"/>
                    <input id="KmTotales" name="KmTotales" type="hidden" value="<?php echo $fila["KMTOTALES"]; ?>"/>
                    <input id="NumBastidor" name="NumBastidor" type="hidden" value="<?php echo $fila["NUMBASTIDOR"]; ?>"/>
                    <input id="ITV" name="ITV" type="hidden" value="<?php echo $fila["FECHAPROXITV"]; ?>"/>
                    <input id="Seguro" name="Seguro" type="hidden" value="<?php echo $fila["FECHAEXPSEGURO"]; ?>"/>
                    <input id="Trabajador" name="Trabajador" type="hidden" value="<?php echo $trabajador["NOMBRE"]; ?>"/>
                    <input id="NumTrabajador" name="NumTrabajador" type="hidden" value="<?php echo $trabajador["NUMEROTRABAJADOR"]; ?>"/>

                    <h2 id="numVehic">Vehículo <?php echo $cont; $cont = $cont+1 ?> </h2> 

                    <button id="bEditar" name="editar" type="submit" class="boton"> <img src="../Imagenes/editar.png" class="imgBoton"> </button>
                    <button id="bBorrar" name="borrar" type="submit" class="boton"> <img src="../Imagenes/borrar.png" class="imgBoton"> </button>

                    <ul>
                        <li>Matrícula:               <?php echo $fila["MATRICULA"] ?> </li>
                        <li>Modelo:                  <?php echo $fila["MARCAMODELO"] ?> </li>
                        <li>Km totales:              <?php echo $fila["KMTOTALES"] ?> </li>
                        <li>Número de bastidor:      <?php echo $fila["NUMBASTIDOR"] ?> </li>
                        <li>Fecha Próxima ITV:       <?php echo $fila["FECHAPROXITV"] ?> </li>
                        <li>Fecha Expiración seguro: <?php echo $fila["FECHAEXPSEGURO"] ?> </li>
                        <li>Trabajador:              <?php echo $trabajador["NOMBRE"] ?> </li>
                    </ul>

                </form>
                </div>

            <?php }else{ ?>

                <div class="VehiculosImpar">
                
                <form method="GET" action="../Controlador/controlador_vehiculos.php">
                        
                    <input id="Matricula" name="Matricula" type="hidden" value="<?php echo $fila["MATRICULA"]; ?>"/>
                    <input id="Modelo" name="Modelo" type="hidden" value="<?php echo $fila["MARCAMODELO"]; ?>"/>
                    <input id="KmTotales" name="KmTotales" type="hidden" value="<?php echo $fila["KMTOTALES"]; ?>"/>
                    <input id="NumBastidor" name="NumBastidor" type="hidden" value="<?php echo $fila["NUMBASTIDOR"]; ?>"/>
                    <input id="ITV" name="ITV" type="hidden" value="<?php echo $fila["FECHAPROXITV"]; ?>"/>
                    <input id="Seguro" name="Seguro" type="hidden" value="<?php echo $fila["FECHAEXPSEGURO"]; ?>"/>
                    <input id="Trabajador" name="Trabajador" type="hidden" value="<?php echo $trabajador["NOMBRE"]; ?>"/>
                    <input id="NumTrabajador" name="NumTrabajador" type="hidden" value="<?php echo $trabajador["NUMEROTRABAJADOR"]; ?>"/>

                    <h2 id="numVehic">Vehículo <?php echo $cont; $cont = $cont+1 ?> </h2> 

                    <button id="bEditar" name="editar" type="submit" class="boton"> <img src="../Imagenes/editar.png" class="imgBoton"> </button>
                    <button id="bBorrar" name="borrar" type="submit" class="boton"> <img src="../Imagenes/borrar.png" class="imgBoton"> </button>

                    <ul>
                        <li>Matrícula:               <?php echo $fila["MATRICULA"] ?> </li>
                        <li>Modelo:                  <?php echo $fila["MARCAMODELO"] ?> </li>
                        <li>Km totales:              <?php echo $fila["KMTOTALES"] ?> </li>
                        <li>Número de bastidor:      <?php echo $fila["NUMBASTIDOR"] ?> </li>
                        <li>Fecha Próxima ITV:       <?php echo $fila["FECHAPROXITV"] ?> </li>
                        <li>Fecha Expiración seguro: <?php echo $fila["FECHAEXPSEGURO"] ?> </li>
                        <li>Trabajador:              <?php echo $trabajador["NOMBRE"] ?> </li>
                    </ul>

                </form>
                </div>

            <?php } ?>

            

        <br><br>

        <?php } ?> 
    
    <?php } ?>

    
</body>

</html>