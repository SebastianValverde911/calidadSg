<?php
require_once 'config/dataBase.php';

class User {
    private $conn;
    private $table = 'usuarios';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function login($email, $password) {
        $query = "SELECT * FROM " . $this->table . " WHERE correo = :correo LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':correo', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['contra'])) {
            return $user;
        }

        return false;
    }

    public function register($name, $email, $password) {
        // Verificar si el usuario ya existe
        $query = "SELECT * FROM " . $this->table . " WHERE correo = :correo LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':correo', $email);
        $stmt->execute();

        if ($stmt->fetch(PDO::FETCH_ASSOC)) {
            return false; // Usuario ya existe
        }

        // Registrar el nuevo usuario
        $query = "INSERT INTO " . $this->table . " (nombre,correo, contra) VALUES (:nombre, :correo, :contra)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre', $name);
        $stmt->bindParam(':correo', $email);
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $stmt->bindParam(':contra', $hashed_password);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>