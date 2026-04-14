<?php
class AuthController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new Usuarios($db);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $this->userModel->login($email, $password);
            if ($user) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_rol'] = $user['rol'];
                $_SESSION['user_nombre'] = $user['nombre'];
                
                header("Location: index.php?action=catalog");
                exit();
            } else {
                $error = "Credenciales incorrectas";
                require_once __DIR__ . '/../views/login.php';
            }
        } else {
            require_once __DIR__ . '/../views/login.php';
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: index.php?action=login");
    }
}