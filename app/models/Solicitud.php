<?php
class Solicitud
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Crear nueva solicitud
    public function crear($tallerId, $usuarioId)
    {
        $query = "INSERT INTO solicitudes (taller_id, usuario_id, estado) VALUES (?, ?, 'pendiente')";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $tallerId, $usuarioId);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    // Verificar si ya existe solicitud activa (pendiente o aprobada) del usuario para ese taller
    public function existeSolicitudActiva($tallerId, $usuarioId)
    {
        $query = "SELECT id FROM solicitudes WHERE taller_id = ? AND usuario_id = ? AND estado IN ('pendiente', 'aprobada')";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $tallerId, $usuarioId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    // Obtener todas las solicitudes pendientes con datos de taller y usuario
    public function getPendientes()
    {
        $query = "SELECT s.id, s.fecha_solicitud, s.estado,
                         t.nombre AS taller_nombre,
                         u.username AS usuario_username
                  FROM solicitudes s
                  JOIN talleres t ON s.taller_id = t.id
                  JOIN usuarios u ON s.usuario_id = u.id
                  WHERE s.estado = 'pendiente'
                  ORDER BY s.fecha_solicitud ASC";
        $result = $this->conn->query($query);
        $solicitudes = [];
        while ($row = $result->fetch_assoc()) {
            $solicitudes[] = $row;
        }
        return $solicitudes;
    }

    // Obtener solicitud por ID
    public function getById($id)
    {
        $query = "SELECT * FROM solicitudes WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Aprobar solicitud
    public function aprobar($id)
    {
        $query = "UPDATE solicitudes SET estado = 'aprobada' WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    // Rechazar solicitud
    public function rechazar($id)
    {
        $query = "UPDATE solicitudes SET estado = 'rechazada' WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
}
