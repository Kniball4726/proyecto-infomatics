<?php
    session_start() ;
    $hayUsuario = isSet($_SESSION["usuario"]) ; // true ó false
    $esUsuarioAdmin = $hayUsuario && (($_SESSION["nivel"] ?? 0) >= 10 || $_SESSION["usuario"] === "admin") ;
    if( $hayUsuario ):
        include "./index-con-usuario.php" ;
    else:
        include "./index-sin-usuario.php" ;
    endif;
?>