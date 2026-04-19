CREATE TABLE endereco (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rua VARCHAR(100) NOT NULL,
    numero VARCHAR(10),
    bairro VARCHAR(50) NOT NULL,
    complemento VARCHAR(50),
    cidade VARCHAR(50) NOT NULL,
    estado CHAR(2) NOT NULL,
    cep VARCHAR(10)
);

CREATE TABLE paciente (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cpf VARCHAR(14) NOT NULL,
    telefone VARCHAR(20),
    email VARCHAR(100),
    sexo CHAR(1),
    dataNascimento DATE,
    endereco_id INT NOT NULL,
    FOREIGN KEY (endereco_id) REFERENCES endereco(id)
);