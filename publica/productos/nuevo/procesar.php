<?php
    session_start() ;
    $form = (object)$_GET ;
    $reglaSQL = "INSERT INTO TProductos VALUES ( 
NULL, '$form->nm_nombre'
	, '$form->nm_descripcion'
	, '$form->nm_categoria'
	, '$form->nm_precio'
	, '$form->nm_stock'
	, '$form->nm_imagen'
	, '$form->nm_activo'
)" ;
    $base = new PDO( "sqlite:$_SERVER[DOCUMENT_ROOT]/../infomatics.db" ) ;
    $accion = $base->query( $reglaSQL ) ;
    if( $accion ):
        $_SESSION["mensaje"] = "TProductos agregad@" ;
        header( "location:./index.php" ) ;
    else:
        $_SESSION["error"] = $base->errorInfo()[2] ;
        header( "location:./index.php" ) ;
    endif;
