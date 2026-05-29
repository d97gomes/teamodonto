
-- ================================
-- BANCO DE DADOS: teamodonto
-- ================================

CREATE DATABASE IF NOT EXISTS teamodonto;
USE teamodonto;

-- ================================
-- USUÁRIOS
-- ================================
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);

-- ================================
-- ENDEREÇO
-- ================================
CREATE TABLE endereco (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cep VARCHAR(20),
    logradouro VARCHAR(255),
    numero VARCHAR(20),
    complemento VARCHAR(100),
    bairro VARCHAR(100),
    cidade VARCHAR(100),
    estado VARCHAR(50)
);

-- ================================
-- DADOS PESSOAIS
-- ================================
CREATE TABLE dados_pessoais (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cpf VARCHAR(14) NOT NULL UNIQUE,
    sexo VARCHAR(20),
    telefone VARCHAR(20),
    email VARCHAR(100),
    endereco_id INT,
    FOREIGN KEY (endereco_id) REFERENCES endereco(id)
);

-- ================================
-- PACIENTE
-- ================================
CREATE TABLE paciente (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dados_pessoais_id INT NOT NULL,
    ativo TINYINT(1) DEFAULT 1,
    FOREIGN KEY (dados_pessoais_id) REFERENCES dados_pessoais(id)
);

-- ================================
-- DENTISTA
-- ================================
CREATE TABLE dentista (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dados_pessoais_id INT NOT NULL,
    cro VARCHAR(30) NOT NULL,
    especialidade VARCHAR(100),
    ativo TINYINT(1) DEFAULT 1,
    FOREIGN KEY (dados_pessoais_id) REFERENCES dados_pessoais(id)
);

-- ================================
-- ANAMNESES
-- ================================
CREATE TABLE anamneses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    paciente_id INT NOT NULL,
    dentista_id INT NOT NULL,
    data_registro DATETIME DEFAULT CURRENT_TIMESTAMP,

    diabetes TINYINT(1) DEFAULT 0,
    hipertensao TINYINT(1) DEFAULT 0,
    problemas_cardiacos TINYINT(1) DEFAULT 0,
    problemas_respiratorios TINYINT(1) DEFAULT 0,
    doencas_infecciosas TINYINT(1) DEFAULT 0,
    doencas_osseas TINYINT(1) DEFAULT 0,
    cancer TINYINT(1) DEFAULT 0,
    disturbios_psicologicos TINYINT(1) DEFAULT 0,
    convulsoes TINYINT(1) DEFAULT 0,
    problemas_coagulacao TINYINT(1) DEFAULT 0,

    alergias VARCHAR(255),
    outras_doencas VARCHAR(255),

    em_tratamento_medico TINYINT(1) DEFAULT 0,
    medicamentos_em_uso VARCHAR(255),
    hospitalizado_ou_operado TINYINT(1) DEFAULT 0,
    detalhes_cirurgias VARCHAR(255),

    tabagista TINYINT(1) DEFAULT 0,
    tipo_tabaco VARCHAR(50),
    consumo_alcool TINYINT(1) DEFAULT 0,
    frequencia_alcool VARCHAR(50),

    escovacoes_por_dia INT DEFAULT 0,
    usa_fio_dental TINYINT(1) DEFAULT 0,
    bruxismo TINYINT(1) DEFAULT 0,
    apertamento TINYINT(1) DEFAULT 0,
    onicofagia TINYINT(1) DEFAULT 0,

    doencas_hereditarias VARCHAR(255),
    observacoes TEXT,

    FOREIGN KEY (paciente_id) REFERENCES paciente(id),
    FOREIGN KEY (dentista_id) REFERENCES dentista(id)
);

CREATE TABLE procedimentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    descricao TEXT,
    valor DECIMAL(10,2) NOT NULL,
    ativo TINYINT(1) DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE orcamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,

    paciente_id INT NOT NULL,
    dentista_id INT NOT NULL,

    data_orcamento DATETIME DEFAULT CURRENT_TIMESTAMP,

    status ENUM('aberto', 'aprovado') DEFAULT 'aberto',

    valor_total DECIMAL(10,2) DEFAULT 0.00,

    FOREIGN KEY (paciente_id) REFERENCES paciente(id),
    FOREIGN KEY (dentista_id) REFERENCES dentista(id)
);

CREATE TABLE orcamento_itens (
    id INT AUTO_INCREMENT PRIMARY KEY,

    orcamento_id INT NOT NULL,
    procedimento_id INT NOT NULL,

    dente INT NOT NULL,
    face CHAR(1) NOT NULL,

    valor DECIMAL(10,2) NOT NULL,

    FOREIGN KEY (orcamento_id) REFERENCES orcamentos(id)
        ON DELETE CASCADE,

    FOREIGN KEY (procedimento_id) REFERENCES procedimentos(id)
);
