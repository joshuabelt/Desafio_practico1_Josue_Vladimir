<?php
class ServiceController {
    private $serviceModel;

    public function __construct($db) {
        $this->serviceModel = new Servicios($db);
    }

    public function index() {
        // Carga la lista de servicios para el catálogo
        $servicios = $this->serviceModel->listarTodos($this->db); 
        require_once 'views/services/catalog.php';
    }

    public function store() {
        // Solo accesible por Admin
        if ($_SESSION['user_rol'] !== 'admin') header("Location: index.php");

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nuevoServicio = new Servicios($this->db, $_POST);
            $errores = $nuevoServicio->validar();

            if (empty($errores)) {
                $nuevoServicio->create();
                header("Location: index.php?action=services");
            } else {
                require_once 'views/services/create.php';
            }
        }
    }
}