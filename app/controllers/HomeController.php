<?php

class HomeController {

    public function index() {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario'])) {
            header('Location: /auth/login');
            exit;
        }

        require_once __DIR__ . '/../views/home/index.php';
    }
}
