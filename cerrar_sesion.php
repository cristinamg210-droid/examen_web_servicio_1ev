
<?php

session_start();

// Cerramos la sesión del usuario
session_destroy();

// Volvemos a la página de inicio de sesión
header("Location: login.php");

exit();

?>
