<?php

require_once __DIR__ . '/../models/Usuario.php';

class AuthController {

    // MOSTRA A TELA DE LOGIN (GET)
    public function index() {
        require_once __DIR__ . '/../views/auth/login.php';
    }

    // PROCESSA O LOGIN (POST)
    public function login() {

        try {

            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $email = $_POST['email'] ?? null;
            $senha = $_POST['senha'] ?? null;

            if (!$email || !$senha) {
                throw new Exception('Email e senha são obrigatórios.');
            }

            $usuarioModel = new Usuario();
            $usuario = $usuarioModel->buscarPorEmail($email);

            if (!$usuario) {
                throw new Exception('Usuário ou senha inválidos.');
            }

            if (!password_verify($senha, $usuario['senha_hash'])) {
                throw new Exception('Usuário ou senha inválidos.');
            }

            $_SESSION['usuario'] = [
                'id' => $usuario['id'],
                'nome' => $usuario['nome'],
                'email' => $usuario['email'],
                'perfil' => $usuario['perfil']
            ];

            echo json_encode([
                'success' => true,
                'message' => 'Login realizado com sucesso.'
            ]);

        } catch (Exception $e) {

            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: /teamOdonto/public/');
        exit;
    }
}