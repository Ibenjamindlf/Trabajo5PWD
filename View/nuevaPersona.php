<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Usuario</title>

    <!-- Bootstrap CSS (CDN) -->
    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
        rel="stylesheet"
    >
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="card shadow-lg mx-auto" style="max-width: 500px;">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">Cargar Nuevo Usuario</h4>
            </div>

            <div class="card-body">
                <form action="accion/accionNuevaPersona.php" method="POST">
                    <!-- Nombre -->
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="nombre" 
                            name="usnombre" 
                            placeholder="Ingrese el nombre" 
                            required
                        >
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input 
                            type="email" 
                            class="form-control" 
                            id="email" 
                            name="usmail" 
                            placeholder="Ingrese el correo electrónico" 
                            required
                        >
                    </div>

                    <!-- Contraseña -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input 
                            type="password" 
                            class="form-control" 
                            id="password" 
                            name="uspass" 
                            placeholder="Ingrese la contraseña" 
                            required
                        >
                    </div>

                    <!-- Botones -->
                    <div class="d-flex justify-content-between">
                        <button type="reset" class="btn btn-secondary">
                            Resetear
                        </button>
                        <button type="submit" class="btn btn-success">
                            Subir Usuario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (CDN) -->
    <script 
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>
</body>
</html>
