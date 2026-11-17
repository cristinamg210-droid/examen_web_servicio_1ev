
<?php

session_start();

// Comprobamos si el usuario ha iniciado sesión
if (!isset($_SESSION["id_usuario"])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Little Chapters</title>
</head>
<body>

    <h1>Bienvenido/a a Little Chapters</h1>

    <p>Hola, <?php echo $_SESSION["nombre"]; ?></p>

    <p>Has iniciado sesión correctamente.</p>

    <?php if ($_SESSION["rol"] == "admin") { ?>

        <h2>Panel de administración</h2>
        <a href="prueba_admin.php">Acceder a administración</a>
        <p>Desde aquí podrás gestionar los productos y consultar los pedidos.</p>

    <?php } else { ?>

        <h2>Zona de cliente</h2>
        <p>Desde aquí podrás consultar el catálogo y realizar pedidos.</p>

    <?php } ?>

    <p>Tu rol es: <?php echo $_SESSION["rol"]; ?></p>

    <a href="cerrar_sesion.php">Cerrar sesión</a>

</body>
</html>
