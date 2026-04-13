<?php

class Usuarios {
    private $db;
    
    // Propiedades de la entidad
    private $id;
    private $nombre;
    private $email;
    private $password;
    private $rol; // 'admin' o 'usuario'

    // Constantes de Roles
    const ROL_ADMIN = 'admin';
    const ROL_USUARIO = 'usuario';

    public function __construct($conexion, $datos = []) {
        $this->db = $conexion;
        $this->id = $datos['id'] ?? null;
        $this->nombre = $datos['nombre'] ?? null;
        $this->email = $datos['email'] ?? null;
        $this->password = $datos['password'] ?? null;
        $this->rol = $datos['rol'] ?? self::ROL_USUARIO;
    }

    // --- GETTERS ---
    public function getId() { return $this->id; }
    public function getNombre() { return $this->nombre; }
    public function getEmail() { return $this->email; }
    public function getRol() { return $this->rol; }

    // --- MÉTODOS DE SEGURIDAD Y VALIDACIÓN ---

    public function validarRegistro() {
        $errores = [];

        if (empty($this->nombre) || !preg_match("/^[a-zA-Z ]*$/", $this->nombre)) {
            $errores[] = "El nombre solo debe contener letras y espacios.";
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $errores[] = "El formato del correo electrónico no es válido.";
        }

        if (strlen($this->password) < 8) {
            $errores[] = "La contraseña debe tener al menos 8 caracteres.";
        }

        return $errores;
    }

    // --- OPERACIONES DE BASE DE DATOS ---

    /**
     * Registra un nuevo usuario cifrando la contraseña
     */
    public function registrar() {
        $query = "INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        
        // Cifrado de contraseña con BCRYPT (el estándar actual)
        $passwordHash = password_hash($this->password, PASSWORD_BCRYPT);
        
        return $stmt->execute([
            $this->nombre,
            $this->email,
            $passwordHash,
            $this->rol
        ]);
    }

    /**
     * Verifica credenciales para el inicio de sesión
     */
    public function login($email, $password) {
        $query = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($password, $usuario['password'])) {
            // Retornamos el objeto con sus datos (excepto la clave por seguridad)
            return $usuario;
        }
        
        return false;
    }

    /**
     * Verifica si un correo ya existe para evitar duplicados
     */
    public function emailExiste($email) {
        $query = "SELECT id FROM usuarios WHERE email = ? LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$email]);
        return $stmt->fetch() ? true : false;
    }
}