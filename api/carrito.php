<?php
/**
 * POST /api/carrito.php
 * Maneja agregar, remover y actualizar items del carrito
 * Parámetros: action (add, remove, update), servicio_id, cantidad
 */
require_once 'init.php';

$data = json_decode(file_get_contents('php://input'), true) ?? $_POST;
$action = $data['action'] ?? '';
$servicioId = intval($data['servicio_id'] ?? 0);
$cantidad = intval($data['cantidad'] ?? 1);

if (!$action) {
    echo json_encode(['exito' => false, 'mensaje' => 'Acción no especificada']);
    exit;
}

switch ($action) {
    case 'add':
        // Agregar servicio al carrito
        $servicio = Service::obtenerPorId($servicioId);
        if (!$servicio) {
            echo json_encode(['exito' => false, 'mensaje' => 'Servicio no encontrado']);
            exit;
        }

        // Verificar si ya existe en el carrito
        $existe = false;
        foreach ($_SESSION['carrito'] as &$item) {
            if ($item['servicio_id'] === $servicioId) {
                $item['cantidad'] += $cantidad;
                $existe = true;
                break;
            }
        }

        // Si no existe, agregarlo
        if (!$existe) {
            $_SESSION['carrito'][] = [
                'servicio_id' => $servicioId,
                'servicio_nombre' => $servicio->getNombre(),
                'servicio_precio' => $servicio->getPrecio(),
                'cantidad' => $cantidad
            ];
        }

        echo json_encode(['exito' => true, 'mensaje' => 'Servicio agregado', 'carrito' => $_SESSION['carrito']]);
        break;

    case 'remove':
        // Remover servicio del carrito
        foreach ($_SESSION['carrito'] as $k => $item) {
            if ($item['servicio_id'] === $servicioId) {
                unset($_SESSION['carrito'][$k]);
                break;
            }
        }
        $_SESSION['carrito'] = array_values($_SESSION['carrito']); // Reindexar
        echo json_encode(['exito' => true, 'mensaje' => 'Servicio removido', 'carrito' => $_SESSION['carrito']]);
        break;

    case 'update':
        // Actualizar cantidad
        if ($cantidad <= 0) {
            // Si cantidad es 0 o negativa, remover
            foreach ($_SESSION['carrito'] as $k => $item) {
                if ($item['servicio_id'] === $servicioId) {
                    unset($_SESSION['carrito'][$k]);
                    break;
                }
            }
            $_SESSION['carrito'] = array_values($_SESSION['carrito']);
        } else {
            foreach ($_SESSION['carrito'] as &$item) {
                if ($item['servicio_id'] === $servicioId) {
                    $item['cantidad'] = $cantidad;
                    break;
                }
            }
        }
        echo json_encode(['exito' => true, 'mensaje' => 'Cantidad actualizada', 'carrito' => $_SESSION['carrito']]);
        break;

    case 'get':
        // Obtener carrito actual
        echo json_encode(['exito' => true, 'carrito' => $_SESSION['carrito']]);
        break;

    default:
        echo json_encode(['exito' => false, 'mensaje' => 'Acción no válida']);
}
?>
