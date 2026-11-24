
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
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir producto - Little Chapters</title>
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

                <h2>Añadir producto</h2>

            </div>


            <!-- Formulario para añadir el producto -->
            <div class="formulario-editar-producto">

                <?php if ($error != "") { ?>

                    <p class="error-editar-producto">
                        <?php echo htmlspecialchars($error); ?>
                    </p>

                <?php } ?>


                <?php if (count($categorias) > 0) { ?>

                    <form action="crear_producto.php" method="POST">

                        <!-- Nombre -->
                        <div class="campo-editar-producto">

                            <label>Nombre:</label>

                            <input type="text" name="nombre" required>

                        </div>


                        <!-- Categoría -->
                        <div class="campo-editar-producto">

                            <label>Categoría:</label>

                            <select name="id_categoria" required>

                                <option value="">Selecciona una categoría</option>

                                <?php foreach ($categorias as $categoria) { ?>

                                    <option value="<?php echo $categoria["id_categoria"]; ?>">
                                        <?php echo htmlspecialchars($categoria["nombre"]); ?>
                                    </option>

                                <?php } ?>

                            </select>

                        </div>


                        <!-- Descripción -->
                        <div class="campo-editar-producto">

                            <label>Descripción:</label>

                            <textarea name="descripcion" rows="4"></textarea>

                        </div>


                        <!-- Precio -->
                        <div class="campo-editar-producto">

                            <label>Precio (€):</label>

                            <input type="number" name="precio" step="0.01" min="0" required>

                        </div>


                        <!-- Stock -->
                        <div class="campo-editar-producto">

                            <label>Stock:</label>

                            <input type="number" name="stock" min="0" step="1" required>

                        </div>


                        <!-- Imagen -->
                        <div class="campo-editar-producto">

                            <label>Imagen (ruta):</label>

                            <input type="text" name="imagen">

                        </div>


                        <!-- Botones -->
                        <div class="botones-editar-producto">

                            <button type="submit">Guardar producto</button>

                            <a href="gestionar_productos.php">Volver a productos</a>

                        </div>

                    </form>

                <?php } else { ?>

                    <p>Primero debes crear las categorías de la tienda.</p>

                    <a href="gestionar_productos.php">Volver a productos</a>

                <?php } ?>

            </div>

        </section>

    </main>

</body>
</html>
