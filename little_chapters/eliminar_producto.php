directamente donde aparecen esas instrucciones:
<?php

require_once "comprobar_admin.php";
require_once "conexion.php";

// Recogemos el ID del producto
$id = $_GET["id"];

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

// COUNT(*) cuenta cuántos registros cumplen la condición
// Comprobamos si el producto aparece en algún pedido
$sql = "SELECT COUNT(*) FROM detallepedido WHERE id_producto = ?";
$consulta = $conexion->prepare($sql);
$consulta->execute([$id]);

// fetchColumn() recoge el resultado de una consulta de una sola columna
$pedidos = $consulta->fetchColumn();

// Si aparece en algún pedido, no lo eliminamos
if ($pedidos > 0) {
    $error = "No se puede eliminar porque aparece en un pedido.";
} else {

    // DELETE FROM elimina registros de una tabla
    // WHERE indica qué producto queremos eliminar
    $sql = "DELETE FROM producto WHERE id_producto = ?";
    $consulta = $conexion->prepare($sql);
    $consulta->execute([$id]);

    // Volvemos al listado
    header("Location: gestionar_productos.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar producto - Little Chapters</title>
</head>
<body>
    
    <h1>Eliminar producto</h1>

    <p><?php echo htmlspecialchars($error); ?></p>

    <a href="gestionar_productos.php">Volver a productos</a>

</body>
</html>