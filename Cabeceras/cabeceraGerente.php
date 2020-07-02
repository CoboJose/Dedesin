<style>
*{
	margin: 0px;
	padding: 0px;
}
header{
	background-color: #00FF7F;
	opacity:0.6;
	display: flex;
	flex-direction: row;
	justify-content: flex-start;
}

.col-1{width: 70%;}
.col-2{width: 50%;}
.col-3{width: 50%;}
.col-4{width: 50%;}
.col-5{width: 50%;}
.col-6{width: 50%;}
.columnas{
	flex: 25%;
	flex-grow: 6;
	display: inline-flex;
	height: 50px;
	width: 100%;
	background-size: cover;
	font-size: large;
	padding-top: 15px;
}
.logo {
	float: left;
    width: 30%;
    height: 99%;
    display: flex;
	flex-direction: row;
	justify-content: flex-start;
	margin-left: 10%;
	margin-top: -4%;
	}
	a{
		margin-top: 10%;
		text-decoration: none;
		

	}
</style>


<div class="columnas">
	<div class="col-1"><img src="../Imagenes/LogoPag.png" class="logo"></div>
	<div class="col-2"><a href="../Vista/agendaGerente.php">Agenda</a></div>
	<div class="col-3"><a href="../Vista/facturasGerente.php">Facturas</a></div>
	<div class="col-4"><a href="../Vista/vehiculosGerente.php">Vehiculos</a></div>
	<div class="col-5"><a href="../Vista/servicionNoContratadosGerente.php">Servicios</a></div>
	<div class="col-6"><a href="../Vista/cuentaGerente.php">Cuenta</a></div>
</div>