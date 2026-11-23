<?php

require_once "comprobar_admin.php";
require_once "conexion.php";

// Consultamos las categorías
$sql = "SELECT * FROM categoria";
$consulta = $conexion->query($sql);
$categorias = $consulta->fetchAll(PDO::FETCH_ASSOC);

$error = "";

// Comprobamos si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Recogemos los datos del formulario
    $nombre = trim($_POST["nombre"]);
    $id_categoria = $_POST["id_categoria"];
    $descripcion = trim($_POST["descripcion"]);
    $precio = $_POST["precio"];
    $stock = $_POST["stock"];
    $imagen = trim($_POST["imagen"]);

    // Comprobamos que los datos sean correctos
    if ($nombre == "" || $id_categoria == "" || $precio == "" || $stock == "") {

        $error = "Rellena todos los campos obligatorios.";

    } elseif (!is_numeric($precio) || $precio < 0 || !filter_var($stock, FILTER_VALIDATE_INT) || $stock < 0) {

        $error = "Comprueba que el precio y el stock sean correctos.";

    } else {

        // Insertamos el producto en la base de datos
        $sql = "INSERT INTO producto (id_categoria, nombre, descripcion, precio, stock, imagen)
                VALUES (?, ?, ?, ?, ?, ?)";

        $consulta = $conexion->prepare($sql);
        $consulta->execute([$id_categoria, $nombre, $descripcion, $precio, $stock, $imagen]);

        // Volvemos al listado de productos
        header("Location: gestionar_productos.php");
        exit();

    }

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir producto - Little Chapters</title>
</head>
<body>
    
    <h1>Añadir producto</h1>

    <?php if ($error != "") { ?>
        <p><?php echo htmlspecialchars($error); ?></p>
    <?php } ?>

    <?php if (count($categorias) > 0) { ?>

        <form action="crear_producto.php" method="POST">

            <label>Nombre:</label><br>
            <input type="text" name="nombre" required><br><br>

            <label>Categoría:</label><br>
            <select name="id_categoria" required>

                <option value="">Selecciona una categoría</option>

                <?php foreach ($categorias as $categoria) { ?>
                    <option value="<?php echo $categoria["id_categoria"]; ?>">
                        <?php echo htmlspecialchars($categoria["nombre"]); ?>
                    </option>
                <?php } ?>

            </select><br><br>

            <label>Descripción:</label><br>
            <textarea name="descripcion"></textarea><br><br>

            <label>Precio:</label><br>
            <input type="number" name="precio" step="0.01" min="0" required><br><br>

            <label>Stock:</label><br>
            <input type="number" name="stock" min="0" step="1" required><br><br>

            <label>Imagen (ruta):</label><br>
            <input type="text" name="imagen"><br><br>

            <button type="submit">Guardar producto</button>

        </form>

    <?php } else { ?>

        <p>Primero debes crear las categorías de la tienda.</p>

    <?php } ?>

    <br>

    <a href="gestionar_productos.php">Volver a productos</a>

</body>
</html>