
<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Solicitud.php';
require_once __DIR__ . '/../models/Taller.php';

class AdminController
{
    private $solicitudModel;
    private $tallerModel;

    public function __construct()
    {
        $database = new Database();
        $db = $database->connect();
        $this->solicitudModel = new Solicitud($db);
        $this->tallerModel = new Taller($db);
    }

    public function solicitudes()
    {
        if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
            header('Location: index.php?page=login');
            return;
        }
        require __DIR__ . '/../views/admin/solicitudes.php';
    }


    public function getSolicitudesJson()
    {
        if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
            echo json_encode([]);
            return;
        }
        $solicitudes = $this->solicitudModel->getPendientes();
        header('Content-Type: application/json');
        echo json_encode($solicitudes);
    }

    public function aprobar()
    {
        if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
            echo json_encode(['success' => false, 'message' => 'No autorizado']);
            return;
        }

        $solicitudId = intval($_POST['id_solicitud'] ?? 0);

        if ($solicitudId <= 0) {
            echo json_encode(['success' => false, 'message' => 'Solicitud no válida']);
            return;
        }

        $solicitud = $this->solicitudModel->getById($solicitudId);
        if (!$solicitud) {
            echo json_encode(['success' => false, 'message' => 'Solicitud no encontrada']);
            return;
        }

        if ($solicitud['estado'] !== 'pendiente') {
            echo json_encode(['success' => false, 'message' => 'La solicitud ya fue procesada']);
            return;
        }

        $taller = $this->tallerModel->getById($solicitud['taller_id']);
        if (!$taller || $taller['cupo_disponible'] <= 0) {
            echo json_encode(['success' => false, 'message' => 'No hay cupo disponible en el taller']);
            return;
        }

        // Descontar cupo y aprobar solicitud
        if ($this->tallerModel->descontarCupo($solicitud['taller_id'])) {
            $this->solicitudModel->aprobar($solicitudId);
            echo json_encode(['success' => true, 'message' => 'Solicitud aprobada correctamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'No se pudo descontar el cupo. Intente de nuevo.']);
        }
    }

    public function rechazar()
    {
        if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
            echo json_encode(['success' => false, 'message' => 'No autorizado']);
            return;
        }

        $solicitudId = intval($_POST['id_solicitud'] ?? 0);

        if ($solicitudId <= 0) {
            echo json_encode(['success' => false, 'message' => 'Solicitud no válida']);
            return;
        }

        $solicitud = $this->solicitudModel->getById($solicitudId);
        if (!$solicitud || $solicitud['estado'] !== 'pendiente') {
            echo json_encode(['success' => false, 'message' => 'La solicitud no existe o ya fue procesada']);
            return;
        }

        if ($this->solicitudModel->rechazar($solicitudId)) {
            echo json_encode(['success' => true, 'message' => 'Solicitud rechazada']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al rechazar la solicitud']);
        }
    }
}
