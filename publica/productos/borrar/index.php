<?php
    session_start();
    $id = $_GET["id"] ?? null;
    if ($id) {
        include __DIR__ . "/procesar.php";
    } else {
        header("Location: /");
        exit();
    }
?>
