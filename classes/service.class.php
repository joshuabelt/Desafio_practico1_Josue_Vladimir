<?php
 class Service
 {
    private $id;
    private $nombre;
    private $descripcion;
    private $precio;
    private $categoria;
    
    const CATEGORIAS_VALIDAS = ['Desarrollo de aplicaciones', 'Infraestructura y Cloud', 'Ciberseguridad', 'Datos e inteligencia artificial', 'Soporte y servicios administrativos', 'Mantenimiento y optimización', 'Otros'];
    const PRECIO_MIN = 10;
    const PRECIO_MAX = 5000;

    public function __construct($id, $nombre, $descripcion, $precio, $categoria)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        if ($this->validarPrecio($precio) && $this->validarCategoria($categoria)) {
            $this->precio = $precio;
            $this->categoria = $categoria;
        } else {
            throw new Exception("Datos de servicio no válidos.");
        }
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
    
    private function validarPrecio($precio) {
        return ($precio >= self::PRECIO_MIN && $precio <= self::PRECIO_MAX);
    }

    private function validarCategoria($cat) {
        return in_array($cat, self::CATEGORIAS_VALIDAS);
    } 
}
?>