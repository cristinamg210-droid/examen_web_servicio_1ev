
<?php

// Comprobamos que el usuario sea administrador
require_once "comprobar_admin.php";

// Conectamos con la base de datos
require_once "conexion.php";

// Consultamos los productos y sus categorías
$sql = "SELECT producto.id_producto, producto.nombre, producto.imagen, categoria.nombre AS categoria, producto.precio, producto.stock
        FROM producto
        INNER JOIN categoria
        ON producto.id_categoria = categoria.id_categoria";

// Ejecutamos la consulta
$consulta = $conexion->query($sql);

// Guardamos los productos en un array
$productos = $consulta->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar productos - Little Chapters</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body class="pagina-gestion-productos">


    <!-- Cabecera del administrador -->
    <header class="admin-header">

        <!-- Nombre de la tienda y panel de administración -->
        <div class="admin-logo">

            <h1>Little Chapters</h1>

            <p>Panel de administración</p>

        </div>

        <!-- Enlaces de la cabecera -->
        <div class="enlaces-admin">

            <a href="catalogo.php">Volver al catálogo</a>

            <a href="cerrar_sesion.php">Cerrar sesión</a>

        </div>

    </header>


    <!-- Zona principal -->
    <main class="admin-main">

        <!-- Menú lateral -->
        <aside class="admin-menu">

            <!-- Página en la que estamos actualmente -->
            <a href="gestionar_productos.php" class="menu-activo">Productos</a>

            <a href="gestionar_pedidos.php">Pedidos</a>

        </aside>


        <!-- Contenido de productos -->
        <section class="admin-content">

            <div class="admin-titulo">

                <h2>Productos</h2>

                <!-- Enlace para añadir un producto -->
                <a href="crear_producto.php">+ Añadir producto</a>

            </div>


            <!-- Tabla de productos -->
            <div class="contenedor-tabla-productos">

                <table class="tabla-productos">

                    <tr>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Acciones</th>
                    </tr>

                    <?php foreach ($productos as $producto) { ?>

                        <tr>

                            <!-- Imagen del producto -->
                            <td>
                                <?php
                                if (!empty($producto["imagen"])) {
                                    echo '<img src="' . htmlspecialchars($producto["imagen"]) . '" alt="Imagen del producto">';
                                } else {
                                    echo "Sin imagen";
                                }
                                ?>
                            </td>

                            <!-- Nombre del producto -->
                            <td>
                                <?php echo htmlspecialchars($producto["nombre"]); ?>
                            </td>

                            <!-- Categoría -->
                            <td>
                                <?php echo htmlspecialchars($producto["categoria"]); ?>
                            </td>

                            <!-- Precio -->
                            <td>
                                <?php echo number_format($producto["precio"], 2, ",", "."); ?> €
                            </td>

                            <!-- Stock -->
                            <td>
                                <?php echo $producto["stock"]; ?>
                            </td>

                            <!-- Botones de las acciones -->
                            <td>

                                <a class="boton-editar" href="editar_producto.php?id=<?php echo $producto["id_producto"]; ?>">
                                    Editar
                                </a>

                                <a class="boton-eliminar" href="eliminar_producto.php?id=<?php echo $producto["id_producto"]; ?>">
                                    Eliminar
                                </a>

                            </td>

                        </tr>

                    <?php } ?>

                    <?php if (count($productos) == 0) { ?>

                        <tr>
                            <td colspan="6">Todavía no hay productos.</td>
                        </tr>

                    <?php } ?>

                </table>

            </div>

        </section>

    </main>


</body>
</html>
