
<?php

session_start();

// Comprobamos que el usuario haya iniciado sesión
if (!isset($_SESSION["id_usuario"])) {
    header("Location: login.php");
    exit();
}

// Conectamos con la base de datos
require_once "conexion.php";

// Consultamos las categorías
$sql = "SELECT * FROM categoria";
$consulta = $conexion->query($sql);
$categorias = $consulta->fetchAll();

// Comprobamos si se ha seleccionado una categoría
if (isset($_GET["id_categoria"])) {

    $id_categoria = (int) $_GET["id_categoria"];

    // Mostramos los productos de la categoría seleccionada
    $sql = "SELECT * FROM producto WHERE id_categoria = ?";
    $consulta = $conexion->prepare($sql);
    $consulta->execute([$id_categoria]);

} else {

    // Mostramos cuatro productos aleatorios de toda la tienda
    $sql = "SELECT * FROM producto ORDER BY RAND() LIMIT 4";
    $consulta = $conexion->query($sql);

}

// Guardamos los productos consultados
$productos = $consulta->fetchAll();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Catálogo - Little Chapters</title>

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

                <a href="catalogo.php" class="enlace-activo">Inicio</a>

                <?php foreach ($categorias as $categoria) { ?>

                    <a href="catalogo.php?id_categoria=<?php echo $categoria["id_categoria"]; ?>">
                        <?php echo htmlspecialchars($categoria["nombre"]); ?>
                    </a>

                <?php } ?>

            </nav>

            <div class="buscador-catalogo">
                <input type="text" placeholder="Buscar productos...">
                <button type="button"></button>
            </div>

        </div>

    </header>

    <!-- Contenido principal -->
    <main class="contenido-catalogo">

        <!-- Categorías -->
        <section class="categorias-catalogo">

            <?php foreach ($categorias as $categoria) { ?>

                <a class="bloque-categoria"
                   href="catalogo.php?id_categoria=<?php echo $categoria["id_categoria"]; ?>">

                    <span>
                        <?php echo htmlspecialchars($categoria["nombre"]); ?>
                    </span>

                </a>

            <?php } ?>

        </section>

        <!-- Título de los productos -->
        <div class="titulo-productos">

            <span></span>

            <h2>Nuestros productos</h2>

            <span></span>

        </div>

        <!-- Productos -->
        <section class="productos-catalogo">

            <?php foreach ($productos as $producto) { ?>

                <article class="tarjeta-producto">

                    <!-- Imagen del producto -->
                    <div class="imagen-producto">

                        <?php if (!empty($producto["imagen"])) { ?>

                            <img
                                src="<?php echo htmlspecialchars($producto["imagen"]); ?>"
                                alt="<?php echo htmlspecialchars($producto["nombre"]); ?>"
                            >

                        <?php } ?>

                    </div>

                    <!-- Información del producto -->
                    <div class="informacion-producto">

                        <p class="nombre-producto">
                            <?php echo htmlspecialchars($producto["nombre"]); ?>
                        </p>

                        <p class="precio-producto">
                            <?php echo number_format($producto["precio"], 2, ",", "."); ?>€
                        </p>

                        <div class="botones-producto">

                            <a href="detalle_producto.php?id=<?php echo $producto["id_producto"]; ?>">
                                Ver detalles
                            </a>

                            <button type="button">
                                Añadir al carrito
                            </button>

                        </div>

                    </div>

                </article>

            <?php } ?>

        </section>

    </main>

    <!-- Pie de página -->
    <footer class="pie-catalogo">

        <div class="novedades-catalogo">

            <div class="texto-novedades">
                <span class="cuadro-icono"></span>

                <p>¡No te pierdas nuestras novedades!</p>
            </div>

            <div class="suscripcion-catalogo">

                <input type="email" placeholder="Introduce tu correo electrónico">

                <button type="button">Suscribirme</button>

            </div>

            <div class="redes-sociales">

                <a href="#"></a>
                <a href="#"></a>
                <a href="#"></a>

            </div>

        </div>

    </footer>

</body>
</html>
