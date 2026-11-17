<?php
    session_start();

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        header("Location: /formulario-login.php");
        exit();
    }

    $username = trim((string)($_POST["nmUsername"] ?? ""));
    $password = (string)($_POST["nmPassword"] ?? "");

    if ($username === "" || $password === "") {
        $_SESSION["error"] = "Error: Completá el email y la contraseña";
        header("Location: /formulario-login.php");
        exit();
    }

    try {
        $conexion = new PDO("sqlite:" . $_SERVER["DOCUMENT_ROOT"] . "/../infomatics.db");
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sentencia = $conexion->prepare(
            "SELECT * FROM TUsuarios WHERE LOWER(_email) = LOWER(?) LIMIT 1"
        );
        $sentencia->execute([$username]);
        $recuperado = $sentencia->fetch(PDO::FETCH_OBJ);
    } catch (PDOException $e) {
        $_SESSION["error"] = "Error al conectar con la base de datos";
        header("Location: /formulario-login.php");
        exit();
    }

    $claveValida = $recuperado && (
        password_verify($password, (string)$recuperado->_clave)
        || hash_equals((string)$recuperado->_clave, $password)
    );

    if (!$claveValida) {
        $_SESSION["error"] = "Error: Email o contraseña incorrectos";
        header("Location: /formulario-login.php");
        exit();
    }

    session_regenerate_id(true);
    $_SESSION["usuario"] = $recuperado->_id;
    $_SESSION["nombre"] = $recuperado->_nombre;
    $_SESSION["apellido"] = $recuperado->_apellido;
    $_SESSION["email"] = $recuperado->_email;
    $_SESSION["nickname"] = trim($recuperado->_nombre . " " . $recuperado->_apellido);
    $_SESSION["nivel"] = (int)($recuperado->_nivel ?? 0);

    header("Location: /");
    exit();