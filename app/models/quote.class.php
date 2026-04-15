<?php

require_once __DIR__ . '/../config/database.php';
class Quote
{
    const TASA_IVA = 0.13; // 13% ejemplo
    const DESC_UMBRAL = 500; // Si el subtotal > 500, aplicar descuento
    const PORCENTAJE_DESC = 0.10; // 10% de descuento

    const DESC_NIVEL_1 = 0.05; // 5%
    const DESC_NIVEL_2 = 0.10; // 10%
    const DESC_NIVEL_3 = 0.15; // 15%

    public $conexion;
    public $codigo = '';
    public $cliente = '';
    public $fechaGeneracion = '';
    public $fechaValidez = '';
    public $items = [];
    public $subtotal = 0;
    public $descuento = 0;
    public $iva = 0;
    public $total = 0;

    public function __construct() {
        $this->conexion = Database::getInstance()->getConnection();
        $this->codigo = '';
        $this->cliente = '';
        $this->fechaGeneracion = date('d/m/Y H:i');
        $this->fechaValidez = date('d/m/Y', strtotime('+7 days'));
        $this->items = [];
        $this->subtotal = 0;
        $this->descuento = 0;
        $this->iva = 0;
        $this->total = 0;
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

    public function getFechaGeneracion() {
        return $this->fechaGeneracion;
    }

    public function getFechaValidez() {
        return $this->fechaValidez;
    }

    public function generar() {
        try {
            // Inserta cotización en quotes
            $query = "INSERT INTO quotes (codigo, cliente, usuario_id, subtotal, descuento, iva, total, fecha) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
            $stmt = $this->conexion->prepare($query);
            $resultado = $stmt->execute([
                $this->codigo, 
                $this->cliente,
                null,  // usuario_id (puede ser NULL o cambiar según tu lógica de sesión)
                $this->subtotal, 
                $this->descuento, 
                $this->iva, 
                $this->total
            ]);

            if (!$resultado) {
                error_log("Error al insertar cotización en quotes: " . json_encode($stmt->errorInfo()));
                return false;
            }

            // Obtener el ID de la cotización insertada
            $idCotizacion = $this->conexion->lastInsertId();

            // Guardar detalles de items en quote_items
            foreach ($this->items as $item) {
                $item->guardar($idCotizacion);
            }

            return true;
        } catch (Exception $e) {
            error_log("Excepción en generar(): " . $e->getMessage());
            return false;
        }
    }

    // Getters necesarios para la vista
    public function getCodigo() { return $this->codigo; }
    public function getTotal() { return $this->total; }
}

?>