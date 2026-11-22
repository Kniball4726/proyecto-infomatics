<?php
    session_start() ;
?><html >
    
<head>
    <title >InfoMatics</title>
    <meta name="viewport" content="width=device-width,user-scalable=no" />
    <meta charset="utf-8" />
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.css" />
    <style >[full]{ width: 100% }</style>
</head>

    <body >
        <header >
            <h1>Insertar un/a nuev@ carrito</h1>
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
                <button onclick="location.href=('/carrito')">Volver</button>
            </nav>
        </header>
        <form action='/carrito/nuevo/procesar.php' method="get" >
            
<article >
    <label for='id_idUsuario'>_idUsuario: </label><br>
	<input type="number" id="id_idUsuario" name="nm_idUsuario" required />
</article>

<article >
    <label for='id_idProducto'>_idProducto: </label><br>
	<input type="number" id="id_idProducto" name="nm_idProducto" required />
</article>

<article >
    <label for='id_cantidad'>_cantidad: </label><br>
	<input type="number" id="id_cantidad" name="nm_cantidad" value="1" required />
</article>

            <input type="submit" value="Agregar nuevo ítem" />
        </form>
    </body>
</html>
