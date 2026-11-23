<?php

require_once "comprobar_admin.php";
require_once "conexion.php";

// Recogemos el ID y buscamos el producto
$id = $_GET["id"];

$sql = "SELECT * FROM producto WHERE id_producto = ?";
$consulta = $conexion->prepare($sql);
$consulta->execute([$id]);
$producto = $consulta->fetch(PDO::FETCH_ASSOC);

// Si no existe, volvemos al listado
if (!$producto) {
    header("Location: gestionar_productos.php");
    exit();
}

// Consultamos las categorías
$sql = "SELECT * FROM categoria";
$categorias = $conexion->query($sql)->fetchAll(PDO::FETCH_ASSOC);

$error = "";

// Comprobamos si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Recogemos los datos
    $nombre = trim($_POST["nombre"]);
    $id_categoria = $_POST["id_categoria"];
    $descripcion = trim($_POST["descripcion"]);
    $precio = $_POST["precio"];
    $stock = $_POST["stock"];
    $imagen = trim($_POST["imagen"]);

    // Comprobamos los datos obligatorios
    if ($nombre == "" or $id_categoria == "" or $precio == "" or $stock == "") {
        $error = "Rellena los campos obligatorios.";
    } else if ($precio < 0 or $stock < 0) {
        $error = "El precio y el stock no pueden ser negativos.";
    } else {

        // UPDATE modifica los datos y WHERE identifica el producto.
        $sql = "UPDATE producto SET id_categoria = ?, nombre = ?, descripcion = ?, precio = ?, stock = ?, imagen = ? WHERE id_producto = ?";
        $consulta = $conexion->prepare($sql);
        $consulta->execute([$id_categoria, $nombre, $descripcion, $precio, $stock, $imagen, $id]);

        // Volvemos al listado
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
    <title>Editar producto - Little Chapters</title>
</head>
<body>
    
    <h1>Editar producto</h1>

    <?php if ($error != "") { ?>
        <p><?php echo htmlspecialchars($error); ?></p>
    <?php } ?>

    <form action="editar_producto.php?id=<?php echo $id; ?>" method="POST">

        <label>Nombre:</label><br>
        <input type="text" name="nombre" value="<?php echo htmlspecialchars($producto["nombre"]); ?>" required><br><br>

        <label>Categoría:</label><br>

        <select name="id_categoria" required>

            <?php foreach ($categorias as $categoria) { ?>

                <option value="<?php echo $categoria["id_categoria"]; ?>"
                    <?php if ($producto["id_categoria"] == $categoria["id_categoria"]) { echo "selected"; } ?>>

                    <?php echo htmlspecialchars($categoria["nombre"]); ?>

                </option>

            <?php } ?>

        </select><br><br>

        <label>Descripción:</label><br>
        <textarea name="descripcion"><?php echo htmlspecialchars($producto["descripcion"]); ?></textarea><br><br>

        <label>Precio:</label><br>
        <input type="number" name="precio" step="0.01" min="0" value="<?php echo $producto["precio"]; ?>" required><br><br>

        <label>Stock:</label><br>
        <input type="number" name="stock" min="0" step="1" value="<?php echo $producto["stock"]; ?>" required><br><br>

        <label>Imagen (ruta):</label><br>
        <input type="text" name="imagen" value="<?php echo htmlspecialchars($producto["imagen"]); ?>"><br><br>

        <button type="submit">Guardar cambios</button>

    </form>

    <br>

    <a href="gestionar_productos.php">Volver a productos</a>

</body>
</html>