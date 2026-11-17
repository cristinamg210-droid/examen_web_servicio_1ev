
<?php

class Usuario { //Crea nuestra clase

    // Guardamos la conexión con la base de datos
    private $conexion;

    // Recibimos la conexión al crear un objeto
    public function __construct($conexion) {      //_construct = prepara el objeto y recibe la conexión a la base de datos.
        $this->conexion = $conexion;
    }

    // Registramos un usuario nuevo
    public function registrar($nombre, $email, $contrasena) {    //registrar() = comprueba si existe el correo y registra al usuario.

        // Comprobamos si el correo ya existe
        $sql = "SELECT * FROM usuario WHERE email = ?";
        $consulta = $this->conexion->prepare($sql);
        $consulta->execute([$email]);

        if ($consulta->rowCount() > 0) {
            return false;
        }

        // Encriptamos la contraseña
        $contrasena = password_hash($contrasena, PASSWORD_DEFAULT);

        // Guardamos el usuario en la base de datos
        $sql = "INSERT INTO usuario (nombre, email, contrasena, rol)
                VALUES (?, ?, ?, ?)";

        $consulta = $this->conexion->prepare($sql);

        $consulta->execute([
            $nombre,
            $email,
            $contrasena,
            "cliente"
        ]);

        return true;
    }

    // Comprobamos el inicio de sesión
    public function iniciarSesion($email, $contrasena) {   //iniciarSesion() = comprueba el correo y la contraseña.

        $sql = "SELECT * FROM usuario WHERE email = ?";
        $consulta = $this->conexion->prepare($sql);
        $consulta->execute([$email]);

        $usuario = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {

            if (password_verify($contrasena, $usuario["contrasena"])) {
                return $usuario;
            }
        }

        return false;
    }
}

?>
