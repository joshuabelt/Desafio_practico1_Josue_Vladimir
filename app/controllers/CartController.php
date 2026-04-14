<?php
class CartController {
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['carrito'])) $_SESSION['carrito'] = [];
    }

    public function add() {
        $id = $_GET['id'];
        $precio = $_GET['precio'];
        $nombre = $_GET['nombre'];

        // Si ya existe, aumentamos cantidad, sino lo agregamos
        if (isset($_SESSION['carrito'][$id])) {
            $_SESSION['carrito'][$id]['cantidad']++;
        } else {
            $_SESSION['carrito'][$id] = [
                'nombre' => $nombre,
                'precio' => $precio,
                'cantidad' => 1
            ];
        }
        header("Location: index.php?action=ver_carrito");
        exit();
    }

    public function clear() {
        $_SESSION['carrito'] = [];
        header("Location: index.php?action=catalog");
        exit();
    }
}