<?php

require_once __DIR__ . '/../models/Usuario.php';

class UsuarioController {

    private $usuarioModel;

    public function __construct() {
        $this->usuarioModel = new Usuario();
    }

    /* ========= CADASTRAR USUÁRIO ========= */
    public function store(): array
    {
        try {

            $nome   = $_POST['nome']   ?? null;
            $email  = $_POST['email']  ?? null;
            $senha  = $_POST['senha']  ?? null;
            $perfil = $_POST['perfil'] ?? null;

            if (!$nome || !$email || !$senha || !$perfil) {
                throw new Exception('Todos os campos são obrigatórios.');
            }

            if ($this->usuarioModel->emailExiste($email)) {
                throw new Exception('E-mail já cadastrado.');
            }

            $ok = $this->usuarioModel->criar(
                $nome,
                $email,
                $senha,
                $perfil
            );

            if (!$ok) {
                throw new Exception('Erro ao cadastrar usuário.');
            }

            return [
                'success' => true,
                'message' => 'Usuário cadastrado com sucesso.'
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function storePublico(): void
{
    try {
        session_start();

        $nome  = $_POST['nome']  ?? null;
        $email = $_POST['email'] ?? null;
        $senha = $_POST['senha'] ?? null;

        if (!$nome || !$email || !$senha) {
            throw new Exception('Dados inválidos.');
        }

        if ($this->usuarioModel->emailExiste($email)) {
            throw new Exception('E-mail já cadastrado.');
        }

        // Perfil padrão para cadastro público
        $this->usuarioModel->criar(
            $nome,
            $email,
            $senha,
            'recepcao'
        );

        // login automático
        $_SESSION['usuario'] = [
            'nome'   => $nome,
            'email'  => $email,
            'perfil' => 'recepcao'
        ];

        header('Location: index.php?page=login');
        exit;

    } catch (Exception $e) {
        echo "<script>alert('{$e->getMessage()}');history.back();</script>";
        exit;
    }
}

}
