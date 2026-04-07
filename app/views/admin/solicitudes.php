<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Solicitudes Pendientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/style.css">
    <script src="public/js/jquery-4.0.0.min.js"></script>
    <script src="public/js/solicitud.js"></script>
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <span class="navbar-brand">Sistema de Talleres - Admin</span>
        <div class="d-flex align-items-center gap-3">
            <a href="index.php?page=talleres" class="btn btn-outline-light btn-sm">Ver Talleres</a>
            <span class="text-white">
                Admin: <strong><?= htmlspecialchars($_SESSION['nombre'] ?? $_SESSION['user'] ?? 'Administrador') ?></strong>
            </span>
            <button id="btnLogout" class="btn btn-outline-light btn-sm">Cerrar sesión</button>
        </div>
    </div>
</nav>

<div class="container">
    <h3 class="mb-3">Solicitudes Pendientes de Aprobación</h3>

    <div id="mensaje" class="alert d-none mb-3"></div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle" id="tabla-solicitudes">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Taller</th>
                    <th>Solicitante</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="solicitudes-body">
                <tr>
                    <td colspan="5" class="text-center text-muted">Cargando solicitudes...</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
