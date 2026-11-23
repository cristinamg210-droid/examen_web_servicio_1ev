<?php

session_start();

// Comprobamos si el usuario ha iniciado sesión
if (!isset($_SESSION["id_usuario"])) {
    header("Location: login.php");
    exit();
}

// Comprobamos si el usuario es administrador
if ($_SESSION["rol"] != "admin") {
    echo "No tienes permiso para acceder a esta página.";
    exit();
}

?>
