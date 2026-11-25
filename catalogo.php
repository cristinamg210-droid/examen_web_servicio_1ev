
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

// Guardamos el texto escrito en el buscador
$busqueda = "";

if (isset($_GET["buscar"])) {
    $busqueda = trim($_GET["buscar"]);
}

// Comprobamos si se ha seleccionado una categoría
$hay_categoria = false;
$id_categoria = 0;

if (isset($_GET["id_categoria"])) {
    $id_categoria = (int) $_GET["id_categoria"];
    $hay_categoria = true;
}

// Comprobamos si se ha escrito algo en el buscador
if ($busqueda != "") {

    // Comprobamos si también se ha seleccionado una categoría
    if ($hay_categoria) {

        // Buscamos dentro de la categoría seleccionada
        $sql = "SELECT * FROM producto
                WHERE id_categoria = ? AND nombre LIKE ?";

        $consulta = $conexion->prepare($sql);
        $consulta->execute([$id_categoria, "%" . $busqueda . "%"]);

    } else {

        // Buscamos en todos los productos
        $sql = "SELECT * FROM producto WHERE nombre LIKE ?";

        $consulta = $conexion->prepare($sql);
        $consulta->execute(["%" . $busqueda . "%"]);

    }

} else {

    // Comprobamos si se ha seleccionado una categoría
    if ($hay_categoria) {

        // Mostramos los productos de la categoría seleccionada
        $sql = "SELECT * FROM producto WHERE id_categoria = ?";

        $consulta = $conexion->prepare($sql);
        $consulta->execute([$id_categoria]);

    } else {

        // Mostramos cuatro productos aleatorios de toda la tienda
        $sql = "SELECT * FROM producto ORDER BY RAND() LIMIT 4";

        $consulta = $conexion->query($sql);

    }

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

                <!-- Enlace de inicio -->
                <a href="catalogo.php"
                   class="<?php if (!$hay_categoria) { echo 'enlace-activo'; } ?>">
                    Inicio
                </a>

                <!-- Enlaces de las categorías -->
                <?php foreach ($categorias as $categoria) { ?>

                    <a href="catalogo.php?id_categoria=<?php echo $categoria["id_categoria"]; ?>"
                       class="<?php if ($hay_categoria && $id_categoria == $categoria["id_categoria"]) { echo 'enlace-activo'; } ?>">

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
                    value="<?php echo htmlspecialchars($busqueda); ?>"
                >

                <?php if ($hay_categoria) { ?>

                    <!-- Mantenemos la categoría al realizar la búsqueda -->
                    <input type="hidden" name="id_categoria" value="<?php echo $id_categoria; ?>">

                <?php } ?>

                <button type="submit" aria-label="Buscar"></button>

            </form>

        </div>

    </header>

    <!-- Contenido principal -->
    <main class="contenido-catalogo">

        <!-- Categorías -->
        <section class="categorias-catalogo">

            <?php foreach ($categorias as $categoria) { ?>

                <a class="bloque-categoria"
                   href="catalogo.php?id_categoria=<?php echo $categoria["id_categoria"]; ?>">

                    <?php if ($categoria["nombre"] == "Accesorios de lectura") { ?>

                        <img src="imagenes/productos/accesorios_lectura.jpg" alt="Accesorios de lectura">

                    <?php } elseif ($categoria["nombre"] == "Papelería literaria") { ?>

                        <img src="imagenes/productos/papeleria_literaria.avif" alt="Papelería literaria">

                    <?php } elseif ($categoria["nombre"] == "Rincón acogedor") { ?>

                        <img src="imagenes/productos/rincon_acogedor.jpg" alt="Rincón acogedor">

                    <?php } ?>

                    <span>
                        <?php echo htmlspecialchars($categoria["nombre"]); ?>
                    </span>

                </a>

            <?php } ?>

        </section>

        <!-- Título de los productos -->
        <div class="titulo-productos">

            <span></span>

            <h2>
                <?php if ($busqueda != "") { ?>

                    Resultados de búsqueda

                <?php } else { ?>

                    Nuestros productos

                <?php } ?>
            </h2>

            <span></span>

        </div>

        <!-- Productos -->
        <section class="productos-catalogo">

            <?php if (count($productos) > 0) { ?>

                <?php foreach ($productos as $producto) { ?>

                    <article class="tarjeta-producto">

                        <!-- Imagen del producto -->
                        <div class="imagen-producto">

                            <!-- Imágenes de Accesorios de lectura -->
                            <?php if ($producto["nombre"] == "Lámpara de lectura") { ?>

                                <img src="imagenes/productos/lampara_lectura.webp" alt="Lámpara de lectura">

                            <?php } elseif ($producto["nombre"] == "Marcapáginas") { ?>

                                <img src="imagenes/productos/marcapaginas.avif" alt="Marcapáginas">

                            <?php } elseif ($producto["nombre"] == "Funda para libros") { ?>

                                <img src="imagenes/productos/funda_libros.webp" alt="Funda para libros">

                            <?php } elseif ($producto["nombre"] == "Marcapáginas magnético") { ?>

                                <img src="imagenes/productos/marcapaginas_magnetico.webp" alt="Marcapáginas magnético">

                            <?php } elseif ($producto["nombre"] == "Luz de lectura con pinza") { ?>

                                <img src="imagenes/productos/luz_pinza.jpg" alt="Luz de lectura con pinza">

                            <?php } elseif ($producto["nombre"] == "Soporte para libros") { ?>

                                <img src="imagenes/productos/soporte_libros.jpg" alt="Soporte para libros">

                            <?php } elseif ($producto["nombre"] == "Funda para libros acolchada") { ?>

                                <img src="imagenes/productos/funda_libros_acolchada.jpg" alt="Funda para libros acolchada">

                            <?php } elseif ($producto["nombre"] == "Marcapáginas de tela") { ?>

                                <img src="imagenes/productos/marcapaginas_tela.jpg" alt="Marcapáginas de tela">


                            <!-- Imágenes de Papelería literaria -->
                            <?php } elseif ($producto["nombre"] == "Libreta") { ?>

                                <img src="imagenes/productos/libreta.avif" alt="Libreta">

                            <?php } elseif ($producto["nombre"] == "Diario de lectura") { ?>

                                <img src="imagenes/productos/diario_lectura.jpg" alt="Diario de lectura">

                            <?php } elseif ($producto["nombre"] == "Cuaderno literario") { ?>

                                <img src="imagenes/productos/cuaderno_literario.jpg" alt="Cuaderno literario">

                            <?php } elseif ($producto["nombre"] == "Bolígrafo") { ?>

                                <img src="imagenes/productos/boligrafo.jpg" alt="Bolígrafo">

                            <?php } elseif ($producto["nombre"] == "Pack de pegatinas literarias") { ?>

                                <img src="imagenes/productos/pegatinas.jpg" alt="Pack de pegatinas literarias">

                            <?php } elseif ($producto["nombre"] == "Bloc de notas") { ?>

                                <img src="imagenes/productos/bloc_notas.webp" alt="Bloc de notas">

                            <?php } elseif ($producto["nombre"] == "Planificador de lectura") { ?>

                                <img src="imagenes/productos/planificador_lectura.avif" alt="Planificador de lectura">

                            <?php } elseif ($producto["nombre"] == "Set de papelería") { ?>

                                <img src="imagenes/productos/set_papeleria.jpg" alt="Set de papelería">


                            <!-- Imágenes de Rincón acogedor -->
                            <?php } elseif ($producto["nombre"] == "Taza") { ?>

                                <img src="imagenes/productos/taza.webp" alt="Taza">

                            <?php } elseif ($producto["nombre"] == "Vela aromática") { ?>

                                <img src="imagenes/productos/vela_aromatica.avif" alt="Vela aromática">

                            <?php } elseif ($producto["nombre"] == "Cojín decorativo") { ?>

                                <img src="imagenes/productos/cojin.jpg" alt="Cojín decorativo">

                            <?php } elseif ($producto["nombre"] == "Manta suave") { ?>

                                <img src="imagenes/productos/manta.jpg" alt="Manta suave">

                            <?php } elseif ($producto["nombre"] == "Lámina decorativa") { ?>

                                <img src="imagenes/productos/lamina_decorativa.avif" alt="Lámina decorativa">

                            <?php } elseif ($producto["nombre"] == "Taza literaria") { ?>

                                <img src="imagenes/productos/taza_literaria.webp" alt="Taza literaria">

                            <?php } elseif ($producto["nombre"] == "Vela con diseño de libros") { ?>

                                <img src="imagenes/productos/vela_literaria.jpg" alt="Vela con diseño de libros">

                            <?php } elseif ($producto["nombre"] == "Cojín con frase literaria") { ?>

                                <img src="imagenes/productos/cojin_frase.jpg" alt="Cojín con frase literaria">

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

            <?php } else { ?>

                <!-- Mensaje cuando no encontramos productos -->
                <p class="mensaje-sin-resultados">
                    No se han encontrado productos con ese nombre.
                </p>

            <?php } ?>

        </section>

    </main>

    <!-- Pie de página -->
    <footer class="pie-catalogo">

        <div class="novedades-catalogo">

            <div class="texto-novedades">
                <span class="icono-sobre">✉︎</span>

                <p>¡No te pierdas nuestras novedades!</p>
            </div>

            <div class="suscripcion-catalogo">

                <!-- Formulario para suscribirse -->
                <form id="formulario-suscripcion">

                    <input
                        type="email"
                        id="correo-suscripcion"
                        placeholder="Introduce tu correo electrónico"
                        required
                    >

                    <button type="submit">Suscribirme</button>

                </form>

                <!-- Mensaje que aparece después de suscribirse -->
                <p id="mensaje-suscripcion"></p>

            </div>

            <div class="redes-sociales">

                <a href="#"></a>
                <a href="#"></a>
                <a href="#"></a>

            </div>

        </div>

    </footer>

    <!-- JavaScript para el formulario de suscripción -->
    <script>

        // Seleccionamos el formulario
        const formulario = document.getElementById("formulario-suscripcion");

        // Seleccionamos el espacio donde aparecerá el mensaje
        const mensaje = document.getElementById("mensaje-suscripcion");

        // Comprobamos cuando se envía el formulario
        formulario.addEventListener("submit", function(event) {

            // Evitamos que la página se recargue
            event.preventDefault();

            // Ocultamos el formulario
            formulario.style.display = "none";

            // Mostramos el mensaje de confirmación
            mensaje.textContent = "¡Gracias por suscribirte! Pronto tendrás noticias de Little Chapters.";

            // Hacemos visible el mensaje
            mensaje.style.display = "block";

        });

    </script>

</body>
</html>
