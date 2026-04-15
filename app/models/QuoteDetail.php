<?php
class DetalleCuotas {
    private $db;
    private $cuota_codigo;
    private $servicio_id;
    private $cantidad;
    private $precio_unitario;
    private $subtotal;

    public function __construct($conexion, $datos = []) {
        $this->db = $conexion;
        $this->servicio_id = $datos['servicio_id'] ?? null;
        $this->cantidad = $datos['cantidad'] ?? 1;
        $this->precio_unitario = $datos['precio'] ?? 0;
        $this->subtotal = $this->cantidad * $this->precio_unitario;
    }

    public function getSubtotal() {
        return $this->subtotal;
    }

    public function getServicioId() {
        return $this->servicio_id;
    }

    public function getCantidad() {
        return $this->cantidad;
    }

    public function getPrecioUnitario() {
        return $this->precio_unitario;
    }

    public function guardar($quote_id) {
        try {
            $query = "INSERT INTO quote_items (quote_id, service_id, cantidad, precio_unitario, subtotal) 
                      VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($query);
            $resultado = $stmt->execute([
                $quote_id, $this->servicio_id, $this->cantidad, 
                $this->precio_unitario, $this->subtotal
            ]);
            
            if (!$resultado) {
                error_log("Error al insertar detalle de cuota: " . json_encode($stmt->errorInfo()));
            }
            
            return $resultado;
        } catch (Exception $e) {
            error_log("Excepción en guardar detalle: " . $e->getMessage());
            return false;
        }
    }
}