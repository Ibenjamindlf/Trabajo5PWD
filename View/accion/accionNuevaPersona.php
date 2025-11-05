<?php
include_once ("../../Controller/abmUsuario.php");

$datos = $_POST;
$abmUsuario = new ABMusuario();

$seRegistro = $abmUsuario->alta($datos);

if ($seRegistro){
    $message = 'Se cargo correctamente el usuario';
    header("Location: ../listarUsuario.php?Message=" . urlencode($message));
    exit;
} else {
    $message = 'Hubo un error al registrar el usuario';
    header("Location: ../listarUsuario.php?Message=" . urlencode($message));
    exit;
}
?>