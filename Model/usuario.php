<?php

include_once ("database/database.php");

class Usuario {
    private $idusuario;
    private $usnombre;
    private $uspass;
    private $usmail;
    private $usdeshabilitado;
    private $mensajeOperacion;

    public function __construct() {
        $this->idusuario = "";
        $this->usnombre = "";
        $this->uspass = "";
        $this->usmail = "";
        $this->usdeshabilitado = "";
        $this->mensajeOperacion = "";
    }

    // ----------- GETTERS -----------

    public function getIdusuario() {
        return $this->idusuario;
    }

    public function getUsnombre() {
        return $this->usnombre;
    }

    public function getUspass() {
        return $this->uspass;
    }

    public function getUsmail() {
        return $this->usmail;
    }

    public function getUsdeshabilitado() {
        return $this->usdeshabilitado;
    }

    public function getMensajeOperacion() {
        return $this->mensajeOperacion;
    }

    // ----------- SETTERS -----------

    public function setIdusuario($idusuario) {
        $this->idusuario = $idusuario;
    }

    public function setUsnombre($usnombre) {
        $this->usnombre = $usnombre;
    }

    public function setUspass($uspass) {
        $this->uspass = $uspass;
    }

    public function setUsmail($usmail) {
        $this->usmail = $usmail;
    }

    public function setUsdeshabilitado($usdeshabilitado) {
        $this->usdeshabilitado = $usdeshabilitado;
    }

    public function setMensajeOperacion($mensajeOperacion) {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    public function setear($idusuario, $usnombre, $uspass, $usmail, $usdeshabilitado = null) {
        $this->setIdusuario($idusuario);
        $this->setUsnombre($usnombre);
        $this->setUspass($uspass);
        $this->setUsmail($usmail);
        $this->setUsdeshabilitado($usdeshabilitado);
    }

    /**
     * Modulo cargar
     * (funcion para cargar un registro de la tabla usuario)
     * @return bool
     */
    public function cargar(){
        $resp = false;
        $database = new dataBase();
        $sql = "SELECT * FROM usuario WHERE idusuario=" . $this->getIdusuario();

        if($database->Iniciar()) {
            $resp = $database->Ejecutar($sql);
            if ($resp > -1){
                if ($resp > 0){
                    $row = $database->Registro();
                    $this->setear($row['idusuario'],$row['usnombre'],$row['uspass'],$row['usmail'],$row['usdeshabilitado']);
                }
            }
        } else {
            $this->setMensajeOperacion("usuario->cargar: ". $database->getError());
        }
        return $resp;
    }
    /**
     * Modulo insertar
     * (funcion que inserta un usuario a la BD)
     * @return bool
     */
    public function insertar(){
        $resp = false;
        $database = new dataBase();
            $usnombre = $this->getUsnombre();
            $uspass = $this->getUspass();
            $usmail = $this->getUsmail();
            $usdeshabilitado = $this->getUsdeshabilitado();
            $sql = "INSERT INTO usuario (usnombre, uspass, usmail, usdeshabilitado) VALUES ('$usnombre', '$uspass', '$usmail', NULL)";
        
        if ($database->Iniciar()) {
            if ($elid = $database->Ejecutar($sql)) {
                $this->setIdusuario($elid);
                $resp = true;
            } else {
                $this->setMensajeOperacion("usuario->insertar: " . $database->getError());
            }
        } else {
            $this->setMensajeOperacion("usuario->insertar: " . $database->getError());
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
            $idusuario = $this->getIdusuario();
            $usnombre = $this->getUsnombre();
            $uspass = $this->getUspass();
            $usmail = $this->getUsmail();
            $usdeshabilitado = $this->getUsdeshabilitado();
                            // usdeshabilitado = '$usdeshabilitado'
        $sql = "UPDATE usuario 
            SET usnombre = '$usnombre',
                uspass = '$uspass',
                usmail = '$usmail'
            WHERE idusuario = $idusuario;";
        if ($database->Iniciar()) {
            if ($database->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("usuarios->modificar: " . $database->getError());
            }
        } else {
            $this->setMensajeOperacion("usuarios->modificar: " . $database->getError());

        }
        return $resp;
    }

    /**
     * Modulo estado
     * (funcion encargada de actualizar el estado del borrado logico)
     * @param string|null $param
     * @return bool
     */
        public function estado($param = ""){
        $resp = false;
        $base = new dataBase();
        $sql = "UPDATE usuario SET usdeshabilitado='" . $param . "' WHERE idusuario=" . $this->getIdusuario();

        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("usuario->estado: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("usuario->estado: " . $base->getError());
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
        $sql = "DELETE FROM usuario WHERE idusuario=" . $this->getIdusuario();

        if ($database->Iniciar()) {
            if ($database->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("usuario->eliminar: " . $database->getError());
            }
        } else {
            $this->setMensajeOperacion("usuario->eliminar: " . $database->getError());
        }
        return $resp;
    }
    /**
     * Modulo seleccionar
     * (modulo que permite seleccionar en la BD)
     * @param string $condicion
     * @return array
     */
    public static function seleccionar($condicion = ""){
        $arrayUsuarios = array();
        $database = new dataBase();
        $sql = "SELECT * FROM usuario ";

        if ($condicion != ""){
            $sql .= 'WHERE ' . $condicion;
        }

        $res = $database->Ejecutar($sql);

        if ($res>-1) {
            if ($res > 0) {
                while ($row = $database->Registro()) {
                    $unUsuario = new Usuario();
                    $unUsuario->setear($row['idusuario'],$row['usnombre'],$row['uspass'],$row['usmail'],$row['usdeshabilitado']);
                    array_push($arrayUsuarios,$unUsuario);
                }
            }
        } else {
            $this->setMensajeOperacion("usuario->seleccionar: " . $database->getError());
        }
        return $arrayUsuarios;
    }
}
?>