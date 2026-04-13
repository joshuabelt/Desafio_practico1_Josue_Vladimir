<?php
class QuoteController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function checkout() {
        session_start();
        if (empty($_SESSION['carrito'])) header("Location: index.php");

        // 1. Instanciar el modelo principal
        $cuota = new Cuotas($this->db, $_SESSION['user_id']);

        // 2. Agregar ítems del carrito al modelo
        foreach ($_SESSION['carrito'] as $id => $item) {
            $detalle = new DetalleCuotas($this->db, [
                'servicio_id' => $id,
                'cantidad' => $item['cantidad'],
                'precio' => $item['precio']
            ]);
            $cuota->agregarItem($detalle);
        }

        // 3. Guardar en BD (Cabecera y luego Detalles)
        if ($cuota->generar()) {
            $codigo = $cuota->getCodigo();
            foreach ($_SESSION['carrito'] as $id => $item) {
                $detalle = new DetalleCuotas($this->db, [
                    'servicio_id' => $id,
                    'cantidad' => $item['cantidad'],
                    'precio' => $item['precio']
                ]);
                $detalle->guardar($codigo);
            }
            
            $_SESSION['carrito'] = []; // Limpiar carrito tras éxito
            header("Location: index.php?action=success&code=" . $codigo);
        }
    }
}