<?php

include_once ("database/database.php");

class rol {
    private $idrol;
    private $roldescripcion;
    private $mensajeOperacion;

    public function __construct() {
        $this->idrol = "";
        $this->roldescripcion = "";
        $this->mensajeOperacion = "";
    }

    // Getters
    public function getIdrol() {
        return $this->idrol;
    }

    public function getRoldescripcion() {
        return $this->roldescripcion;
    }

    public function getMensajeOperacion() {
        return $this->mensajeOperacion;
    }

    // Setters
    public function setIdrol($idrol) {
        $this->idrol = $idrol;
    }

    public function setRoldescripcion($roldescripcion) {
        $this->roldescripcion = $roldescripcion;
    }

    public function setMensajeOperacion($mensajeOperacion) {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    // Función para setear los valores
    public function setear($idrol, $roldescripcion) {
        $this->setIdrol($idrol);
        $this->setRoldescripcion($roldescripcion);
    }

    /**
     * Modulo cargar
     * (funcion para cargar un registro de la tabla usuario)
     * @return bool
     */
    public function cargar(){
        $resp = false;
        $database = new dataBase();
        $sql = "SELECT * FROM rol WHERE idrol=" . $this->getIdrol();

        if ($database->Iniciar()) {
            $resp = $database->Ejecutar($sql);
            if ($resp > -1){
                if ($resp > 0){
                    $row = $database->Registro();
                    $this->setear($row['idrol'], $row['roldescripcion']);
                }
            }
        } else {
            $this->setMensajeOperacion("rol->cargar: " . $database->getError());
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
            $roldescripcion = $this->getRoldescripcion();
        $sql = "INSERT INTO rol (roldescripcion) VALUES ('$roldescripcion')";

        if ($database->Iniciar()) {
            if ($elid = $database->Ejecutar($sql)) {
                $this->setIdrol($elid);
                $resp = true;
            } else {
                $this->setMensajeOperacion("rol->insertar: " . $database->getError());
            }
        } else {
            $this->setMensajeOperacion("rol->insertar: " . $database->getError());
        }
        return $resp;
    }
    /**
     * Modulo modificar
     * (funcion para modificar un rol en la BD)
     * @return bool
     */
    public function modificar(){
        $resp = false;
        $database = new dataBase();
            $idrol = $this->getIdrol();
            $roldescripcion = $this->getRoldescripcion();
        $sql = "UPDATE rol
            SET roldescripcion = '$roldescripcion'
            WHERE idrol = $idrol;";
        if ($database->Iniciar()) {
            if ($database->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("rol->modificar: " . $database->getError());
            }
        } else {
            $this->setMensajeOperacion("rol->modificar: " . $database->getError());
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
        $sql = "DELETE FROM rol WHERE idrol=" . $this->getIdrol();

        if ($database->Iniciar()) {
            if ($database->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("rol->eliminar: " . $database->getError());
            }
        } else {
            $this->setMensajeOperacion("rol->eliminar: " . $database->getError());
        }
        return $resp;
    }
    /**
     * Modulo seleccionar
     * (funcion que permite seleccionar en la BD)
     * @return array
     */
    public static function seleccionar($condicion = ""){
        $arrayRoles = array();
        $database = new dataBase();
        $sql = "SELECT * FROM rol ";

        if ($condicion != ""){
            $sql .= 'WHERE ' . $condicion;
        }

        $res = $database->Ejecutar($sql);

        if ($res>-1){
            if ($res>0){
                while ($row = $database->Registro()) {
                    $unRol = new rol();
                    $unRol->setear($row['idrol'], $row['roldescripcion']);
                    array_push($arrayRoles,$unRol);
                }
            }
        } else {
            $this->setMensajeOperacion("rol->seleccionar: " . $database->getError());
        }
        return $arrayRoles;
    }
}