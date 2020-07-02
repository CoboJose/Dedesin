<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../CSS/inicio.css">
    <title>DEDESIN S.L</title>
</head>
<body>
	<? if(isset($_SESSION["DNI_CIF"])){
		unset($_SESSION["DNI_CIF"]);
		unset($_SESSION["TipoUsuario"]);
	}
	?>
    <header class="head">
       
        <div class="titulo"> <h1 id="titulo" >DEDESIN S.L</h1></div>
        
        <div class="w">
            <div class="btn"> <button type="button"> <a href="LogIn.php">Log In</a></button> </div>
            <div class="btns"> <button type="button"> <a href="form_alta_usuario.php">Sign Up</a></button> </div>
        </div>
        
    </header>
    <div class="whoiam">
    <h2> ¿Quiénes somos? </h2>
    
    <article id="descripcion1"><p>
    Somos una empresa andaluza, con sede en Sevilla y desarrollamos nuestra actividad en el campo del Control Medioambiental desde hace más de 40 años. A lo largo de los años hemos logrado constituirnos como empresa líder, precursora, reconocida y motor del desarrollo en el sector.

    </p></article>
    <article id="descripcion2">
        <p>
       En Dedesin, S.L. desarrollamos nuestros servicios bajo la premisa de una completa filosofía y código deontológico de trabajo. Contamos con las más novedosas técnicas en diagnosis, seguimiento y control del sector. Consolidados como un referente indiscutible en nuestra actividad, nos caracterizamos por utilizar siempre productos de calidad y contar con un personal profesional, cualificado y formado de forma precisa, para el desarrollo de su actividad laboral.
        </p>
    </article>
</div>
</body>
</html>