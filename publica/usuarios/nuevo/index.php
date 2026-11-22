<?php
    session_start() ;
?><html >
    
<head>
    <title >Tu App</title>
    <meta name="viewport" content="width=device-width,user-scalable=no" />
    <meta charset="utf-8" />
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.css" />
    <style >[full]{ width: 100% }</style>
</head>

    <body >
        <header >
            <h1>Insertar un/a nuev@ usuarios</h1>
            <?php
                if( isset($_SESSION["mensaje"]) ):
                    printf( "<p id='idMarcaMensaje' >%s</p><script>setTimeout(x=>idMarcaMensaje.outerHTML='',3000)</script>", $_SESSION["mensaje"] ) ;
                    unset( $_SESSION["mensaje"] ); 
                endif;
                if( isset($_SESSION["error"]) ):
                    printf( "<p id='idMarcaError' >%s</p><script>setTimeout(x=>idMarcaError.outerHTML='',3000)</script>", $_SESSION["error"] ) ;
                    unset( $_SESSION["error"] ); 
                endif;
            ?>
            <nav >
                <button onclick="location.href=('/usuarios')">Volver</button>
            </nav>
        </header>
        <form action='/usuarios/nuevo/procesar.php' method="get" >
            
<article >
    <label for='id_nombre'>_nombre: </label><br>
	<input type="TEXT" id="id_nombre" name="nm_nombre"   required  />
</article>

<article >
    <label for='id_apellido'>_apellido: </label><br>
	<input type="TEXT" id="id_apellido" name="nm_apellido"   required  />
</article>

<article >
    <label for='id_email'>_email: </label><br>
	<input type="EMAIL" id="id_email" name="nm_email"   required  />
</article>

<article >
    <label for='id_clave'>_clave: </label><br>
	<input type="PASSWORD" id="id_clave" name="nm_clave"   required  />
</article>

<article >
    <label for='id_fechaRegistro'>_fechaRegistro: </label><br>
	<input type="DATETIME" id="id_fechaRegistro" name="nm_fechaRegistro"   value="CURRENT_TIMESTAMP"  />
</article>

            <input type="submit" value="Agregar nuevo ítem" />
        </form>
    </body>
</html>