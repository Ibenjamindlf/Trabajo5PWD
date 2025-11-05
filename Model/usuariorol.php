<?php
include_once ("database/database.php");
include_once ("rol.php");
include_once ("usuario.php");
class usuariorol {
    private $objUsuario; // Se almacena el obj
    private $objRol; // Se almacena el obj
    private $mensajeOperacion;

    public function __construct() {
        $this->objUsuario = null;
        $this->objRol = null;
        $this->mensajeOperacion = "";
    }

    // Getters
    public function getObjUsuario() {
        return $this->objUsuario;
    }

    public function getObjRol() {
        return $this->objRol;
    }

    public function getMensajeOperacion() {
        return $this->mensajeOperacion;
    }

    // Setters
    public function setObjUsuario($objUsuario) {
        $this->objUsuario = $objUsuario;
    }

    public function setObjRol($objRol) {
        $this->objRol = $objRol;
    }

    public function setMensajeOperacion($mensajeOperacion) {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    // Método para setear los valores de los atributos
    public function setear($objUsuario, $objRol) {
        $this->setObjUsuario($objUsuario);
        $this->setObjRol($objRol);
    }

    /**
     * Modulo cargar
     * (funcion para cargar un registro de la tabla usuario)
     * @return bool
     */
    public function cargar(){
        $resp = false;
        $database = new dataBase();
            $objUsuario = $this->getObjUsuario();
            $idUsuario = $objUsuario->getIdusuario();
            $objRol = $this->getObjRol();
            $idRol = $objRol->getIdrol();
        $sql = "SELECT * FROM usuariorol WHERE idusuario= $idUsuario AND idrol= $idRol";

        if ($database->Iniciar()) {
            $resp = $database->Ejecutar($sql);
            if ($resp > -1){
                if ($resp > 0){
                    $row = $database->Registro();
                    // Creamos los objetos relacionados
                    $objUsuario = new Usuario();
                    $objUsuario->setIdusuario($row['idusuario']);
                    $objUsuario->cargar(); // carga completa del usuario

                    $objRol = new Rol();
                    $objRol->setIdrol($row['idrol']);
                    $objRol->cargar(); // carga completa del rol

                    // Seteamos los datos en el objeto actual
                    $this->setear(
                        $objUsuario,
                        $objRol
                    );

                    $resp = true;
                }
            }
        } else {
            $this->setMensajeOperacion("usuariorol->cargar: ". $database->getError());
        }
        return $resp;
    }
    /**
     * Modulo insertar
     * (funcion para insertar un rol en la BD)
     * @return bool
     */
    public function insertar(){
        $resp = false;
        $database = new dataBase();
            $objUsuario = $this->getObjUsuario();
            $idUsuario = $objUsuario->getIdusuario();
            $objRol = $this->getObjRol();
            $idRol = $objRol->getIdrol();
        $sql = "INSERT INTO usuariorol (idusuario, idrol) VALUES ($idUsuario, $idRol)";

        if ($database->Iniciar()) {
            if ($database->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("UsuarioRol->insertar: " . $database->getError());
            }
        } else {
            $this->setMensajeOperacion("UsuarioRol->insertar: " . $database->getError());
        }

        return $resp;
    }
    /**
     * Modulo modificar
     * (funcion para modificar un usuario en la BD)
     * @return bool
     */
    public function modificar(){
        $resp = false;
        $database = new dataBase();
            $objUsuario = $this->getObjUsuario();
            $idUsuario = $objUsuario->getIdusuario();
            $objRol = $this->getObjRol();
            $idRol = $objRol->getIdrol();
        $sql = "UPDATE usuariorol
            SET idusuario = $idUsuario, 
                idrol = $idRol
            WHERE idusuario = $idUsuario AND
                idrol = $idRol;";
        if ($database->Iniciar()) {
            if ($database->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("usuariorol->modificar: " . $database->getError());
            }
        } else {
            $this->setMensajeOperacion("usuariorol->modificar: " . $database->getError());
        }
        return $resp;
    }
    /**
     * Modulo eliminar
     * (funcion que permite eliminar un registro de la BD)
     * @return bool
     */
    public function eliminar(){
        $resp = false;
        $database = new dataBase();
            $objUsuario = $this->getObjUsuario();
            $idUsuario = $objUsuario->getIdusuario();
            $objRol = $this->getObjRol();
            $idRol = $objRol->getIdrol();
        $sql = "DELETE FROM usuariorol WHERE idusuario= $idUsuario AND idrol= $idRol";

        if ($database->Iniciar()) {
            if ($database->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("usuariorol->eliminar: " . $database->getError());
            }
        } else {
            $this->setMensajeOperacion("usuariorol->eliminar: " . $database->getError());
        }
        return $resp;
    }
    /**
     * Modulo seleccionar
     * (modulo que permite seleccionar en la BD)
     * @return array
     */
    public static function seleccionar($condicion = "") {
        $arrayUsuarioRol = array();
        $database = new dataBase();
        $sql = "SELECT * FROM usuariorol ";

        if ($condicion != "") {
            $sql .= 'WHERE ' . $condicion;
        }

        $res = $database->Ejecutar($sql);

        if ($res > -1) {
            if ($res > 0) {
                while ($row = $database->Registro()) {

                    // 1 Crear objetos vacíos de Usuario y Rol
                    $objUsuario = new Usuario();
                    $objRol = new Rol();

                    // 2 Cargar cada objeto según su ID
                    $objUsuario->setIdUsuario($row['idusuario']);
                    $objUsuario->cargar();

                    $objRol->setIdRol($row['idrol']);
                    $objRol->cargar();

                    // 3 Crear el objeto UsuarioRol y setear los objetos cargados
                    $unUsuarioRol = new UsuarioRol();
                    $unUsuarioRol->setear($objUsuario, $objRol);

                    array_push($arrayUsuarioRol, $unUsuarioRol);
                }
            }
        } else {
            // ⚠️ No se puede usar $this porque estás en un método estático
            // Mejor devolvés un array vacío o lanzás excepción, o retornás null
            $this->setMensajeOperacion("UsuarioRol->seleccionar: " . $database->getError());
        }

        return $arrayUsuarioRol;
    }

}