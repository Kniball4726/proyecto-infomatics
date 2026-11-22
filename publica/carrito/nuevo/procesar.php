<?php
    session_start() ;
    $form = (object)$_GET ;
    $reglaSQL = "INSERT INTO TCarrito VALUES ( 
NULL, '$form->nm_idUsuario'
	, '$form->nm_idProducto'
	, '$form->nm_cantidad'
	, CURRENT_TIMESTAMP
)" ;
    $base = new PDO( "sqlite:$_SERVER[DOCUMENT_ROOT]/../infomatics.db" ) ;
    $accion = $base->query( $reglaSQL ) ;
    if( $accion ):
        $_SESSION["mensaje"] = "TCarrito agregad@" ;
        header( "location:./index.php" ) ;
    else:
        $_SESSION["error"] = $base->errorInfo()[2] ;
        header( "location:./index.php" ) ;
    endif;
