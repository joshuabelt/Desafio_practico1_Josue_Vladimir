<?php
require_once __DIR__ . '/../config/database.php';
class User {
   public $conexion;

    public function __construct(){
        $database = new Database();
        $this->conexion = $database->connect();
    }

    public function buscarUsuario($usuario){
        $sql = "SELECT * FROM usuarios WHERE usuario = ? AND estado = 1";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$usuario]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Nuevo método para buscar por correo
    public function buscarUsuarioPorEmail($email){
        $sql = "SELECT * FROM usuarios WHERE email = ? AND estado = 1";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crearUsuario($nombre, $usuario, $email, $password, $rol = 'empleado') {
    $sql = "INSERT INTO usuarios (nombre, usuario, email, password, rol) VALUES (?, ?, ?, ?, ?)";
    $stmt = $this->conexion->prepare($sql);
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    return $stmt->execute([$nombre, $usuario, $email, $hashedPassword, $rol]);
}

    // Opcional: verificar si usuario o email ya existen
    public function existeUsuarioEmail($usuario, $email){
        $sql = "SELECT * FROM usuarios WHERE usuario = ? OR email = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$usuario, $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}