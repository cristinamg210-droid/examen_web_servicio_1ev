
<?php

require_once "comprobar_admin.php";
require_once "conexion.php";

// Recogemos el ID del producto
if (isset($_POST["id"])) {
    $id = $_POST["id"];
} else if (isset($_GET["id"])) {
    $id = $_GET["id"];
} else {
    header("Location: gestionar_productos.php");
    exit();
}

// Buscamos el producto
$sql = "SELECT * FROM producto WHERE id_producto = ?";
$consulta = $conexion->prepare($sql);
$consulta->execute([$id]);
$producto = $consulta->fetch(PDO::FETCH_ASSOC);

// Si no existe, volvemos al listado
if (!$producto) {
    header("Location: gestionar_productos.php");
    exit();
}

$error = "";

// Comprobamos si se ha confirmado la eliminación
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Comprobamos si el producto aparece en algún pedido
    $sql = "SELECT COUNT(*) FROM detalle_pedido WHERE id_producto = ?";
    $consulta = $conexion->prepare($sql);
    $consulta->execute([$id]);

    // Recogemos el número de pedidos
    $pedidos = $consulta->fetchColumn();

    if ($pedidos > 0) {

        $error = "No se puede eliminar este producto porque aparece en un pedido.";

    } else {

        // Eliminamos el producto
        $sql = "DELETE FROM producto WHERE id_producto = ?";
        $consulta = $conexion->prepare($sql);
        $consulta->execute([$id]);

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
    <title>Eliminar producto - Little Chapters</title>

    <!-- Conectamos el archivo CSS -->
    <link rel="stylesheet" href="estilos.css">
</head>

<body class="pagina-eliminar-producto">

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


        <!-- Contenido principal -->
        <section class="admin-content">

            <div class="confirmacion-eliminar">

                <h2>Eliminar producto</h2>

                <?php if ($error != "") { ?>

                    <p class="error-eliminar">
                        <?php echo htmlspecialchars($error); ?>
                    </p>

                    <a class="volver-eliminar" href="gestionar_productos.php">
                        Volver a productos
                    </a>

                <?php } else { ?>

                    <p>
                        ¿Seguro que quieres eliminar el producto
                        <strong><?php echo htmlspecialchars($producto["nombre"]); ?></strong>?
                    </p>

                    <p>Esta acción no se puede deshacer.</p>

                    <form action="eliminar_producto.php" method="POST">

                        <input type="hidden" name="id" value="<?php echo $id; ?>">

                        <button type="submit" class="confirmar-eliminar">
                            Sí, eliminar
                        </button>

                        <a href="gestionar_productos.php" class="cancelar-eliminar">
                            Cancelar
                        </a>

                    </form>

                <?php } ?>

            </div>

        </section>

    </main>

</body>
</html>
