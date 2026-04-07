<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Talleres Disponibles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/style.css">
    <script src="public/js/jquery-4.0.0.min.js"></script>
    <script src="public/js/taller.js"></script>
    <script src="public/js/solicitud.js"></script>
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container">
        <span class="navbar-brand">Sistema de Talleres</span>
        <div class="d-flex align-items-center gap-3">
            <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
                <a href="index.php?page=admin" class="btn btn-outline-light btn-sm">Gestionar Solicitudes</a>
            <?php endif; ?>
            <span class="text-white">
                Bienvenido, <strong><?= htmlspecialchars($_SESSION['nombre'] ?? $_SESSION['user'] ?? 'Usuario') ?></strong>
            </span>
            <button id="btnLogout" class="btn btn-outline-light btn-sm">Cerrar sesión</button>
        </div>
    </div>
</nav>

<div class="container">
    <h3 class="mb-3">Talleres Disponibles</h3>

    <div id="mensaje" class="alert d-none mb-3"></div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Cupo Máximo</th>
                    <th>Cupos Disponibles</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody id="talleres-body">
                <tr>
                    <td colspan="6" class="text-center text-muted">Cargando talleres...</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
