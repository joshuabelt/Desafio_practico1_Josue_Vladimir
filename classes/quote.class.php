<?php
class Quote
{
    private $codigo;
    private $cliente;
    private $items;           // Array de ['servicio' => Service, 'cantidad' => int]
    private $subtotal;
    private $descuento;
    private $iva;
    private $total;
    private $fecha;

    public function __construct($codigo = "", $cliente = "", $items = [], $subtotal = 0, $descuento = 0, $iva = 0, $total = 0, $fecha = "")
    {
        $this->codigo = $codigo ?: uniqid('COT-');
        $this->cliente = $cliente;
        $this->items = is_array($items) ? $items : [];
        $this->subtotal = (float)$subtotal;
        $this->descuento = (float)$descuento;
        $this->iva = (float)$iva;
        $this->total = (float)$total;
        $this->fecha = $fecha ?: date('Y-m-d H:i:s');
    }

    // Getters
    public function getCodigo() { return $this->codigo; }
    public function getCliente() { return $this->cliente; }
    public function getItems() { return $this->items; }
    public function getSubtotal() { return $this->subtotal; }
    public function getDescuento() { return $this->descuento; }
    public function getIva() { return $this->iva; }
    public function getTotal() { return $this->total; }
    public function getFecha() { return $this->fecha; }

    // Setters
    public function setCliente($cliente) { $this->cliente = $cliente; }

    /**
     * Agregar un servicio con cantidad al carrito
     */
    public function agregarItem(Service $servicio, $cantidad = 1)
    {
        $cantidad = max(1, (int)$cantidad);
        
        // Si el servicio ya existe, sumar cantidad
        foreach ($this->items as &$item) {
            if ($item['servicio']->getId() === $servicio->getId()) {
                $item['cantidad'] += $cantidad;
                $this->calcularTotal();
                return;
            }
        }
        
        // Si no existe, agregarlo
        $this->items[] = [
            'servicio' => $servicio,
            'cantidad' => $cantidad
        ];
        $this->calcularTotal();
    }

    /**
     * Remover un servicio por su ID
     */
    public function removerItem($servicioId)
    {
        foreach ($this->items as $k => $item) {
            if ($item['servicio']->getId() === $servicioId) {
                unset($this->items[$k]);
                break;
            }
        }
        $this->items = array_values($this->items);  // Reindexar
        $this->calcularTotal();
    }

    /**
     * Actualizar cantidad de un servicio
     */
    public function actualizarCantidad($servicioId, $cantidad)
    {
        $cantidad = (int)$cantidad;
        
        if ($cantidad <= 0) {
            $this->removerItem($servicioId);
            return;
        }
        
        foreach ($this->items as &$item) {
            if ($item['servicio']->getId() === $servicioId) {
                $item['cantidad'] = $cantidad;
                break;
            }
        }
        $this->calcularTotal();
    }

    /**
     * Calcular subtotal basado en cantidad * precio
     */
    public function calcularSubtotal()
    {
        $this->subtotal = 0;
        foreach ($this->items as $item) {
            $precio = $item['servicio']->getPrecio();
            $cantidad = $item['cantidad'];
            $this->subtotal += $precio * $cantidad;
        }
    }

    /**
     * Calcular descuento: 10% si subtotal >= 1000
     */
    public function calcularDescuento()
    {
        $this->descuento = ($this->subtotal >= 1000) ? $this->subtotal * 0.10 : 0;
    }   

    /**
     * Calcular IVA del 16% sobre el subtotal
     */
    public function calcularIVA()
    {
        $this->iva = $this->subtotal * 0.16;
    }

    /**
     * Recalcular todos los valores
     */
    public function calcularTotal()
    {
        $this->calcularSubtotal();
        $this->calcularDescuento();
        $this->calcularIVA();
        $this->total = $this->subtotal - $this->descuento + $this->iva;
    }

    /**
     * Generar la cotización (guardar en sesión)
     */
    public function generar()
    {
        // Validar que hay items
        if (empty($this->items)) {
            return ['exito' => false, 'mensaje' => 'No hay items en el carrito'];
        }

        // Recalcular antes de generar
        $this->calcularTotal();
        
        // Guardar en sesión
        if (!isset($_SESSION['cotizaciones'])) {
            $_SESSION['cotizaciones'] = [];
        }

        $cotizacionArray = [
            'codigo' => $this->codigo,
            'cliente' => $this->cliente,
            'items' => [],
            'subtotal' => $this->subtotal,
            'descuento' => $this->descuento,
            'iva' => $this->iva,
            'total' => $this->total,
            'fecha' => $this->fecha
        ];

        // Convertir items a array (para sesión)
        foreach ($this->items as $item) {
            $cotizacionArray['items'][] = [
                'servicio_id' => $item['servicio']->getId(),
                'servicio_nombre' => $item['servicio']->getNombre(),
                'servicio_precio' => $item['servicio']->getPrecio(),
                'cantidad' => $item['cantidad'],
                'subtotal' => $item['servicio']->getPrecio() * $item['cantidad']
            ];
        }

        $_SESSION['cotizaciones'][] = $cotizacionArray;

        return [
            'exito' => true,
            'codigo' => $this->codigo,
            'mensaje' => 'Cotización generada exitosamente'
        ];
    }

    /**
     * Convertir a array para enviar como JSON
     */
    public function toArray(): array
    {
        return [
            'codigo' => $this->codigo,
            'cliente' => $this->cliente,
            'items' => array_map(function($item) {
                return [
                    'servicio_id' => $item['servicio']->getId(),
                    'servicio_nombre' => $item['servicio']->getNombre(),
                    'servicio_precio' => $item['servicio']->getPrecio(),
                    'cantidad' => $item['cantidad'],
                    'subtotal' => $item['servicio']->getPrecio() * $item['cantidad']
                ];
            }, $this->items),
            'subtotal' => $this->subtotal,
            'descuento' => $this->descuento,
            'iva' => $this->iva,
            'total' => $this->total,
            'fecha' => $this->fecha
        ];
    }
}
?>