<?php
class Quote
{
    private $codigo;
    private $cliente;
    private $items = [];           // Array de ['servicio' => Service, 'cantidad' => int]
    private $subtotal = 0;
    private $descuento = 0;
    private $iva = 0;
    private $total = 0;
    private $fecha;
    private $fechaGeneracion;
    private $fechaValidez;
    

    const TASA_IVA = 0.13; // 13% ejemplo
    const DESC_UMBRAL = 500; // Si el subtotal > 500, aplicar descuento
    const PORCENTAJE_DESC = 0.10; // 10% de descuento

    const DESC_NIVEL_1 = 0.05; // 5%
    const DESC_NIVEL_2 = 0.10; // 10%
    const DESC_NIVEL_3 = 0.15; // 15%

    public function __construct($cliente) {
        $this->codigo = self::generarCodigo();
        $this->cliente = $cliente;
    }

    // Métodos de lógica
    public function agregarItem(Service $servicio, $cantidad = 1) {
        $this->items[] = [
            'servicio' => $servicio,
            'cantidad' => $cantidad
        ];
        $this->actualizarCalculos();
    }

    private function actualizarCalculos() {
        $this->calcularSubtotal();
        $this->calcularDescuento();
        $this->calcularIVA();
        $this->calcularTotal();
    }

    private function calcularSubtotal() {
        $this->subtotal = 0;
        foreach ($this->items as $item) {
            $this->subtotal += $item['servicio']->getPrecio() * $item['cantidad'];
        }
    }

    private function calcularDescuento() {
      $monto = $this->subtotal;

        if ($monto >= 2500) {
            $porcentaje = self::DESC_NIVEL_3;
        } elseif ($monto >= 1000) {
            $porcentaje = self::DESC_NIVEL_2;
        } elseif ($monto >= 500) {
            $porcentaje = self::DESC_NIVEL_1;
        } else {
            $porcentaje = 0;
        }

        $this->descuento = $monto * $porcentaje;
    }

    private function calcularIVA() {
        $this->iva = ($this->subtotal - $this->descuento) * self::TASA_IVA;
    }

    private function calcularTotal() {
        $this->total = ($this->subtotal - $this->descuento) + $this->iva;
    }

    public function generar() {
        return [
            'codigo' => $this->codigo,
            'cliente' => $this->cliente,
            'subtotal' => $this->subtotal,
            'descuento' => $this->descuento,
            'iva' => $this->iva,
            'total' => $this->total,
            'items' => $this->items
        ];
    }

    // Métodos estáticos
    public static function generarCodigo($consecutivo = 1) {
        $anio = date('Y');
        $numero = str_pad($consecutivo, 4, '0', STR_PAD_LEFT);
        return "COT-{$anio}-{$numero}";
    }

    public static function validarMonto($monto) {
        return is_numeric($monto) && $monto >= 0;
    }

    // Getters para visualización
    public function getCodigo() { return $this->codigo; }
    public function getTotal() { return $this->total; }

    public function establecerFechas() {
    $this->fechaGeneracion = new DateTime(); // Fecha actual
    $this->fechaValidez = (new DateTime())->modify('+7 days'); // +7 días
}

public function getFechaGeneracion() { return $this->fechaGeneracion->format('d/m/Y'); }
public function getFechaValidez() { return $this->fechaValidez->format('d/m/Y'); }
}
?>