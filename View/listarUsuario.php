<?php
// Conexión a la base de datos (ajustá según tu estructura)
// include_once("../config/conexion.php");
include_once("../Controller/abmUsuario.php");

// Consulta de usuarios activos (borrado lógico = usuarios con estado = 1)
// $sql = "SELECT id, nombre, email, password FROM usuario WHERE estado = 1";
// $resultado = $conexion->query($sql);
$datos = $_POST;
$abmUsuario = new ABMusuario();
$arrayUsuarios = $abmUsuario->buscar(null);
$cantUsuario = count($arrayUsuarios);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Usuarios</title>

    <!-- Bootstrap CSS -->
    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
        rel="stylesheet"
    >
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">Usuarios Registrados</h4>
            </div>

            <div class="card-body">
                <?php if ($cantUsuario > 0): ?>
                    <table class="table table-striped table-bordered align-middle">
                        <thead class="table-dark text-center">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Password</th>
                                <th>Deshabilitado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($arrayUsuarios as $unUsuario) { ?>
                                <tr>
                                    <td><?php echo $unUsuario->getIdusuario(); ?></td>
                                    <td><?php echo $unUsuario->getUsnombre(); ?></td>
                                    <td><?php echo $unUsuario->getUsmail(); ?></td>
                                    <td><?php echo $unUsuario->getUspass(); ?></td>
                                    <td><?php echo $unUsuario->getUsdeshabilitado(); ?></td>
                                    <td class="text-center">
                                        <!-- Botón Actualizar -->
                                        <a href="modificarPersona.php?id=<?php echo $unUsuario->getIdusuario(); ?>" 
                                        class="btn btn-warning btn-sm me-2">
                                            Actualizar
                                        </a>

                                        <!-- Botón Deshabilitar/habilitar (borrado lógico) -->
                                        <?php
                                        $deshabilitacion = $unUsuario->getUsdeshabilitado();
                                        if ($deshabilitacion == "0000-00-00 00:00:00" || $deshabilitacion == NULL){ ?> 
                                            <a href="accion/accionDeshabilitarPersona.php?idusuario=<?php echo $unUsuario->getIdusuario(); ?>" 
                                            class="btn btn-danger btn-sm me-2">
                                            Deshabilitar
                                            </a>
                                        <?php } else { ?> 
                                            <a href="accion/accionDeshabilitarPersona.php?idusuario=<?php echo $unUsuario->getIdusuario(); ?>" 
                                            class="btn btn-success btn-sm me-4">
                                            Habilitar
                                            </a>
                                        <?php 
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="alert alert-info text-center">
                        No hay usuarios registrados.
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
