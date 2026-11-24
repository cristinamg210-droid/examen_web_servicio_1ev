
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

// Guardamos la categoría del producto
$id_categoria = $producto["id_categoria"];

// Consultamos las categorías para mostrar el menú
$sql = "SELECT * FROM categoria";
$consulta = $conexion->query($sql);
$categorias = $consulta->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detalle del producto - Little Chapters</title>

    <link rel="stylesheet" href="estilos.css">
    <link rel="stylesheet" href="estilos_catalogo.css">

</head>

<body class="pagina-catalogo">

    <!-- Franja superior -->
    <div class="franja-superior">

        <p>Envíos gratuitos a partir de 35€</p>

        <div class="enlaces-superiores">
            <a href="inicio.php">Mi cuenta</a>
            <a href="#">Carrito (0)</a>
            <a href="cerrar_sesion.php">Cerrar sesión</a>
        </div>

    </div>

    <!-- Cabecera -->
    <header class="cabecera-catalogo">

        <!-- Logo y nombre de la tienda -->
        <div class="logo-catalogo">
            <h1>Little Chapters</h1>
            <p>Lectura - Papelería - Decoración</p>
        </div>

        <!-- Menú y buscador -->
        <div class="navegacion-catalogo">

            <nav class="menu-catalogo">

                <!-- Enlace de inicio -->
                <a href="catalogo.php">
                    Inicio
                </a>

                <!-- Enlaces de las categorías -->
                <?php foreach ($categorias as $categoria) { ?>

                    <a href="catalogo.php?id_categoria=<?php echo $categoria["id_categoria"]; ?>"
                       class="<?php if ($id_categoria == $categoria["id_categoria"]) { echo 'enlace-activo'; } ?>">

                        <?php echo htmlspecialchars($categoria["nombre"]); ?>

                    </a>

                <?php } ?>

            </nav>

            <!-- Buscador de productos -->
            <form class="buscador-catalogo" method="GET" action="catalogo.php">

                <input
                    type="text"
                    name="buscar"
                    placeholder="Buscar productos..."
                >

                <button type="submit" aria-label="Buscar"></button>

            </form>

        </div>

    </header>

    <!-- Información del producto -->
    <main class="detalle-main">

        <div class="detalle-producto">

            <!-- Imagen del producto -->
            <div class="detalle-imagen-contenedor">

                <?php
                if (!empty($producto["imagen"])) {
                ?>

                    <img class="detalle-imagen"
                        src="<?php echo htmlspecialchars($producto["imagen"]); ?>"
                        alt="<?php echo htmlspecialchars($producto["nombre"]); ?>">

                <?php
                }
                ?>

            </div>

            <!-- Información del producto -->
            <div class="detalle-informacion">

                <h2><?php echo htmlspecialchars($producto["nombre"]); ?></h2>

                <p class="detalle-descripcion">
                    <?php echo htmlspecialchars($producto["descripcion"]); ?>
                </p>

                <p class="detalle-precio">
                    <?php echo number_format($producto["precio"], 2, ",", "."); ?> €
                </p>

                <p class="detalle-stock">
                    <?php
                    if ($producto["stock"] > 0) {
                        echo "Disponible";
                    } else {
                        echo "Agotado";
                    }
                    ?>
                </p>

                <a href="catalogo.php?id_categoria=<?php echo $id_categoria; ?>" class="boton-detalles">
                    Volver al catálogo
                </a>

            </div>

        </div>

    </main>

</body>
</html>
