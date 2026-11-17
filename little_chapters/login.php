<?php

session_start();

require_once "conexion.php";

if (isset($_POST["iniciar"])) {

    $email = $_POST["email"];
    $contrasena = $_POST["contrasena"];

    $sql = "SELECT * FROM usuario WHERE email = ?";
    $consulta = $conexion->prepare($sql);
    $consulta->execute([$email]);

    $usuario = $consulta->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($contrasena, $usuario["contrasena"])) {

        $_SESSION["id_usuario"] = $usuario["id_usuario"];
        $_SESSION["nombre"] = $usuario["nombre"];
        $_SESSION["rol"] = $usuario["rol"];

        echo "Bienvenido a Little Chapters, " . $usuario["nombre"];

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
        <input type="email" name="email" required>

        <br><br>

        <label>Contraseña:</label>
        <input type="password" name="contrasena" required>

        <br><br>

        <input type="submit" name="iniciar" value="Iniciar sesión">

    </form>

</body>
</html>
