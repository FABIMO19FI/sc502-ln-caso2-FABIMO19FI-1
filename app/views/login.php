<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/style.css">
    <script src="public/js/jquery-4.0.0.min.js"></script>
    <script src="public/js/auth.js"></script>
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Sistema de Talleres</h4>
                    <small>Iniciar Sesión</small>
                </div>
                <div class="card-body">
                    <div id="mensaje" class="alert d-none"></div>

                    <form id="formLogin">
                        <div class="mb-3">
                            <label for="username" class="form-label">Usuario</label>
                            <input
                                type="text"
                                class="form-control"
                                name="username"
                                id="username"
                                placeholder="Ingrese su usuario">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input
                                type="password"
                                class="form-control"
                                name="password"
                                id="password"
                                placeholder="Ingrese su contraseña">
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Ingresar</button>
                            <a href="index.php?page=registro" class="btn btn-outline-secondary">¿No tienes cuenta? Regístrate</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
