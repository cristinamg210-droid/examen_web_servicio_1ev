
<?php

session_start();

// Comprobamos que el usuario haya iniciado sesión
if (!isset($_SESSION["id_usuario"])) {
    header("Location: login.php");
    exit();
}

// Comprobamos que el usuario sea administrador
if ($_SESSION["rol"] != "admin") {
    header("Location: inicio.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Administración - Little Chapters</title>

    <!-- Conectamos el archivo CSS -->
    <link rel="stylesheet" href="estilos.css">
</head>

<body class="pagina-admin">

    <!-- Cabecera -->
    <header class="cabecera-panel">

        <div class="logo-panel">
            <h1>Little Chapters</h1>
            <p>Panel de administración</p>
        </div>

        <a href="cerrar_sesion.php">Cerrar sesión</a>

    </header>


    <!-- Contenido principal -->
    <main class="panel-main">

        <div class="panel-bienvenida">

            <h2>¡Bienvenida al panel de administración!</h2>

            <p>
                Hola, <?php echo htmlspecialchars($_SESSION["nombre"]); ?>
            </p>

            <p>
                Desde aquí puedes gestionar los productos y consultar los pedidos de Little Chapters.
            </p>

        </div>


        <!-- Opciones de administración -->
        <div class="opciones-panel">

            <!-- Gestión de productos -->
            <div class="opcion-panel">

                <h3>Productos</h3>

                <p>
                    Añade nuevos productos, modifica su información o elimina los que ya no estén disponibles.
                </p>

                <a href="gestionar_productos.php">
                    Gestionar productos
                </a>

            </div>


            <!-- Gestión de pedidos -->
            <div class="opcion-panel">

                <h3>Pedidos</h3>

                <p>
                    Consulta los pedidos realizados por los clientes y revisa su información y estado.
                </p>

                <a href="gestionar_pedidos.php">
                    Consultar pedidos
                </a>

            </div>

        </div>

        <!-- Acceso al catálogo -->
        <div class="volver-catalogo">

            <a href="catalogo.php">Volver al catálogo</a>

        </div>

    </main>


    <!-- Pie de página -->
    <footer class="pie-panel">

        <p>Little Chapters - Lectura, Papelería y Decoración</p>

    </footer>

</body>
</html>
