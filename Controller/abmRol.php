<?php
include_once("../Model/rol.php");
class abmRol {
    /**
     * Modulo buscar
     * (funcion que permite listar o buscar usuarios)
     * @param array $param
     * @return bool
     */
    public function buscar($param){
        $where = " true ";
        if ($param != null){
            if (!empty($param['idrol'])) {
                $idrol = $param['idrol'];
                $where .= " and idrol = '$idrol'";
            }
            if (!empty($param['roldescripcion'])) {
                $roldescripcion = $param['roldescripcion'];
                $where .= " and roldescripcion ='$roldescripcion'";
            }
        }
        $arreglo = rol::seleccionar($where);
        return $arreglo;
    }
    /**
     * Módulo cargarObjeto
     * (función para poder cargar atributos de la instancia Rol)
     * @param array $param
     * @return Rol|null
     */
    private function cargarObjeto($param) {
        $objRol = null;

        // Si existe idrol o roldescripcion, creamos el objeto
        if (array_key_exists('idrol', $param) || array_key_exists('roldescripcion', $param)) {
            $objRol = new Rol();
            $objRol->setear(
                $param['idrol'] ?? null,
                $param['roldescripcion'] ?? null
            );
        }
        return $objRol;
    }
    /**
     * Modulo seteadosCamposClaves
     * (Evita errores como intentar modificar un registro sin identificarlo)
     * @param array $param
     * @return bool
     */
    private function seteadosCamposClaves($param){
        $resp = false;
        if (isset($param['idrol'])){
            $resp = true;
        }
        return $resp;
    }
    /**
     * Modulo cargarObjetoConClave
     * (Evita cargar datos innecesarios)
     * @param array $param
     * @return Rol|null
     */
    private function cargarObjetoConClave($param){
        $objRol = null;
        if (isset($param['idrol'])) {
            $objRol = new rol();
            $objRol->setear($param['idrol'],null);
        }
        return $objRol;
    }
    /**
     * Modulo modificacion
     * (Encapsula el proceso de actualizar datos de un usuario)
     * @param array $param
     * @return bool
     */
    public function modificar($param){
        $resp = false;
        $lista = $this->buscar(['idrol' => $param['idrol']]);
        if ($lista != null) {
            $objRol = new rol();
            $objRol->setear($param['idrol'], $param['roldescripcion']);

            if ($objRol->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }
    /**
     * Modulo baja
     * (Maneja la eliminación, asegurándose de tener el ID y el objeto correcto)
     * @param array $param
     * @return bool
     */
    public function baja($param){
        $resp = false;

        if ($this->seteadosCamposClaves($param)){
            $objRol = $this->cargarObjetoConClave($param);
            if ($objRol != null and $objRol->eliminar()){
                $resp = true;
            }
        }
        return $resp;
    }
    /**
     * Modulo alta
     * (Es el flujo completo de "crear usuario", de forma ordenada)
     * @param array $param
     * @return bool
     */
    public function alta($param){
        $resp = false;

        $busquedaRol = [
            "roldescripcion" => $param['roldescripcion']
        ];

        $existeRol = $this->buscar($busquedaRol);

        if ($existeRol == null) {
            $objRol = $this->cargarObjeto($param);
            if ($objRol != null && $objRol->insertar()){
                $resp = true;
            }
        }
        return $resp;
    }
}

?>