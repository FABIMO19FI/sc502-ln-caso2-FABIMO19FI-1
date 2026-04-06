<?php
class Taller
{

    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        $result = $this->conn->query("SELECT * FROM talleres ORDER BY nombre");
        $talleres = [];
        while ($row = $result->fetch_assoc()) {
            $talleres[] = $row;
        }
        return $talleres;
    }

    public function getAllDisponibles()
    {

    }

    public function getById($id)
    {
    
    }

    public function descontarCupo($tallerId)
    {

    }

    public function sumarCupo($tallerId)
    {

    }
}
