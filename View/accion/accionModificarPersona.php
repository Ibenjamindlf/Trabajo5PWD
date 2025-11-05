<?php
include_once ("../../Controller/abmUsuario.php");

$datos = $_POST;
$abmUsuario = new ABMusuario();

$seModifico = $abmUsuario->modificacion($datos);

if ($seModifico){
    $message = 'Se modifico correctamente el usuario';
    header("Location: ../listarUsuario.php?Message=" . urlencode($message));
    exit;
} else {
    $message = 'Hubo un error al modificar el usuario';
    header("Location: ../listarUsuario.php?Message=" . urlencode($message));
    exit;
}
?>