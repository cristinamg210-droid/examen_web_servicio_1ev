<?php

// Comprobamos que el usuario sea administrador
require_once "comprobar_admin.php";

// Conectamos con la base de datos
require_once "conexion.php";

// Consultamos los pedidos y los nombres de los clientes
$sql = "SELECT pedido.id_pedido, usuario.nombre, pedido.fecha, pedido.total, pedido.estado
        FROM pedido
        INNER JOIN usuario
        ON pedido.id_usuario = usuario.id_usuario";

// Ejecutamos la consulta
$consulta = $conexion->query($sql);

// Guardamos los pedidos en un array
$pedidos = $consulta->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos - Little Chapters</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

    <!-- Cabecera del administrador -->
    <header class="admin-header">

        <!-- Nombre de la tienda y panel de administración -->
        <div class="admin-logo">

            <h1>Little Chapters</h1>

            <p>Panel de administración</p>

        </div>

        <!-- Enlace para cerrar sesión -->
        <a href="cerrar_sesion.php">Cerrar sesión</a>

    </header>

    <!-- Zona principal -->
    <main class="admin-main">

        <!-- Menú lateral -->
        <aside class="admin-menu">

            <!-- Página en la que estamos actualmente -->
            <a href="gestionar_productos.php">Productos</a>

            <a href="gestionar_pedidos.php" class="menu-activo">Pedidos</a>

        </aside>

        <!-- Contenido de pedidos -->
        <section class="admin-content">

            <div class="admin-titulo">

                <h2>Pedidos</h2>

            </div>

            <!-- Tabla de pedidos -->
            <table class="tabla-productos">

                <tr>
                    <th>Nº pedido</th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Estado</th>
                </tr>

                <?php
                // Recorremos todos los pedidos
                foreach ($pedidos as $pedido) {
                ?>

                    <tr>

                        <!-- Número del pedido -->
                        <td>
                            #<?php echo $pedido["id_pedido"]; ?>
                        </td>

                        <!-- Nombre del cliente -->
                        <td>
                            <?php echo htmlspecialchars($pedido["nombre"]); ?>
                        </td>

                        <!-- Fecha del pedido -->
                        <td>
                            <?php echo date("d/m/Y", strtotime($pedido["fecha"])); ?>
                        </td>

                        <!-- Total del pedido -->
                        <td>
                            <?php echo number_format($pedido["total"], 2, ",", "."); ?> €
                        </td>

                        <!-- Estado del pedido -->
                        <td>

                            <?php
                            // Comprobamos el estado del pedido
                            if ($pedido["estado"] == "Entregado") {
                                $clase_estado = "estado-entregado";
                            } elseif ($pedido["estado"] == "En preparación") {
                                $clase_estado = "estado-preparacion";
                            } elseif ($pedido["estado"] == "Enviado") {
                                $clase_estado = "estado-enviado";
                            } else {
                                $clase_estado = "estado-otro";
                            }
                            ?>

                            <span class="estado-pedido <?php echo $clase_estado; ?>">
                                <?php echo htmlspecialchars($pedido["estado"]); ?>
                            </span>

                        </td>

                    </tr>

                <?php
                }
                ?>

            </table>

        </section>

    </main>

</body>
</html>