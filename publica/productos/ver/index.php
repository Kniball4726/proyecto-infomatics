<?php
    session_start() ;
    $url = (object)$_GET ;
    $id = $url->id ?? 1 ;
    $reglaSQL = "SELECT * FROM TProductos WHERE _id='$id';" ;
    $base = new PDO( "sqlite:$_SERVER[DOCUMENT_ROOT]/../infomatics.db" ) ;
    $accion = $base->query( $reglaSQL ) ;
    if( !$accion ):
        printf( "Hubo un error - %s", $base->errorInfo()[2] ) ;
        die() ;
    endif;
    $todos = $accion->fetchAll( PDO::FETCH_OBJ ) ;
    $hayUsuario = isSet( $_SESSION["usuario"] ) ; // true o false
?>
<html >
    
<head>
    <title >Tu App</title>
    <meta name="viewport" content="width=device-width,user-scalable=no" />
    <meta charset="utf-8" />
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.css" />
    <style >[full]{ width: 100% }</style>
</head>

    <body >
        <header >
            <h1>Viendo un TProductos</h1>
            <nav>
                <button onclick="history.back()">Volver</button>
<?php
    if( $hayUsuario ):
        printf( "<button onclick='fnAgregarCarrito($id)' >Agregar al carrito</button>" ) ;
    endif;
?>
            </nav>
        </header>
        <section >
<?php
    if( count($todos) == 0 ):
        printf( "<p> No se encontró el registro %d </p>", $id );
    else:
        $encontrado = $todos[0] ;
        printf( "<details ><pre>%s</pre></details>", json_encode( $encontrado ) ) ;
            printf( "<p><strong>%s</strong>: <mark>%s</mark></p>", "_id", $encontrado->_id );
printf( "<p><strong>%s</strong>: <mark>%s</mark></p>", "_nombre", $encontrado->_nombre );
printf( "<p><strong>%s</strong>: <mark>%s</mark></p>", "_descripcion", $encontrado->_descripcion );
printf( "<p><strong>%s</strong>: <mark>%s</mark></p>", "_categoria", $encontrado->_categoria );
printf( "<p><strong>%s</strong>: <mark>%s</mark></p>", "_precio", $encontrado->_precio );
printf( "<p><strong>%s</strong>: <mark>%s</mark></p>", "_stock", $encontrado->_stock );
printf( "<p><strong>%s</strong>: <mark>%s</mark></p>", "_imagen", $encontrado->_imagen );
printf( "<p><strong>%s</strong>: <mark>%s</mark></p>", "_activo", $encontrado->_activo );

    endif;
?>
    </body>
</html>
