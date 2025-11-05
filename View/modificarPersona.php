<?php
include_once(__DIR__ . "../../Controller/abmUsuario.php");

$id = $_GET['id'] ?? null;

// print_r($_GET);

$abmUsuario = new ABMusuario();
$usuario = null;

if ($id) {
    $usuario = $abmUsuario->buscar(['idusuario' => $id]);
    if ($usuario) {
        $usuario = $usuario[0];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Usuario</title>

    <!-- Bootstrap CSS -->
    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
        rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-lg mx-auto" style="max-width: 600px;">
        <div class="card-header bg-warning text-dark text-center">
            <h4 class="mb-0">Modificar Usuario</h4>
        </div>

        <div class="card-body">
            <?php if ($usuario): ?>
                <form action="accion/accionModificarPersona.php" method="POST">

                    <!-- ID Usuario -->
                    <div class="mb-3">
                        <label for="idusuario" class="form-label">ID Usuario</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="idusuario" 
                            name="idusuario" 
                            value="<?php echo $usuario->getIdusuario(); ?>" 
                            readonly
                        >
                    </div>

                    <!-- Nombre -->
                    <div class="mb-3">
                        <label for="usnombre" class="form-label">Nombre de usuario</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="usnombre" 
                            name="usnombre" 
                            placeholder="<?php echo $usuario->getUsnombre(); ?>" 
                            required
                        >
                    </div>

                    <!-- Contraseña -->
                    <div class="mb-3">
                        <label for="uspass" class="form-label">Contraseña</label>
                        <input 
                            type="password" 
                            class="form-control" 
                            id="uspass" 
                            name="uspass" 
                            placeholder="<?php echo $usuario->getUspass(); ?>" 
                            required
                        >
                    </div>

                    <!-- Correo -->
                    <div class="mb-3">
                        <label for="usmail" class="form-label">Correo electrónico</label>
                        <input 
                            type="email" 
                            class="form-control" 
                            id="usmail" 
                            name="usmail" 
                            placeholder="<?php echo $usuario->getUsmail(); ?>" 
                            required
                        >
                    </div>

                    <!-- Deshabilitado -->
                    <div class="mb-3">
                        <label for="usdeshabilitado" class="form-label">Fecha de deshabilitado</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="usdeshabilitado" 
                            name="usdeshabilitado" 
                            value="<?php echo $usuario->getUsdeshabilitado(); ?>" 
                            readonly
                        >
                    </div>

                    <!-- Botones -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="listarUsuario.php" class="btn btn-secondary">
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-success">
                            Guardar Cambios
                        </button>
                    </div>

                </form>
            <?php else: ?>
                <div class="alert alert-danger text-center">
                    No se encontró el usuario solicitado.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script 
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

</body>
</html>
