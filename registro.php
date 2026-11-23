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
        $objeto_usuario = new Usuario($conexion);

        // Llamamos al método para registrar al usuario
        $resultado = $objeto_usuario->registrar(
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
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    
    <header>

        <div class="logo">
            <h1>Little Chapters</h1>
            <p>Lectura - Papelería - Decoración</p>
        </div>

        <nav>
            <a href="inicio.php">Inicio</a>
            <a href="#">Categorías</a>
            <a href="#">Sobre nosotros</a>
            <a href="#">Contacto</a>
        </nav>

        <div class="iconos">
            <span></span>
            <span></span>
            <span></span>
        </div>

    </header>

    <main>

        <div class="registro">

            <h2>Crear cuenta</h2>

            <p>Únete a Little Chapters y descubre todo lo que tenemos para ti.</p>

            <hr>

            <form action="registro.php" method="POST">

                <label>Nombre completo*</label>
                <input type="text" name="nombre" placeholder="Introduce tu nombre" required>

                <label>Correo electrónico*</label>
                <input type="email" name="email" placeholder="@email.com" required>

                <label>Contraseña*</label>
                <div class="password">
                    <input type="password" name="contrasena" placeholder="Minimo 8 caracteres" required>
                    <span></span>
                </div>

                <label>Confirmar contraseña*</label>
                <div class="password">
                    <input type="password" name="confirmar_contrasena" placeholder="Repite tu contraseña" required>
                    <span></span>
                </div>

                <input type="submit" name="registrar" value="Registrarse">

            </form>

            <p class="enlace">
                ¿Ya tienes una cuenta? <a href="login.php">Iniciar sesión</a>
            </p>

        </div>

    </main>


</body>
</html>
