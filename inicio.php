<?php

session_start();

// Comprobamos si el usuario ha iniciado sesión
if (!isset($_SESSION["id_usuario"])) {
    header("Location: login.php");
    exit();
}

// Conectamos con la base de datos
require_once "conexion.php";

// Consultamos las categorías para mostrarlas en el menú
$sql = "SELECT * FROM categoria";
$consulta = $conexion->query($sql);
$categorias = $consulta->fetchAll();

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Little Chapters</title>
    <link rel="stylesheet" href="estilos.css">
    <link rel="stylesheet" href="estilos_catalogo.css">
</head>
<body class="pagina-catalogo">

    <!-- Franja superior -->
    <div class="franja-superior">

        <p>Envíos gratuitos a partir de 35€</p>

        <div class="enlaces-superiores">
            <a href="inicio.php">Mi cuenta</a>
            <a href="#">Carrito (0)</a>
            <a href="cerrar_sesion.php">Cerrar sesión</a>
        </div>

    </div>


    <!-- Cabecera del catálogo -->
    <header class="cabecera-catalogo">

        <!-- Logo -->
        <div class="logo-catalogo">
            <h1>Little Chapters</h1>
            <p>Lectura - Papelería - Decoración</p>
        </div>

        <!-- Menú y buscador -->
        <div class="navegacion-catalogo">

            <nav class="menu-catalogo">

                <a href="catalogo.php">Inicio</a>

                <?php foreach ($categorias as $categoria) { ?>

                    <a href="catalogo.php?id_categoria=<?php echo $categoria["id_categoria"]; ?>">
                        <?php echo htmlspecialchars($categoria["nombre"]); ?>
                    </a>

                <?php } ?>

            </nav>

        </div>

    </header>


    <!-- Contenido de la cuenta -->
    <main class="cuenta-main">

        <div class="cuenta-tarjeta">

            <?php if ($_SESSION["rol"] == "admin") { ?>

                <h2>¡Bienvenido/a a Little Chapters!</h2>

                <p class="cuenta-saludo">
                    Hola, <?php echo htmlspecialchars($_SESSION["nombre"]); ?>
                </p>

                <p class="cuenta-mensaje">
                    Has iniciado sesión correctamente.
                </p>

                <div class="cuenta-separador"></div>

                <h3>Panel de administración</h3>

                <p>
                    Desde aquí podrás gestionar los productos y consultar los pedidos de la tienda.
                </p>

                <span class="cuenta-rol">Administrador</span>

                <a class="cuenta-boton" href="prueba_admin.php">
                    Acceder a administración
                </a>

            <?php } else { ?>

                <h2>¡Bienvenida a Little Chapters!</h2>

                <p class="cuenta-saludo">
                    Hola, <?php echo htmlspecialchars($_SESSION["nombre"]); ?>
                </p>

                <p class="cuenta-mensaje">
                    Has iniciado sesión correctamente.
                </p>

                <div class="cuenta-separador"></div>

                <h3>Tu espacio personal</h3>

                <p>
                    Desde aquí podrás consultar nuestro catálogo y realizar tus pedidos.
                </p>

                <span class="cuenta-rol">Cliente</span>

                <a class="cuenta-boton" href="catalogo.php">
                    Descubrir productos
                </a>

            <?php } ?>

            <a class="cuenta-cerrar" href="cerrar_sesion.php">
                Cerrar sesión
            </a>

        </div>

    </main>


    <!-- Pie de página -->
    <footer class="pie-catalogo">

        <div class="novedades-catalogo">

            <div class="texto-novedades">
                <p>Gracias por formar parte de Little Chapters</p>
            </div>

        </div>

    </footer>


</body>
</html>
