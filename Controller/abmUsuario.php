<?php
// include_once("../Model/usuario.php");
include_once(__DIR__ . '/../Model/usuario.php');


class ABMusuario {
    /**
     * Modulo buscar
     * (funcion que permite listar o buscar usuarios)
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
            if (!empty($param['usnombre'])) {
                $usnombre = $param['usnombre'];
                $where .= " and usnombre ='$usnombre'";
            }
            if (!empty($param['uspass'])) {
                $uspass = $param['uspass'];
                $where .= " and uspass ='$uspass'";
            }
            if (!empty($param['usmail'])) {
                $usmail = $param['usmail'];
                $where .= " and usmail ='$usmail'";
            }
        }
        $arreglo = Usuario::seleccionar($where);
        return $arreglo;
    }
    /**
     * Modulo cargarObjeto
     * (funcion para poder cargar atributos de la instacia Usuario)
     * @param array $param
     * @return Usuario|null
     */
    private function cargarObjeto($param) {
        $objUsuario = null;

        // Verificamos que estén definidos los campos mínimos necesarios
        if (
            array_key_exists('usnombre', $param) &&
            array_key_exists('uspass', $param) &&
            array_key_exists('usmail', $param)
        ) {
            // Creamos el objeto de la clase Usuario
            $objUsuario = new Usuario();

            // Cargamos los valores con los datos del array $param
            // Si tu clase tiene un método setear() lo podés usar directo
            $objUsuario->setear(
                isset($param['idusuario']) ? $param['idusuario'] : null,
                $param['usnombre'],
                $param['uspass'],
                $param['usmail']
            );
        }

        // Retorna el objeto ya cargado o null si faltaban datos
        return $objUsuario;
    }
    /**
     * Modulo seteadosCamposClaves
     * (Evita errores como intentar modificar un registro sin identificarlo)
     * @param array $param
     * @return bool
     */
    private function seteadosCamposClaves($param){
        $resp = false;
        if (isset($param['idusuario'])){
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
        $objUsuario = null;
        if (isset($param['idusuario'])) {
            $objUsuario = new Usuario();
            $objUsuario->setear($param['idusuario'], null, null, null, null);
        }
        return $objUsuario;
    }
    /**
     * Modulo modificacion
     * (Encapsula el proceso de actualizar datos de un usuario)
     * @param array $param
     * @return bool
     */
    public function modificacion($param){
        $resp = false;
        $lista = $this->buscar(['idusuario' => $param['idusuario']]);
        if ($lista != null) {
            $objUsuario = new Usuario();
            $objUsuario->setear($param['idusuario'], $param['usnombre'], $param['uspass'], $param['usmail']);

            if ($objUsuario->modificar()) {
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
            $objUsuario = $this->cargarObjetoConClave($param);
            if ($objUsuario != null and $objUsuario->eliminar()){
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

        // Evita duplicar usuarios con mismo nombre o mail
        $busquedaUsuario = [
            "usnombre" => $param['usnombre'],
            "usmail" => $param['usmail']
        ];

        $existeUsuario = $this->buscar($busquedaUsuario);

        // Si no existe, lo crea
        if ($existeUsuario == null) {
            $objUsuario = $this->cargarObjeto($param);
            if ($objUsuario != null && $objUsuario->insertar()) {
                $resp = true;
            }
        }

        return $resp;
    }

    /**
     * Modulo deshabilitarUsuario
     * ("baja logica", evita perder datos historicos, en caso de que ya estuviese deshabilitado, lo vuelve a habilitar)
     * @param array $param
     * @return bool
     */

    public function deshabilitarUsuario($param)
    {
        $resp = false;
        $objUsuario = $this->cargarObjetoConClave($param);
        $listadoUsuarios = $objUsuario->seleccionar("idusuario=" . $param['idusuario']);
        if (count($listadoUsuarios) > 0) {
            $estadoUsuario = $listadoUsuarios[0]->getUsdeshabilitado();
            if (is_null($estadoUsuario) || $estadoUsuario == '0000-00-00 00:00:00') {
                if ($objUsuario->estado(date("Y-m-d H:i:s"))) {
                    $resp = true;
                }
            } else {
                if ($objUsuario->estado(NULL)) {
                    $resp = true;
                }
            }
        }
        return $resp;
    }
}
?>