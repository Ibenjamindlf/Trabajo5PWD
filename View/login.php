<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar Sesión</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="d-flex align-items-center justify-content-center vh-100">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-10 col-sm-8 col-md-6 col-lg-4">

        <div class="card shadow-lg">
          <div class="card-header bg-primary text-white text-center">
            <h4 class="mb-0">Iniciar Sesión</h4>
          </div>
          
          <div class="card-body bg-light">
            <form action="../accion/verificarLogin.php" method="post">
              
              <div class="mb-3">
                <label for="usnombre" class="form-label fw-semibold">Usuario</label>
                <input type="text" class="form-control" id="usnombre" name="usnombre" placeholder="Ingresá tu usuario" required>
              </div>

              <div class="mb-3">
                <label for="uspass" class="form-label fw-semibold">Contraseña</label>
                <input type="password" class="form-control" id="uspass" name="uspass" placeholder="Ingresá tu contraseña" required>
              </div>

              <div class="d-grid mt-4">
                <button type="submit" class="btn btn-primary btn-lg">Ingresar</button>
              </div>

            </form>

            <?php if (isset($_GET['error'])): ?>
              <div class="alert alert-danger text-center mt-3 mb-0">
                Usuario o contraseña incorrectos.
              </div>
            <?php endif; ?>

          </div>
        </div>

      </div>
    </div>
  </div>
</div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
