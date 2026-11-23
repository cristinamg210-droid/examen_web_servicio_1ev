<?php

session_start();

// Comprobamos si el usuario ha iniciado sesión
if (!isset($_SESSION["id_usuario"])) {
    header("Location: login.php");
    exit();
}

require_once "conexion.php";

// Comprobamos que se ha recibido el identificador del producto
if (!isset($_GET["id"])) {
    header("Location: catalogo.php");
    exit();
}

$id_producto = $_GET["id"];

// Consultamos el producto seleccionado
$sql = "SELECT * FROM producto WHERE id_producto = ?";
$consulta = $conexion->prepare($sql);
$consulta->execute([$id_producto]);

$producto = $consulta->fetch(PDO::FETCH_ASSOC);

// Comprobamos que el producto existe
if (!$producto) {
    header("Location: catalogo.php");
    exit();
}

// Consultamos las categorías para mostrar el menú
$sql = "SELECT * FROM categoria";
$consulta = $conexion->query($sql);
$categorias = $consulta->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del producto - Little Chapters</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <!-- Cabecera de la tienda -->
    <header>

        <div class="logo">
            <h1>Little Chapters</h1>
            <p>Lectura - Papelería - Decoración</p>
        </div>

        <!-- Menú de categorías -->
        <nav>
            <a href="inicio.php">Inicio</a>

            <?php
            foreach ($categorias as $categoria) {
            ?>
                <a href="catalogo.php#categoria-<?php echo $categoria["id_categoria"]; ?>">
                    <?php echo htmlspecialchars($categoria["nombre"]); ?>
                </a>
            <?php
            }
            ?>
        </nav>

        <div class="iconos">
            <span></span>
        </div>

    </header>

    <!-- Información del producto -->
    <main class="detalle-main">

        <div class="detalle-producto">

            <?php
            if (!empty($producto["imagen"])) {
            ?>
                <img class="detalle-imagen"
                    src="imagenes/<?php echo htmlspecialchars($producto["imagen"]); ?>"
                    alt="<?php echo htmlspecialchars($producto["nombre"]); ?>">
            <?php
            }
            ?>

            <div class="detalle-informacion">

                <h2><?php echo htmlspecialchars($producto["nombre"]); ?></h2>

                <p class="detalle-descripcion">
                    <?php echo htmlspecialchars($producto["descripcion"]); ?>
                </p>

                <p class="detalle-precio">
                    <?php echo number_format($producto["precio"], 2, ",", "."); ?> €
                </p>

                <p>
                    <?php
                    if ($producto["stock"] > 0) {
                        echo "Disponible";
                    } else {
                        echo "Agotado";
                    }
                    ?>
                </p>

                <a href="catalogo.php" class="boton-detalles">Volver al catálogo</a>

            </div>

        </div>

    </main>
</body>
</html>