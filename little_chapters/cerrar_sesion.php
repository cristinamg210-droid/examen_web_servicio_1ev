<?php

session_start();

session_destroy();

header("Location: http://localhost/examen_web_servicio_1ev/little_chapters/login.php");

exit();

?>