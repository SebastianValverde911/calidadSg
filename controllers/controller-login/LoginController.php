<?php
require_once 'models/model-login/ModelUser.php';

class LoginController {
    public function login() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $userModel = new User();
            $user = $userModel->login($email, $password);

            if ($user) {
                session_start();
                $_SESSION['user_id'] = $user['id_user'];
                header("Location: views/view-dashboard/ViewDashboard.php");
                exit;
            } else {
                $error = "Correo electrónico o contraseña incorrectos.";
                require_once 'views/view-login/ViewLogin.php';
            }
        } else {
            require_once 'views/view-login/ViewLogin.php';
        }
    }

    public function register() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            if ($password !== $confirm_password) {
                $error = "Las contraseñas no coinciden.";
                require_once 'views/view-register/ViewRegister.php';
                return;
            }

            $userModel = new User();
            if ($userModel->register($name, $email, $password)) {
                header("Location: ./index.php");
                exit;
            } else {
                $error = "Error al registrar usuario. Es posible que el correo electrónico ya esté en uso.";
                require_once 'views/view-register/ViewRegister.php';
            }
        } else {
            require_once 'views/view-register/ViewRegister.php';
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: index.php");
        exit;
    }
}
?>