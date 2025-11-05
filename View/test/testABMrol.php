<?php
include_once("../Controller/abmRol.php");
$abmRol = new AbmRol();
$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'];

    switch ($accion) {
        case 'alta':
            if ($abmRol->alta($_POST)) {
                $mensaje = "✅ Rol creado correctamente.";
            } else {
                $mensaje = "❌ Error al crear el rol (posiblemente ya exista).";
            }
            break;

        case 'modificacion':
            if ($abmRol->modificar($_POST)) {
                $mensaje = "✅ Rol modificado correctamente.";
            } else {
                $mensaje = "❌ Error al modificar el rol.";
            }
            break;

        case 'baja':
            if ($abmRol->baja($_POST)) {
                $mensaje = "🗑️ Rol eliminado correctamente.";
            } else {
                $mensaje = "❌ Error al eliminar el rol.";
            }
            break;

        case 'buscar':
            $roles = $abmRol->buscar($_POST);
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Test ABM Rol</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h1 class="mb-4 text-center">🧩 Test ABM Rol</h1>

    <?php if (!empty($mensaje)): ?>
        <div class="alert alert-info text-center"><?= $mensaje ?></div>
    <?php endif; ?>

    <form method="POST" class="card p-4 shadow-sm">
        <div class="mb-3">
            <label class="form-label">ID Rol (solo para modificar o eliminar)</label>
            <input type="text" name="idrol" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción del rol</label>
            <input type="text" name="roldescripcion" class="form-control">
        </div>

        <div class="d-flex justify-content-between">
            <button type="submit" name="accion" value="alta" class="btn btn-success">Alta</button>
            <button type="submit" name="accion" value="modificacion" class="btn btn-warning">Modificar</button>
            <button type="submit" name="accion" value="baja" class="btn btn-danger">Eliminar</button>
            <button type="submit" name="accion" value="buscar" class="btn btn-primary">Buscar</button>
        </div>
    </form>

    <?php if (!empty($roles)): ?>
        <div class="mt-4">
            <h3>📋 Resultados de búsqueda:</h3>
            <table class="table table-bordered table-striped mt-3">
                <thead>
                    <tr>
                        <th>ID Rol</th> 
                        <th>Descripción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($roles as $r): ?>
                        <tr>
                            <td><?= $r->getIdrol() ?></td>
                            <td><?= $r->getRoldescripcion() ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
