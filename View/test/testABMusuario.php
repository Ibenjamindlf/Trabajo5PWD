<?php
include_once("../Controller/abmUsuario.php");
$abmUsuario = new AbmUsuario();
$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'];

    switch ($accion) {
        case 'alta':
            if ($abmUsuario->alta($_POST)) {
                $mensaje = "✅ Usuario creado correctamente.";
            } else {
                $mensaje = "❌ Error al crear el usuario (posiblemente ya exista).";
            }
            break;

        case 'modificacion':
            if ($abmUsuario->modificacion($_POST)) {
                $mensaje = "✅ Usuario modificado correctamente.";
            } else {
                $mensaje = "❌ Error al modificar el usuario.";
            }
            break;

        case 'baja':
            if ($abmUsuario->baja($_POST)) {
                $mensaje = "🗑️ Usuario eliminado correctamente.";
            } else {
                $mensaje = "❌ Error al eliminar el usuario.";
            }
            break;

        case 'buscar':
            $usuarios = $abmUsuario->buscar($_POST);
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Test ABM Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h1 class="mb-4 text-center">🧩 Test ABM Usuario</h1>

    <?php if (!empty($mensaje)): ?>
        <div class="alert alert-info text-center"><?= $mensaje ?></div>
    <?php endif; ?>

    <form method="POST" class="card p-4 shadow-sm">
        <div class="mb-3">
            <label class="form-label">ID Usuario (solo para modificar o eliminar)</label>
            <input type="text" name="idusuario" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Nombre de usuario</label>
            <input type="text" name="usnombre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input type="password" name="uspass" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="usmail" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Deshabilitado (timestamp o dejar vacío)</label>
            <input type="text" name="usdeshabilitado" class="form-control">
        </div>

        <div class="d-flex justify-content-between">
            <button type="submit" name="accion" value="alta" class="btn btn-success">Alta</button>
            <button type="submit" name="accion" value="modificacion" class="btn btn-warning">Modificar</button>
            <button type="submit" name="accion" value="baja" class="btn btn-danger">Eliminar</button>
            <button type="submit" name="accion" value="buscar" class="btn btn-primary">Buscar</button>
        </div>
    </form>

    <?php if (!empty($usuarios)): ?>
        <div class="mt-4">
            <h3>📋 Resultados de búsqueda:</h3>
            <table class="table table-bordered table-striped mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Mail</th>
                        <th>Deshabilitado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $u): ?>
                        <tr>
                            <td><?= $u->getIdusuario() ?></td>
                            <td><?= $u->getUsnombre() ?></td>
                            <td><?= $u->getUsmail() ?></td>
                            <td><?= $u->getUsdeshabilitado() ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
