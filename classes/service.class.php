<?php
 class Service
 {
    private $id;
    private $nombre;
    private $descripcion;
    private $precio;
    private $categoria;

    public function __construct($id, $nombre, $descripcion, $precio, $categoria)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->categoria = $categoria;
    }

    public function getId()
    {
        return $this->id;
    }
    
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }
    
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }
    
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function getCategoria()
    {
        return $this->categoria;
    }

    public function setCategoria($categoria)
    {
      $this->categoria = $categoria;
    }

    public function setPrecio($precio): void {
        if ($precio < 0) {
            throw new Exception("El precio no puede ser negativo.");
        }
        $this->precio = $precio;
    }

    public function getPrecioFormateado(): string {
        return "$" . number_format($this->precio, 2, '.', ',');
    }

    /**
     * Útil para convertir el objeto a un arreglo y enviarlo a un Frontend o API
     */
    public function toArray(): array {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'precio' => $this->precio,
            'precio_formateado' => $this->getPrecioFormateado(),
            'categoria' => $this->categoria
        ];
    }
}

$service1 = new Service(1, "Migración a la nube", "Mover archivos y sistemas a la nube", 300, "Servicio de infraestructura y cloud");
$service1.getId(); // Devuelve 1
$service1.getNombre(); // Devuelve "Migración a la nube"
$service1.getCategoria(); // Devuelve "Servicio de infraestructura y cloud"
?>