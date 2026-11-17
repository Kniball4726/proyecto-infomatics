<?php
    session_start();

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        header("Location: ./index.php");
        exit();
    }

    $nombre = trim((string)($_POST["nm_nombre"] ?? ""));
    $apellido = trim((string)($_POST["nm_apellido"] ?? ""));
    $email = trim((string)($_POST["nm_email"] ?? ""));
    $clave = (string)($_POST["nm_clave"] ?? "");
    $nivel = (int)($_POST["nm_nivel"] ?? 1);
    $fechaRegistro = trim((string)($_POST["nm_fechaRegistro"] ?? ""));

    if ($nombre === "" || $apellido === "" || $email === "" || $clave === "") {
        $_SESSION["error"] = "Error: Completá todos los campos obligatorios.";
        header("Location: ./index.php");
        exit();
    }

    $claveHash = password_hash($clave, PASSWORD_DEFAULT);

    try {
        $base = new PDO("sqlite:" . $_SERVER["DOCUMENT_ROOT"] . "/../infomatics.db");
        $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($fechaRegistro !== "" && strtoupper($fechaRegistro) !== "CURRENT_TIMESTAMP") {
            $sentencia = $base->prepare(
                "INSERT INTO TUsuarios (_nombre, _apellido, _email, _clave, _fechaRegistro, _nivel) VALUES (?, ?, ?, ?, ?, ?)"
            );
            $sentencia->execute([$nombre, $apellido, $email, $claveHash, $fechaRegistro, $nivel]);
        } else {
            $sentencia = $base->prepare(
                "INSERT INTO TUsuarios (_nombre, _apellido, _email, _clave, _nivel) VALUES (?, ?, ?, ?, ?)"
            );
            $sentencia->execute([$nombre, $apellido, $email, $claveHash, $nivel]);
        }

        $_SESSION["mensaje"] = "Usuario agregado correctamente";
    } catch (PDOException $e) {
        if (stripos($e->getMessage(), "UNIQUE") !== false) {
            $_SESSION["error"] = "Error: Ya existe un usuario registrado con ese email.";
        } else {
            $_SESSION["error"] = "Error al guardar el usuario: " . $e->getMessage();
        }
    }

    header("Location: ./index.php");
    exit();
