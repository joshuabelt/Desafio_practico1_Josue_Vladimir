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
            'categoria' => $this->categoria,
            'descripcion' => $this->descripcion
        ];
    }

    /**
     * Catálogo de servicios en memoria (sin BD)
     */
    public static function obtenerCatalogo(): array {
        return [
            new Service(1, "Migración a la nube", "Mover archivos y sistemas a la nube", 300, "Infraestructura y Cloud"),
            new Service(2, "Consultoría de seguridad", "Auditoría de sistemas y políticas de seguridad", 500, "Seguridad"),
            new Service(3, "Soporte técnico 24/7", "Soporte continuo para infraestructura", 200, "Soporte"),
            new Service(4, "Diseño de base de datos", "Modelado y optimización de BD", 400, "Bases de Datos"),
            new Service(5, "Desarrollo web personalizado", "Creación de sitios web a medida", 1200, "Desarrollo"),
            new Service(6, "Mantenimiento de sistemas", "Actualizaciones y parches de seguridad", 150, "Mantenimiento"),
            new Service(7, "Backup y recuperación", "Estrategia de respaldo y DR", 350, "Infraestructura y Cloud"),
            new Service(8, "Capacitación en tecnología", "Cursos personalizados para equipos", 600, "Capacitación")
        ];
    }

    /**
     * Obtener un servicio por ID
     */
    public static function obtenerPorId(int $id): ?Service {
        $catalogo = self::obtenerCatalogo();
        foreach ($catalogo as $service) {
            if ($service->getId() === $id) {
                return $service;
            }
        }
        return null;
    }

    /**
     * Obtener servicios agrupados por categoría
     */
    public static function obtenerPorCategoria(): array {
        $catalogo = self::obtenerCatalogo();
        $agrupado = [];
        foreach ($catalogo as $service) {
            $cat = $service->getCategoria();
            if (!isset($agrupado[$cat])) {
                $agrupado[$cat] = [];
            }
            $agrupado[$cat][] = $service;
        }
        return $agrupado;
    }
}

$service1 = new Service(1, "Migración a la nube", "Mover archivos y sistemas a la nube", 300, "Servicio de infraestructura y cloud");
$service1->getId(); // Devuelve 1
$service1->getNombre(); // Devuelve "Migración a la nube"
$service1->getCategoria(); // Devuelve "Servicio de infraestructura y cloud"
?>