<?php

require_once __DIR__ . '/../models/Usuario.php';

class UsuarioController {

    private Usuario $usuarioModel;

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
                'message' => 'Usuário cadastrado com sucesso ✅'
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /* ========= CADASTRO PÚBLICO ========= */
    public function storePublico(): void
    {
        try {
            session_start();

            $nome  = $_POST['nome']  ?? null;
            $email = $_POST['email'] ?? null;
            $senha = $_POST['senha'] ?? null;

            if (!$nome || !$email || !$senha) {
                throw new Exception('Todos os campos são obrigatórios.');
            }

            if ($this->usuarioModel->emailExiste($email)) {
                throw new Exception('E-mail já cadastrado.');
            }

            $this->usuarioModel->criar(
                $nome,
                $email,
                $senha,
                'recepcao'
            );

            /* ✅ LOGIN AUTOMÁTICO */
            $_SESSION['usuario'] = [
                'nome'   => $nome,
                'email'  => $email,
                'perfil' => 'recepcao'
            ];

            header('Location: index.php?page=home');
            exit;

        } catch (Exception $e) {
            echo "<script>alert('{$e->getMessage()}');history.back();</script>";
            exit;
        }
    }

    /* ========= RECUPERAR SENHA ✅ ========= */
   public function recuperarSenha(): array
{
    $dados = json_decode(file_get_contents('php://input'), true);

    if (!$dados) {
        $dados = $_POST;
    }

    $email = $dados['email'] ?? null;

    if (!$email) {
        return [
            'success' => false,
            'message' => 'Informe um e-mail válido ❌'
        ];
    }

    $usuario = $this->usuarioModel->buscarPorEmail($email);

    /* ✅ AQUI ESTAVA FALTANDO */
    if ($usuario) {

        $token = bin2hex(random_bytes(16));

        $this->usuarioModel->salvarTokenRecuperacao($email, $token);

        return [
            'success' => true,
            'message' => 'Instruções enviadas para o email ✅',
            'token_teste' => $token // ✅ debug (pode remover depois)
        ];
    }

    return [
        'success' => true,
        'message' => 'Se o e-mail existir, você receberá instruções ✅'
    ];
}

/* ========= REDEFINIR SENHA ✅ ========= */
public function redefinirSenha(): array
{
    // ✅ aceita JSON ou POST
    $dados = json_decode(file_get_contents('php://input'), true);

    if (!$dados) {
        $dados = $_POST;
    }

    $token = $dados['token'] ?? null;
    $senha = $dados['senha'] ?? null;

    if (!$token || !$senha) {
        return [
            'success' => false,
            'message' => 'Dados inválidos ❌'
        ];
    }

    // ✅ busca usuário pelo token
    $usuario = $this->usuarioModel->buscarPorToken($token);

    if (!$usuario) {
        return [
            'success' => false,
            'message' => 'Token inválido ou expirado ❌'
        ];
    }

    // ✅ atualiza senha
    $ok = $this->usuarioModel->atualizarSenha($usuario['id'], $senha);

    return [
        'success' => $ok
    ];
}


}