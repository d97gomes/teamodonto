<?php

require_once __DIR__ . '/../models/enderecoModel.php';
require_once __DIR__ . '/../models/pacienteModel.php';

class PacienteController {

    private PDO $db;
    private EnderecoModel $enderecoModel;
    private PacienteModel $pacienteModel;

    public function __construct(PDO $db) {
        $this->db = $db;
        $this->enderecoModel = new EnderecoModel($db);
        $this->pacienteModel = new PacienteModel($db);
    }

    /* ==========================
       CREATE
    ========================== */
    public function criarPacienteComEndereco(array $dados): bool {

        if (empty($dados['nome']) || strlen($dados['nome']) < 3) return false;
        if (empty($dados['cpf']) || strlen($dados['cpf']) < 11) return false;

        if (
            empty($dados['rua']) ||
            empty($dados['bairro']) ||
            empty($dados['cidade']) ||
            empty($dados['estado'])
        ) return false;

        $enderecoId = $this->enderecoModel->criar([
            'rua'         => $dados['rua'],
            'numero'      => $dados['numero'] ?? null,
            'bairro'      => $dados['bairro'],
            'complemento' => $dados['complemento'] ?? null,
            'cidade'      => $dados['cidade'],
            'estado'      => $dados['estado'],
            'cep'         => $dados['cep'] ?? null
        ]);

        return $this->pacienteModel->criar([
            'nome'           => $dados['nome'],
            'cpf'            => $dados['cpf'],
            'telefone'       => $dados['telefone'] ?? null,
            'email'          => $dados['email'] ?? null,
            'sexo'           => $dados['sexo'] ?? null,
            'dataNascimento' => $dados['dataNascimento'] ?? null,
            'endereco_id'    => $enderecoId
        ]);
    }

    /* ==========================
       READ (LISTAR)
    ========================== */
    public function listarPacientes(): array {
        return $this->pacienteModel->listar();
    }

    /* ==========================
       READ (POR ID)
    ========================== */
    public function buscarPacientePorId(int $id): array|false {
        return $this->pacienteModel->buscarPorId($id);
    }

    /* ==========================
       UPDATE
    ========================== */
    public function atualizarPacienteComEndereco(array $dados): bool {

        // Atualiza paciente
        $this->pacienteModel->atualizar([
            'id'             => $dados['id'],
            'nome'           => $dados['nome'],
            'cpf'            => $dados['cpf'],
            'telefone'       => $dados['telefone'],
            'email'          => $dados['email'],
            'sexo'           => $dados['sexo'],
            'dataNascimento' => $dados['dataNascimento']
        ]);

        // Atualiza endereço
        return $this->enderecoModel->atualizar([
            'id'           => $dados['endereco_id'],
            'rua'          => $dados['rua'],
            'numero'       => $dados['numero'],
            'bairro'       => $dados['bairro'],
            'complemento'  => $dados['complemento'],
            'cidade'       => $dados['cidade'],
            'estado'       => $dados['estado'],
            'cep'          => $dados['cep']
        ]);
    }

    /* ==========================
       DELETE
    ========================== */
    public function excluirPaciente(int $id): bool {
        return $this->pacienteModel->excluir($id);
    }
}