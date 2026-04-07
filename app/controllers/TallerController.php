<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Taller.php';
require_once __DIR__ . '/../models/Solicitud.php';

class TallerController
{
    private $tallerModel;
    private $solicitudModel;

    public function __construct()
    {
        $database = new Database();
        $db = $database->connect();
        $this->tallerModel = new Taller($db);
        $this->solicitudModel = new Solicitud($db);
    }

    public function index()
    {
        if (!isset($_SESSION['id'])) {
            header('Location: index.php?page=login');
            return;
        }
        require __DIR__ . '/../views/taller/listado.php';
    }

    // Retorna talleres disponibles en JSON (cupo > 0)
    public function getTalleresJson()
    {
        if (!isset($_SESSION['id'])) {
            echo json_encode([]);
            return;
        }

        $talleres = $this->tallerModel->getAllDisponibles();
        header('Content-Type: application/json');
        echo json_encode($talleres);
    }

    // Procesar solicitud de inscripción
    public function solicitar()
    {
        if (!isset($_SESSION['id'])) {
            echo json_encode(['success' => false, 'message' => 'Debes iniciar sesión']);
            return;
        }

        $tallerId  = intval($_POST['taller_id'] ?? 0);
        $usuarioId = intval($_SESSION['id']);

        if ($tallerId <= 0) {
            echo json_encode(['success' => false, 'message' => 'Taller no válido']);
            return;
        }

        // Verificar que el taller exista y tenga cupo
        $taller = $this->tallerModel->getById($tallerId);
        if (!$taller) {
            echo json_encode(['success' => false, 'message' => 'El taller no existe']);
            return;
        }

        if ($taller['cupo_disponible'] <= 0) {
            echo json_encode(['success' => false, 'message' => 'El taller no tiene cupos disponibles']);
            return;
        }

        // Verificar que el usuario no tenga ya una solicitud activa para este taller
        if ($this->solicitudModel->existeSolicitudActiva($tallerId, $usuarioId)) {
            echo json_encode(['success' => false, 'message' => 'Ya tienes una solicitud activa o aprobada para este taller']);
            return;
        }

        // Crear la solicitud (el cupo se descuenta solo al aprobar)
        if ($this->solicitudModel->crear($tallerId, $usuarioId)) {
            echo json_encode(['success' => true, 'message' => 'Solicitud enviada correctamente. Espera la aprobación del administrador.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al enviar la solicitud']);
        }
    }
}
