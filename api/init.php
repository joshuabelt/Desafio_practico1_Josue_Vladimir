<?php
/**
 * Inicializar sesión e incluir clases
 */
session_start();

require_once __DIR__ . '/../classes/service.class.php';
require_once __DIR__ . '/../classes/quote.class.php';

// Inicializar carrito en sesión si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Inicializar historial de cotizaciones si no existe
if (!isset($_SESSION['cotizaciones'])) {
    $_SESSION['cotizaciones'] = [];
}

// Configurar headers para AJAX
header('Content-Type: application/json; charset=utf-8');
?>
