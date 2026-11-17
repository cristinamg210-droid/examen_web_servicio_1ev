
<?php

require_once "conexion.php";

if (isset($_POST["registrar"])) {

    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $contrasena = $_POST["contrasena"];
    $confirmar_contrasena = $_POST["confirmar_contrasena"];

    if ($contrasena != $confirmar_contrasena) {

        echo "Las contraseñas no coinciden.";

    } else {

        $sql = "SELECT * FROM usuario WHERE email = ?";
        $consulta = $conexion->prepare($sql);
        $consulta->execute([$email]);

        if ($consulta->rowCount() > 0) {

            echo "Este correo electrónico ya está registrado.";

        } else {

            $contrasena = password_hash($contrasena, PASSWORD_DEFAULT);

            $sql = "INSERT INTO usuario (nombre, email, contrasena, rol)
                    VALUES (?, ?, ?, ?)";

            $consulta = $conexion->prepare($sql);

            $consulta->execute([
                $nombre,
                $email,
                $contrasena,
                "cliente"
            ]);

            echo "Registro realizado correctamente.";

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
