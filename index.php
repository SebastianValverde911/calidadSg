<?php
require_once 'controllers/controller-login/LoginController.php';

$controller = new LoginController();

if (isset($_GET['logout'])) {
    $controller->logout();
} elseif (isset($_GET['action']) && $_GET['action'] == 'register') {
    $controller->register();
} else {
    $controller->login();
}
?>