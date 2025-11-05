<?php
include_once ("../Model/usuario.php");
class Session {

    /**
     * Constructor que inicia la sesión si no está iniciada
     */
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Inicia la sesión con los valores de usuario y contraseña
     * @param string $nombreUsuario
     * @param string $psw
     * @return bool
     */
    public function iniciar($nombreUsuario, $psw) {
        $seInicio = false;
        // Creamos la condición para buscar al usuario en la BD
        $where = "usnombre = '$nombreUsuario' AND uspass = '$psw'";

        // Buscamos con el método seleccionar del ORM Usuario
        $usuarios = Usuario::seleccionar($where);

        if (count($usuarios) > 0) {
            $usuario = $usuarios[0]; // El primer usuario encontrado

            // Guardamos los datos en sesión
            $_SESSION['idusuario'] = $usuario->getIdusuario();
            $_SESSION['nombreusuario'] = $usuario->getUsnombre();
            $_SESSION['usmail'] = $usuario->getUsmail();
            $_SESSION['activa'] = true;

            // Si tenés relación con Rol:
            // $_SESSION['rol'] = $usuario->getObjRol()->getDescripcion();

            $seInicio = true;
        }

        return $seInicio;
    }

    /**
     * Valida si la sesión actual tiene usuario y psw válidos
     * @return bool
     */
    public function validar() {
        if ($this->activa()) {
            if (isset($_SESSION['nombreusuario']) && isset($_SESSION['rol'])) {
                return true;
            }
        }
        return false;
    }

    /**
     * Devuelve true o false si la sesión está activa o no
     * @return bool
     */
    public function activa() {
        return (isset($_SESSION['activa']) && $_SESSION['activa'] === true);
    }

    /**
     * Devuelve el usuario logueado
     * @return string|null
     */
    public function getUsuario() {
        if ($this->activa()) {
            return $_SESSION['nombreusuario'];
        }
        return null;
    }

    /**
     * Devuelve el rol del usuario logueado
     * @return string|null
     */
    public function getRol() {
        if ($this->activa()) {
            return $_SESSION['rol'];
        }
        return null;
    }

    /**
     * Cierra la sesión actual
     */
    public function cerrar() {
        $_SESSION = array();
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
    }
}
?>
