<?php

require_once __DIR__ . '/../models/Usuario.php';

class AuthController {

    public function login(): array
    {
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

            if (!$usuario || !password_verify($senha, $usuario['senha_hash'])) {
                throw new Exception('Usuário ou senha inválidos.');
            }

            $_SESSION['usuario'] = [
                'id' => $usuario['id'],
                'nome' => $usuario['nome'],
                'email' => $usuario['email'],
                'perfil' => $usuario['perfil']
            ];

            return [
                'success' => true,
                'message' => 'Login realizado com sucesso.'
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function logout(): void
    {
        session_start();
        session_destroy();
    }
}