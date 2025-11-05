<?php
include_once ("../Model/usuariorol.php");
include_once ("../Model/usuario.php");
include_once ("../Model/rol.php");
class abmUsuarioRol{
    /**
     * Modulo buscar
     * (funcion que permite buscar usuarios)
     * @param array $param
     * @return array
     */
    public function buscar($param){
        $where = " true ";
        if ($param != null){
            if (!empty($param['idusuario'])) {
                $idusuario = $param['idusuario'];
                $where .= " and idusuario ='$idusuario'";
            }
            if (!empty($param['idrol'])) {
                $idrol = $param['idrol'];
                $where .= " and idrol ='$idrol'";
            }
        }
        $arreglo = usuariorol::seleccionar($where);
        return $arreglo;
    }
    /**
     * Modulo cargarObjeto
     * (funcion para poder cargar atributos de la instacia Usuario)
     * @param array $param
     * @return Usuario|null
     */
    private function cargarObjeto($param) {
        $objUsuarioRol = null;

        if (
            array_key_exists('idusuario', $param) &&
            array_key_exists('idrol', $param)
        ) {
            $objUsuarioRol = new usuariorol();
            $objUsuarioRol->setear(
                $param['idusuario'],
                $param['idrol']
            );
        }
        return $objUsuarioRol;
    }
    /**
     * Modulo seteadosCamposClaves
     * (Evita errores como intentar modificar un registro sin identificarlo)
     * @param array $param
     * @return bool
     */
    private function seteadosCamposClaves($param){
        $resp = false;
        if (!empty($param['idusuario']) && !empty($param['idrol'])){
            $resp = true;
        }
        return $resp;
    }
        /**
     * Modulo cargarObjetoConClave
     * (Evita cargar datos innecesarios)
     * @param array $param
     * @return Usuario|null
     */
    private function cargarObjetoConClave($param){
        $objUsuarioRol = null;
        if (!empty($param['idusuario']) && !empty($param['idrol'])) {

            $objUsuario = new Usuario();
            $objRol = new Rol();

            $objUsuario->setIdUsuario($param['idusuario']);
            $objUsuario->cargar();

            $objRol->setIdRol($param['idrol']);
            $objRol->cargar();

            $objUsuarioRol = new usuariorol();
            $objUsuarioRol->setear($objUsuario,$objRol);
        }
        return $objUsuarioRol;
    }
    /**
     * Modulo modificacion
     * (Encapsula el proceso de actualizar datos de un usuario)
     * @param array $param
     * @return bool
     */
    public function modificacion($param){
        $resp = false;
        $lista = $this->buscar([
            'idusuario' => $param['idusuario'],
            'idrol' => $param['idrol']
        ]);
        if ($lista != null) {
            $objUsuario = new Usuario();
            $objRol = new Rol();

            $objUsuario->setIdUsuario($param['idusuario']);
            $objUsuario->cargar();

            $objRol->setIdRol($param['idrol']);
            $objRol->cargar();

            $objUsuarioRol = new usuariorol();
            $objUsuarioRol->setear($objUsuario,$objRol);
            if ($objUsuarioRol->modificar()) {
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
            $objUsuarioRol = $this->cargarObjetoConClave($param);
            if ($objUsuarioRol != null and $objUsuarioRol->eliminar()){
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

        $busquedaUsuarioRol = [
            "idusuario" => $param['idusuario'],
            "idrol" => $param['idrol']
        ];

        $existeUsuarioRol = $this->buscar($busquedaUsuarioRol);

        if ($existeUsuarioRol == null) {
            $objUsuarioRol = $this->cargarObjeto($param);
            if ($objUsuarioRol != null && $objUsuarioRol->insertar()) {
                $resp = true;
            }
        }
        return $resp;
    }
}