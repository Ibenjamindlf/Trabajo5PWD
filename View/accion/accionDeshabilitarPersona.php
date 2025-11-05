<?php
include_once ("../../Controller/abmUsuario.php");

$idUsuario = $_GET['idusuario'];
// print_r($idUsuario);
$abmUsuario = new ABMusuario();

$seDeshabilito = $abmUsuario->deshabilitarUsuario($_GET);

if ($seDeshabilito){
    $message = 'Se deshabilito correctamente el usuario';
    header("Location: ../listarUsuario.php?Message=" . urlencode($message));
    exit;
} else {
    $message = 'Hubo un error al deshabilitar el usuario';
    header("Location: ../listarUsuario.php?Message=" . urlencode($message));
    exit;
}
?>