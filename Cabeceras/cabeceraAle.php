	<header>
		<form class="salir" name ="salir" action="inicio.php" method="GET">
			<input type="submit" name="salirA" value="Cerrar cesión">
		</form>
		<h1> <b>DEDESIN S.L</b> </h1>

		<ul class="topnav">
				<li><a href="pagPrincipal.php">DEDESIN S.L </a></li>
			<li><a href="#">Contrataciones</a></li>
			<li><a href="#">Agenda</a></li>
			<li><a href="#">Mis facturas</a></li>
			<?php if($tipoUsuario == "Cliente"){?>
			<li><a href="misDatosCliente.php">Mis datos</a></li>
	<?php  }

	if($tipoUsuario == "Trabajador"){?>
	<li><a href="misDatosTrabajador.php">Mis datos</a></li>
	<?php  
	}
	
	if($tipoUsuario == "Gerente"){?>
	<li><a href="misDatosGerente.php">Mis datos</a></li>
	<?php } ?>
			
		  </ul>
		
	</header>