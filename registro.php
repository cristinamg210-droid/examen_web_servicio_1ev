
<?php

require_once "conexion.php";
require_once "Usuario.php";         // Permite utilizar nuestra clase.

// Guardamos el mensaje de error
$mensaje_error = "";

// Comprobamos si se ha enviado el formulario
if (isset($_POST["registrar"])) {

    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $contrasena = $_POST["contrasena"];
    $confirmar_contrasena = $_POST["confirmar_contrasena"];

    // Comprobamos que la contraseña tenga al menos 4 caracteres
    if (!preg_match("/^.{4,}$/us", $contrasena)) {

        $mensaje_error = "La contraseña debe tener al menos 4 caracteres.";

    // Comprobamos que las contraseñas coincidan
    } else if ($contrasena != $confirmar_contrasena) {

        $mensaje_error = "Las contraseñas no coinciden.";

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

            $mensaje_error = "Registro realizado correctamente.";

        } else {

            $mensaje_error = "Este correo electrónico ya está registrado.";

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
                    <input type="password" name="contrasena" id="contrasena" placeholder="Mínimo 4 caracteres" minlength="4" required>
                    <p class="mensaje-contrasena" id="mensaje-contrasena"></p>
                </div>

                <label>Confirmar contraseña*</label>
                <div class="password">
                    <input type="password" name="confirmar_contrasena" placeholder="Repite tu contraseña" required>
                </div>

                <?php if ($mensaje_error != "") { ?>
                    <p class="mensaje-error"><?php echo htmlspecialchars($mensaje_error); ?></p>
                <?php } ?>

                <input type="submit" name="registrar" value="Registrarse">

            </form>

            <p class="enlace">
                ¿Ya tienes una cuenta? <a href="login.php">Iniciar sesión</a>
            </p>

        </div>

    </main>

    <script>

        // Obtenemos el campo de contraseña y el mensaje
        const contrasena = document.getElementById("contrasena");
        const mensaje = document.getElementById("mensaje-contrasena");

        // Comprobamos la longitud de la contraseña mientras se escribe
        contrasena.addEventListener("input", function() {

            if (contrasena.value.length > 0 && contrasena.value.length < 4) {

                contrasena.classList.add("contrasena-error");
                mensaje.textContent = "La contraseña debe tener al menos 4 caracteres.";

            } else {

                contrasena.classList.remove("contrasena-error");
                mensaje.textContent = "";

            }

        });

    </script>

</body>
</html>
