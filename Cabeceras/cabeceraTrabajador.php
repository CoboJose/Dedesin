<style>
*{
	margin: 0px;
	padding: 0px;
}
header{
	background-color: #00FF7F;
	opacity:0.6
}
a{
	color: black;

}

.col-1{width: 70%;}
.col-2{width: 50%;}
.col-3{width: 50%;}
.col-4{width: 50%;}

.columnas{
	flex: 25%;
	flex-grow: 6;
	display: inline-flex;
	height: 50px;
	width: 100%;
	margin: 1%;
	margin-top: 2%;
	background-size: cover;
	font-size: large;
}
.logo {
	float: left;
    width: 30%;
    height: 99%;
    display: flex;
	flex-direction: row;
	justify-content: flex-start;
	margin-left: 10%;
	}
	a{
		margin-top: 6%;
		text-decoration: none;
		

	}
</style>


<div class="columnas">
	<div class="col-1"><img src="../Imagenes/LogoPag.png" class="logo"></div>
	<div class="col-2"><a href="../Vista/agendaTrabajador.php">Agenda</a></div>
	<div class="col-3"><a href="../Vista/vehiculosTrabajador.php">Vehiculos</a></div>
	<div class="col-4"><a href="../Vista/cuentaTrabajador.php">Cuenta</a></div>
</div>
        

