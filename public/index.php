<?php
// Iniciar sesión para el carrito y autenticación
session_start();

// Carga automática de archivos (Autoload simple)
require_once __DIR__ . '/../app/config/database.php';
require_once __DIR__ . '/../app/models/Usuarios.php';
require_once __DIR__ . '/../app/models/Servicios.php';
require_once __DIR__ . '/../app/models/Cuotas.php';
require_once __DIR__ . '/../app/models/DetalleCuotas.php';

require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/ServiceController.php';
require_once __DIR__ . '/../app/controllers/CartController.php';
require_once __DIR__ . '/../app/controllers/QuoteController.php';

// Conexión a la BD
$database = new Database();
$db = $database->getConnection();

// Capturar la acción de la URL
$action = $_GET['action'] ?? 'catalog';

// --- SISTEMA DE ENRUTAMIENTO BÁSICO ---
switch ($action) {
    case 'login':
        $controller = new AuthController($db);
        $controller->login();
        break;

    case 'logout':
        $controller = new AuthController($db);
        $controller->logout();
        break;

    case 'catalog':
        $controller = new ServiceController($db);
        $controller->index();
        break;

    case 'add_to_cart':
        $controller = new CartController();
        $controller->add();
        break;

    case 'ver_carrito':
        require_once __DIR__ . '/../app/views/cart.php';
        break;

    case 'checkout':
        $controller = new QuoteController($db);
        $controller->checkout();
        break;

    default:
        // Redirigir al catálogo si la acción no existe
        header("Location: index.php?action=catalog");
        break;
}