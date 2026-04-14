<?php
require_once '/../config/database.php';
 class Service
 {
    const CATEGORIAS_VALIDAS = ['Desarrollo de aplicaciones', 'Infraestructura y Cloud', 'Ciberseguridad', 'Datos e inteligencia artificial', 'Soporte y servicios administrativos'];
    const PRECIO_MIN = 10;
    const PRECIO_MAX = 5000;
    
    private $conexion;

    public function __construct()
    {
        $db = new Database();
        $this->conexion = $db->connect();
    }
    
    public function create() {
        // Ejecutamos las validaciones antes de insertar
        if (!$this->validarPrecio($this->precio) || !$this->validarCategoria($this->categoria)) {
            return false;
        }

        $stmt = $this->db->prepare(
            "INSERT INTO services (nombre, descripcion, categoria, precio) 
             VALUES (?, ?, ?, ?)"
        );
        
        return $stmt->execute([
            $this->nombre,
            $this->descripcion,
            $this->categoria,
            $this->precio
        ]);
    }

    /**
     * Actualiza el registro en la BD basado en el ID actual del objeto.
     */
    public function update() {
        if (!$this->id) return false;

        $stmt = $this->db->prepare(
            "UPDATE services 
             SET nombre = ?, descripcion = ?, categoria = ?, precio = ?
             WHERE id = ?"
        );
        
        return $stmt->execute([
            $this->nombre,
            $this->descripcion,
            $this->categoria,
            $this->precio,
            $this->id
        ]);
    }

    /**
     * Elimina el registro actual de la base de datos.
     */
    public function delete() {
        if (!$this->id) return false;

        $stmt = $this->db->prepare("DELETE FROM services WHERE id = ?");
        return $stmt->execute([$this->id]);
    }
    
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM services WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getNombre()
    {
        return $this->nombre;
    }
    
    public function getDescripcion()
    {
        return $this->descripcion;
    }
    
    public function getPrecio()
    {
        return $this->precio;
    }

    public function getCategoria()
    {
        return $this->categoria;
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

    private function validarCategoria($categoria) {
        return in_array($categoria, self::CATEGORIAS_VALIDAS);
    } 
}
?>