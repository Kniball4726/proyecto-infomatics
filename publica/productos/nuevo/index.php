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
            <h1>Insertar un/a nuev@ productos</h1>
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
                <button onclick="location.href=('/productos')">Volver</button>
            </nav>
        </header>
        <form action='/productos/nuevo/procesar.php' method="get" >
            
<article >
    <label for='id_nombre'>_nombre: </label><br>
	<input type="TEXT" id="id_nombre" name="nm_nombre"   required  />
</article>

<article >
    <label for='id_descripcion'>_descripcion: </label><br>
	<textarea id="id_descripcion" name="nm_descripcion"   ></textarea>

</article>

<article >
    <label for='id_categoria'>_categoria: </label><br>
	<input type="TEXT" id="id_categoria" name="nm_categoria"   required  />
</article>

<article >
    <label for='id_precio'>_precio: </label><br>
	<input type="number" id="id_precio" name="nm_precio" step="0.00001"   required  />

</article>

<article >
    <label for='id_stock'>_stock: </label><br>
	<input type="number" id="id_stock" name="nm_stock"  required  value="0"  />

</article>

<article >
    <label for='id_imagen'>_imagen: </label><br>
	<input type="URL" id="id_imagen" name="nm_imagen"   />
</article>

<article >
    <label for='id_activo'>_activo: </label><br>
	<input type="number" id="id_activo" name="nm_activo"  value="1"  />

</article>

            <input type="submit" value="Agregar nuevo ítem" />
        </form>
    </body>
</html>