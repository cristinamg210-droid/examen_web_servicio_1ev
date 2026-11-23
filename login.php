<?php

// Iniciamos la sesión para guardar los datos del usuario
session_start();

// Incluimos los archivos de conexión y de la clase Usuario
require_once "conexion.php";
require_once "Usuario.php";

// Comprobamos si hay un correo guardado
$email_recordado = "";

// Variable para saber si la casilla de recordar está marcada
$recordar_marcado = false;

// Variable para guardar el mensaje de error
$mensaje_error = "";

// Comprobamos si existe una cookie con el correo guardado
if (isset($_COOKIE["email_recordado"])) {
    $email_recordado = $_COOKIE["email_recordado"];
    $recordar_marcado = true;
}

// Comprobamos si se ha enviado el formulario
if (isset($_POST["iniciar"])) {

    // Recogemos los datos escritos en el formulario
    $email = $_POST["email"];
    $contrasena = $_POST["contrasena"];

    // Comprobamos si quiere recordar el correo
    if (isset($_POST["recordar"])) {

        // Guardamos el correo en una cookie durante 30 días
        setcookie("email_recordado", $email, time() + (30 * 24 * 60 * 60), "/");

        $email_recordado = $email;
        $recordar_marcado = true;

    } else {

        // Eliminamos la cookie si no quiere recordar el correo
        setcookie("email_recordado", "", time() - 3600, "/");

        $email_recordado = "";
        $recordar_marcado = false;

    }

    // Creamos un objeto de la clase Usuario
    $objeto_usuario = new Usuario($conexion);

    // Comprobamos los datos del usuario
    $usuario = $objeto_usuario->iniciarSesion($email, $contrasena);

    // Comprobamos si los datos son correctos
    if ($usuario != false) {

        // Guardamos los datos del usuario en la sesión
        $_SESSION["id_usuario"] = $usuario["id_usuario"];
        $_SESSION["nombre"] = $usuario["nombre"];
        $_SESSION["rol"] = $usuario["rol"];

        // Si los datos son correctos, vamos a inicio.php
        header("Location: inicio.php");
        exit();

    } else {

        // Si los datos son incorrectos, mostramos un mensaje
        $mensaje_error = "El correo electrónico o la contraseña son incorrectos.";

    }
}

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión - Little Chapters</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

    <!-- Cabecera de la tienda -->

    <header>

        <!-- Nombre y descripción de Little Chapters -->
        <div class="logo">
            <h1>Little Chapters</h1>
            <p>Lectura - Papelería - Decoración</p>
        </div>

        <!-- Menú de navegación -->
        <nav>
            <a href="inicio.php">Inicio</a>
            <a href="#">Categorías</a>
            <a href="#">Sobre nosotros</a>
            <a href="#">Contacto</a>
        </nav>

        <!-- Espacio reservado para los iconos -->
        <div class="iconos">
            <span></span>
            <span></span>
            <span></span>
        </div>

    </header>

    <!-- Zona principal de la página -->

    <main>

        <!-- Tarjeta del formulario de inicio de sesión -->
        <div class="registro">

            <h2>Iniciar sesión</h2>

            <p>Nos alegra verte de nuevo. ¡Sigue descubriendo Little Chapters!</p>

            <!-- Línea horizontal para separar el encabezado del formulario -->
            <hr>

            <!-- Mostramos el mensaje si los datos son incorrectos -->
            <?php
            if ($mensaje_error != "") {
                echo "<p class='mensaje-error'>" . $mensaje_error . "</p>";
            }
            ?>

            <!-- Formulario para iniciar sesión -->
            <form action="login.php" method="POST">

                <!-- Campo para introducir el correo electrónico -->
                <label for="email">Correo electrónico*</label>
                <input type="email" id="email" name="email"
                placeholder="@email.com"
                value="<?php echo htmlspecialchars($email_recordado); ?>"
                required>

                <!-- Campo para introducir la contraseña -->
                <label for="contrasena">Contraseña*</label>
                <input type="password" id="contrasena" name="contrasena"
                placeholder="Introduce la contraseña" required>

                <!-- Casilla para recordar el correo electrónico -->
                <div class="recordar">

                    <input type="checkbox" id="recordar" name="recordar" value="si"
                    <?php
                    // Marcamos la casilla si hay un correo guardado
                    if ($recordar_marcado) {
                        echo "checked";
                    }
                    ?>>

                    <!-- Texto que aparece al lado de la casilla -->
                    <label for="recordar">Recordar mi correo electrónico</label>

                </div>

                <!-- Botón para enviar el formulario -->
                <input type="submit" name="iniciar" value="Iniciar sesión">

            </form>

            <!-- Enlace para ir al formulario de registro -->
            <p class="enlace">¿No tienes una cuenta? <a href="registro.php">Regístrate</a></p>

        </div>

    </main>
    
</body>
</html>
