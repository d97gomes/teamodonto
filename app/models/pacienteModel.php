<?php

class PacienteModel {

    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    /* ==========================
       CREATE
    ========================== */
    public function criar(array $dados): bool {
        $sql = "INSERT INTO paciente
                (nome, cpf, telefone, email, sexo, dataNascimento, endereco_id)
                VALUES
                (:nome, :cpf, :telefone, :email, :sexo, :dataNascimento, :endereco_id)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':nome'           => $dados['nome'],
            ':cpf'            => $dados['cpf'],
            ':telefone'       => $dados['telefone'],
            ':email'          => $dados['email'],
            ':sexo'           => $dados['sexo'],
            ':dataNascimento' => $dados['dataNascimento'],
            ':endereco_id'    => $dados['endereco_id']
        ]);
    }

    /* ==========================
       READ (LISTAR)
    ========================== */
    public function listar(): array {
        $sql = "SELECT
                    p.id,
                    p.nome,
                    p.cpf,
                    p.telefone,
                    e.rua, e.bairro, e.cidade, e.estado
                FROM paciente p
                INNER JOIN endereco e ON e.id = p.endereco_id
                ORDER BY p.nome";

        return $this->db->query($sql)->fetchAll();
    }

    /* ==========================
       READ (POR ID)
    ========================== */
    public function buscarPorId(int $id): array|false {
        $sql = "SELECT
                    p.*,
                    e.rua, e.numero, e.bairro, e.complemento,
                    e.cidade, e.estado, e.cep
                FROM paciente p
                INNER JOIN endereco e ON e.id = p.endereco_id
                WHERE p.id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetch();
    }

    /* ==========================
       UPDATE
    ========================== */
    public function atualizar(array $dados): bool {
        $sql = "UPDATE paciente SET
                    nome = :nome,
                    cpf = :cpf,
                    telefone = :telefone,
                    email = :email,
                    sexo = :sexo,
                    dataNascimento = :dataNascimento
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':nome'           => $dados['nome'],
            ':cpf'            => $dados['cpf'],
            ':telefone'       => $dados['telefone'],
            ':email'          => $dados['email'],
            ':sexo'           => $dados['sexo'],
            ':dataNascimento' => $dados['dataNascimento'],
            ':id'             => $dados['id']
        ]);
    }

    /* ==========================
       DELETE
    ========================== */
    public function excluir(int $id): bool {
        $stmt = $this->db->prepare(
            "DELETE FROM paciente WHERE id = :id"
        );
        return $stmt->execute([':id' => $id]);
    }
}