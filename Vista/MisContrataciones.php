<?php 

session_start();

	require_once("../Gestiona/gestionBD.php");
	require_once("../Gestiona/gestionarContrataciones.php");
	require_once("../Paginacion/paginacion_contrataciones_gerente.php");

	
	
	$conexion = crearConexionBD();

    if(isset($_SESSION['DNI_CIF'])){
        $OidCliente = $_SESSION['DNI_CIF'];
    }
    else{
       Header('Location: ../Vista/inicio.php');
    }

    $contratacion = consultarContratacionesCliente($conexion,$OidCliente);

    cerrarConexionBD($conexion);
	?>
	
	
	<!DOCTYPE html>
<html lang="es">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../CSS/cabecera_cliente.css">
    <link rel="stylesheet" type="text/css" href="../CSS/pagPrincipal.css"/>
    <link rel="stylesheet" href="../CSS/pie.css">
    <title>DEDESIN S.L</title>
    </head>

<body>
	<header>
    <?php include_once("../Cabeceras/cabeceraCliente.php"); ?>
    </header>
    <div class="todmc">
    <h2 class="h2fg">Contrataciones realizadas por el Cliente <?php echo $OidCliente ?> </h1>
    <ul>

        <?php foreach($contratacion as $contrat) { ?>

        <li>Id_SC:                <?php echo $contrat["ID_SC"] ?> </li>
        <li>Fecha:                <?php echo $contrat["FECHA"] ?> </li>
        <li>Hora:                 <?php echo $contrat["HORA"] ?> </li>
        <li>Lugar:                <?php echo $contrat["LUGAR"] ?> </li>
        <li>Duracion:      		  <?php echo $contrat["DURACION"] ?> </li>
        <li>Observaciones:        <?php echo $contrat["OBSERVACIONES"] ?> </li>
        <li>DNI_CIF: 			  <?php echo $contrat["DNI_CIF"] ?> </li>
        <li>Numero de Factura:    <?php echo $contrat["NUMEROFACTURA"] ?> </li>
        <li>Numero de Trabajador: <?php echo $contrat["NUMEROTRABAJADOR"] ?> </li>
        <li>ID_T:                 <?php echo $contrat["ID_T"] ?> </li>
        <li>Completado:           <?php echo $contrat["COMPLETADO"] ?> </li>
        <li>Tipo de Tratamiento:  <?php echo $contrat["TIPOTRATAMIENTO"] ?> </li>
        <li>Tipo de Maquinas:     <?php echo $contrat["TIPOMAQUINAS"] ?> </li>
        <li>Tipo de Materiales:   <?php echo $contrat["TIPOMATERIALES"] ?> </li>
        <li>Tipo de Servicio:     <?php echo $contrat["TIPOSERVICIOS"] ?> </li>
        <li>Tipo de Plaga:        <?php echo $contrat["TIPOPLAGAS"] ?> </li><br><br>
        
        <?php } ?>
        
    </ul>
	</div>
	<?php include_once("pie.php"); ?>
	
</body>

</html>