<?php

class EnderecoModel {

    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    /* ==========================
       CREATE
    ========================== */
    public function criar(array $dados): int {
        $sql = "INSERT INTO endereco
                (rua, numero, bairro, complemento, cidade, estado, cep)
                VALUES
                (:rua, :numero, :bairro, :complemento, :cidade, :estado, :cep)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':rua'         => $dados['rua'],
            ':numero'      => $dados['numero'],
            ':bairro'      => $dados['bairro'],
            ':complemento' => $dados['complemento'],
            ':cidade'      => $dados['cidade'],
            ':estado'      => $dados['estado'],
            ':cep'         => $dados['cep']
        ]);

        return (int) $this->db->lastInsertId();
    }

    /* ==========================
       READ (POR ID)
    ========================== */
    public function buscarPorId(int $id): array|false {
        $stmt = $this->db->prepare(
            "SELECT * FROM endereco WHERE id = :id"
        );
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    /* ==========================
       UPDATE
    ========================== */
    public function atualizar(array $dados): bool {
        $sql = "UPDATE endereco SET
                    rua = :rua,
                    numero = :numero,
                    bairro = :bairro,
                    complemento = :complemento,
                    cidade = :cidade,
                    estado = :estado,
                    cep = :cep
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':rua'         => $dados['rua'],
            ':numero'      => $dados['numero'],
            ':bairro'      => $dados['bairro'],
            ':complemento' => $dados['complemento'],
            ':cidade'      => $dados['cidade'],
            ':estado'      => $dados['estado'],
            ':cep'         => $dados['cep'],
            ':id'          => $dados['id']
        ]);
    }
}