<?php
class ServiceController {
    private $serviceModel;

    public function __construct($db) {
        $this->serviceModel = new Servicios($db);
    }

    public function index() {
        // Carga la lista de servicios para el catálogo
        $servicios = $this->serviceModel->listarTodos($this->db);
        require_once __DIR__ . '/../views/services/catalogo-servicios.php';
    }

    public function store() {
        // Solo accesible por Admin
        if (!isset($_SESSION['user_rol']) || $_SESSION['user_rol'] !== 'admin') {
            header("Location: index.php?action=catalog");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nuevoServicio = new Servicios($this->db, $_POST);
            $errores = $nuevoServicio->validar();

            if (empty($errores)) {
                $nuevoServicio->create();
                header("Location: index.php?action=catalog");
                exit();
            } else {
                require_once __DIR__ . '/../views/services/create.php';
            }
        }
    }
}