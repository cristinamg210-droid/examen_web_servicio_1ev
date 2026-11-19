la confirmación al pulsar «Eliminar».
<?php

// Comprobamos que el usuario sea administrador
require_once "comprobar_admin.php";

// Conectamos con la base de datos
require_once "conexion.php";

// Consultamos los productos junto con el nombre de su categoría
// INNER JOIN relaciona las tablas producto y categoria mediante id_categoria
// También obtenemos la imagen para poder mostrarla en el listado
$sql = "SELECT producto.id_producto, producto.nombre, producto.imagen, categoria.nombre AS categoria, producto.precio, producto.stock
        FROM producto
        INNER JOIN categoria
        ON producto.id_categoria = categoria.id_categoria";

// Ejecutamos la consulta SQL
$consulta = $conexion->query($sql);

// Recogemos todos los resultados en un array
// FETCH_ASSOC permite acceder a los datos mediante el nombre de sus columnas
$productos = $consulta->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar productos - Little Chapters</title>
</head>
<body>
    <h1>Little Chapters - Panel de administración</h1>

    <p>Gestión de productos</p>

    <!-- Enlace para añadir un producto nuevo -->
    <a href="crear_producto.php">+ Añadir producto</a>

    <br><br>

    <!-- Tabla donde mostraremos los productos -->
    <table border="1">

        <tr>
            <th>Imagen</th>
            <th>Nombre</th>
            <th>Categoría</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Acciones</th>
        </tr>

        <?php
        // Recorremos el array para mostrar todos los productos
        // En cada vuelta, $producto contiene los datos de un producto
        foreach ($productos as $producto) {
        ?>

            <tr>

                <!-- Mostramos la imagen del producto -->
                <td>
                    <?php
                    // Comprobamos si el producto tiene una imagen guardada
                    if (!empty($producto["imagen"])) {
                        // Mostramos la imagen
                        // htmlspecialchars evita interpretar el texto como código HTML
                        echo '<img src="' . htmlspecialchars($producto["imagen"]) . '" alt="Imagen del producto" width="80" height="80">';
                    } else {
                        // Si no tiene imagen, mostramos este texto
                        echo "Sin imagen";
                    }
                    ?>
                </td>

                <!-- Mostramos el nombre del producto -->
                <td>
                    <?php echo htmlspecialchars($producto["nombre"]); ?>
                </td>

                <!-- Mostramos el nombre de su categoría -->
                <td>
                    <?php echo htmlspecialchars($producto["categoria"]); ?>
                </td>

                <!-- Mostramos el precio -->
                <td>
                    <?php echo $producto["precio"]; ?> €
                </td>

                <!-- Mostramos las existencias disponibles -->
                <td>
                    <?php echo $producto["stock"]; ?>
                </td>

                <!-- Acciones para modificar o eliminar el producto -->
                <td>
                    <!-- Enviamos el ID del producto para identificarlo -->
                    <a href="editar_producto.php?id=<?php echo $producto["id_producto"]; ?>">
                        Editar
                    </a>
                    |
                    <a href="eliminar_producto.php?id=<?php echo $producto["id_producto"]; ?>"
                       onclick="return confirm('¿Seguro que quieres eliminar este producto?')">
                        Eliminar
                    </a>
                </td>

            </tr>

        <?php
        }
        ?>

    </table>

    <br>

    <!-- Enlace para volver a la página de inicio -->
    <a href="inicio.php">Volver al inicio</a>


</body>
</html>