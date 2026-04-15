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

    public function guardar($codigo_cuota) {
        $query = "INSERT INTO detalle_cuotas (cuota_codigo, servicio_id, cantidad, precio_unitario, subtotal) 
                  VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            $codigo_cuota, $this->servicio_id, $this->cantidad, 
            $this->precio_unitario, $this->subtotal
        ]);
    }
}