<?php

require_once "conexion.php";
require_once "Usuario.php";         //permite utilizar nuestra clase.

// Comprobamos si se ha enviado el formulario
if (isset($_POST["registrar"])) {

    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $contrasena = $_POST["contrasena"];
    $confirmar_contrasena = $_POST["confirmar_contrasena"];

    // Comprobamos que las contraseñas coincidan
    if ($contrasena != $confirmar_contrasena) {

        echo "Las contraseñas no coinciden.";

    } else {

        // Creamos un objeto de la clase Usuario
        $objeto_usuario = new Usuario($conexion);   //new Usuario($conexion) = crea un objeto de esa clase y le pasa la conexión.

        // Llamamos al método para registrar al usuario
        $resultado = $objeto_usuario->registrar(   //$objeto_usuario->registrar = llama al método que hemos creado anteriormente.
            $nombre,
            $email,
            $contrasena
        );

        if ($resultado == true) {

            echo "Registro realizado correctamente.";

        } else {

            echo "Este correo electrónico ya está registrado.";

        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Little Chapters</title>
</head>
<body>
    
    <h1>Crear una cuenta</h1>

    <form action="registro.php" method="POST">

        <label>Nombre completo:</label>
        <input type="text" name="nombre" required>

        <br><br>

        <label>Correo electrónico:</label>
        <input type="email" name="email" required>

        <br><br>

        <label>Contraseña:</label>
        <input type="password" name="contrasena" required>

        <br><br>

        <label>Confirmar contraseña:</label>
        <input type="password" name="confirmar_contrasena" required>

        <br><br>

        <input type="submit" name="registrar" value="Registrarse">

    </form>


</body>
</html>
