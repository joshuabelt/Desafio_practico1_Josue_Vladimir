<?php

require_once '/../config/database.php';
class Quote
{
    private $conexion;
    
    const TASA_IVA = 0.13; // 13% ejemplo
    const DESC_UMBRAL = 500; // Si el subtotal > 500, aplicar descuento
    const PORCENTAJE_DESC = 0.10; // 10% de descuento

    const DESC_NIVEL_1 = 0.05; // 5%
    const DESC_NIVEL_2 = 0.10; // 10%
    const DESC_NIVEL_3 = 0.15; // 15%

    public function __construct() {
        $db = new Database();
        $this->conexion = $db->connect();
    }
    
    public static function generarCodigo() {
        return "COT-" . strtoupper(substr(uniqid(), -6));
    }

    public static function validarMonto($monto) {
        return is_numeric($monto) && $monto >= 0;
    }

    public function agregarItem(DetalleCuotas $item) {
        $this->items[] = $item;
        $this->calcularTodo(); // Recalcular al añadir productos
    }

    private function calcularSubtotal() {
        $this->subtotal = 0;
        foreach ($this->items as $item) {
            $this->subtotal += $item->getSubtotal();
        }
        return $this->subtotal;
    }

    public function calcularDescuento() {
        $st = $this->subtotal;
        if ($st >= 2500) return $st * 0.15;
        if ($st >= 1000) return $st * 0.10;
        if ($st >= 500)  return $st * 0.05;
        return 0;
    }

    public function calcularIVA() {
        return ($this->subtotal - $this->descuento) * self::TASA_IVA;
    }

    public function calcularTotal() {
        return ($this->subtotal - $this->descuento) + $this->iva;
    }

    private function calcularTodo() {
        $this->subtotal = $this->calcularSubtotal();
        $this->descuento = $this->calcularDescuento();
        $this->iva = $this->calcularIVA();
        $this->total = $this->calcularTotal();
    }

    public function generar() {
        try {
            $query = "INSERT INTO cuotas (codigo, cliente_id, subtotal, descuento, iva, total, fecha) 
                      VALUES (?, ?, ?, ?, ?, ?, NOW())";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([
                $this->codigo, $this->cliente, $this->subtotal, 
                $this->descuento, $this->iva, $this->total
            ]);
        } catch (Exception $e) {
            return false;
        }
    }

    // Getters necesarios para la vista
    public function getCodigo() { return $this->codigo; }
    public function getTotal() { return $this->total; }
}

?>