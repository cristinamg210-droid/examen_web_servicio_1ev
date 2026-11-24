
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

        // Modificamos los datos del producto
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
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar producto - Little Chapters</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body class="pagina-editar-producto">

    <!-- Cabecera del administrador -->
    <header class="admin-header">

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

            <a href="gestionar_productos.php" class="menu-activo">Productos</a>

            <a href="gestionar_pedidos.php">Pedidos</a>

        </aside>


        <!-- Contenido del formulario -->
        <section class="admin-content">

            <div class="admin-titulo">

                <h2>Editar producto</h2>

            </div>


            <!-- Formulario para modificar el producto -->
            <div class="formulario-editar-producto">

                <?php if ($error != "") { ?>

                    <p class="error-editar-producto">
                        <?php echo htmlspecialchars($error); ?>
                    </p>

                <?php } ?>


                <form action="editar_producto.php?id=<?php echo $id; ?>" method="POST">

                    <!-- Nombre -->
                    <div class="campo-editar-producto">

                        <label>Nombre:</label>

                        <input type="text" name="nombre" value="<?php echo htmlspecialchars($producto["nombre"]); ?>" required>

                    </div>


                    <!-- Categoría -->
                    <div class="campo-editar-producto">

                        <label>Categoría:</label>

                        <select name="id_categoria" required>

                            <?php foreach ($categorias as $categoria) { ?>

                                <option value="<?php echo $categoria["id_categoria"]; ?>"
                                    <?php if ($producto["id_categoria"] == $categoria["id_categoria"]) {
                                        echo "selected";
                                    } ?>>

                                    <?php echo htmlspecialchars($categoria["nombre"]); ?>

                                </option>

                            <?php } ?>

                        </select>

                    </div>


                    <!-- Descripción -->
                    <div class="campo-editar-producto">

                        <label>Descripción:</label>

                        <textarea name="descripcion" rows="4"><?php echo htmlspecialchars($producto["descripcion"]); ?></textarea>

                    </div>


                    <!-- Precio -->
                    <div class="campo-editar-producto">

                        <label>Precio (€):</label>

                        <input type="number" name="precio" step="0.01" min="0" value="<?php echo $producto["precio"]; ?>" required>

                    </div>


                    <!-- Stock -->
                    <div class="campo-editar-producto">

                        <label>Stock:</label>

                        <input type="number" name="stock" min="0" step="1" value="<?php echo $producto["stock"]; ?>" required>

                    </div>


                    <!-- Imagen -->
                    <div class="campo-editar-producto">

                        <label>Imagen (ruta):</label>

                        <input type="text" name="imagen" value="<?php echo htmlspecialchars($producto["imagen"]); ?>">

                    </div>


                    <!-- Botones -->
                    <div class="botones-editar-producto">

                        <button type="submit">Guardar cambios</button>

                        <a href="gestionar_productos.php">Volver a productos</a>

                    </div>

                </form>

            </div>

        </section>

    </main>

</body>
</html>
