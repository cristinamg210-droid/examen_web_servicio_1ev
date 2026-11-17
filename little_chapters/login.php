<?php

session_start();

require_once "conexion.php";
require_once "Usuario.php";

// Comprobamos si hay un correo guardado
$email_recordado = "";

if (isset($_COOKIE["email_recordado"])) {
    $email_recordado = $_COOKIE["email_recordado"];
}

// Comprobamos si se ha enviado el formulario
if (isset($_POST["iniciar"])) {

    $email = $_POST["email"];
    $contrasena = $_POST["contrasena"];

    // Comprobamos si quiere recordar el correo
    if (isset($_POST["recordar"])) {

        setcookie("email_recordado", $email, time() + (30 * 24 * 60 * 60), "/");

        $email_recordado = $email;

    } else {

        setcookie("email_recordado", "", time() - 3600, "/");

        $email_recordado = "";

    }

    // Creamos un objeto de la clase Usuario
    $objeto_usuario = new Usuario($conexion);

    // Comprobamos los datos del usuario
    $usuario = $objeto_usuario->iniciarSesion($email, $contrasena);

    if ($usuario != false) {

        $_SESSION["id_usuario"] = $usuario["id_usuario"];
        $_SESSION["nombre"] = $usuario["nombre"];
        $_SESSION["rol"] = $usuario["rol"];

        header("Location: inicio.php");
        exit();

    } else {

        echo "El correo electrónico o la contraseña son incorrectos.";

    }
}

?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión - Little Chapters</title>
</head>
<body>

    <h1>Iniciar sesión</h1>

    <form action="login.php" method="POST">

        <label>Correo electrónico:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($email_recordado); ?>" required>

        <br><br>

        <label>Contraseña:</label>
        <input type="password" name="contrasena" required>

        <br><br>

        <input type="checkbox" name="recordar" value="si"
        <?php
        if (isset($_COOKIE["email_recordado"])) {
            echo "checked";
        }
        ?>>

        <label>Recordar mi correo</label>

        <br><br>

        <input type="submit" name="iniciar" value="Iniciar sesión">

    </form>

</body>
</html>
