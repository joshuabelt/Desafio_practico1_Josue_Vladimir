<?php

session_start();
require_once __DIR__ . '/../config/database.php';

if(!isset($_SESSION["usuario"])){
    header("Location: ../views/login.php");
    exit();
}

$database = new Database();
$conn = $database->connect();

$action = $_GET["action"] ?? "index";

switch($action){

    case "index":

        $stmt = $conn->query("SELECT * FROM usuarios");
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require "../view/usuarios/index.php";
        break;


    case "create":

        require "../view/usuarios/create.php";
        break;


    case "store":

        $nombre = $_POST["nombre"];
        $usuario = $_POST["usuario"];
        $email = $_POST["email"];
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $rol = $_POST["rol"];

        $sql = "INSERT INTO usuarios(nombre,usuario,email,password,rol) VALUES(?,?,?,?,?)";

        $stmt = $conn->prepare($sql);
        $stmt->execute([$nombre,$usuario,$email,$password,$rol]);

        header("Location: UserController.php");
        break;


    case "delete":

        $id = $_GET["id"];

        $stmt = $conn->prepare("DELETE FROM usuarios WHERE id=?");
        $stmt->execute([$id]);

        header("Location: UsuarioController.php");
        break;
}