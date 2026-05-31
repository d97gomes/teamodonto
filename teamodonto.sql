-- ================================
-- BANCO DE DADOS: teamodonto
-- ================================

CREATE DATABASE IF NOT EXISTS teamodonto
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_0900_ai_ci;

USE teamodonto;

-- ================================
-- ENDEREÇO
-- ================================
CREATE TABLE endereco (
  id INT NOT NULL AUTO_INCREMENT,
  cep VARCHAR(9) NOT NULL,
  logradouro VARCHAR(150) NOT NULL,
  numero VARCHAR(20) DEFAULT NULL,
  complemento VARCHAR(100) DEFAULT NULL,
  bairro VARCHAR(100) NOT NULL,
  cidade VARCHAR(100) NOT NULL,
  estado CHAR(2) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ================================
-- DADOS PESSOAIS
-- ================================
CREATE TABLE dados_pessoais (
  id INT NOT NULL AUTO_INCREMENT,
  nome VARCHAR(150) NOT NULL,
  cpf VARCHAR(14) NOT NULL,
  sexo ENUM('MASCULINO','FEMININO','OUTROS') NOT NULL DEFAULT 'OUTROS',
  telefone VARCHAR(20) DEFAULT NULL,
  email VARCHAR(150) DEFAULT NULL,
  data_nascimento DATE DEFAULT NULL,
  endereco_id INT NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY cpf (cpf),
  KEY fk_dados_pessoais_endereco (endereco_id),
  CONSTRAINT fk_dados_pessoais_endereco
    FOREIGN KEY (endereco_id) REFERENCES endereco(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ================================
-- PACIENTE
-- ================================
CREATE TABLE paciente (
  id INT NOT NULL AUTO_INCREMENT,
  dados_pessoais_id INT NOT NULL,
  observacoes TEXT,
  ativo TINYINT(1) DEFAULT '1',
  PRIMARY KEY (id),
  KEY fk_paciente_dados_pessoais (dados_pessoais_id),
  CONSTRAINT fk_paciente_dados_pessoais
    FOREIGN KEY (dados_pessoais_id) REFERENCES dados_pessoais(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ================================
-- DENTISTA
-- ================================
CREATE TABLE dentista (
  id INT NOT NULL AUTO_INCREMENT,
  dados_pessoais_id INT NOT NULL,
  cro VARCHAR(20) NOT NULL,
  especialidade VARCHAR(100) DEFAULT NULL,
  ativo TINYINT(1) DEFAULT '1',
  PRIMARY KEY (id),
  UNIQUE KEY cro (cro),
  KEY fk_dentista_dados_pessoais (dados_pessoais_id),
  CONSTRAINT fk_dentista_dados_pessoais
    FOREIGN KEY (dados_pessoais_id) REFERENCES dados_pessoais(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ================================
-- USUÁRIO
-- ================================
CREATE TABLE usuario (
  id INT NOT NULL AUTO_INCREMENT,
  nome VARCHAR(150) NOT NULL,
  email VARCHAR(150) NOT NULL,
  senha_hash VARCHAR(255) NOT NULL,
  perfil ENUM('admin','recepcao') NOT NULL,
  ativo TINYINT(1) DEFAULT '1',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ================================
-- ANAMNESES
-- ================================
CREATE TABLE anamneses (
  id INT NOT NULL AUTO_INCREMENT,
  paciente_id INT NOT NULL,
  dentista_id INT NOT NULL,
  data_registro DATETIME DEFAULT CURRENT_TIMESTAMP,

  diabetes TINYINT(1) DEFAULT '0',
  hipertensao TINYINT(1) DEFAULT '0',
  problemas_cardiacos TINYINT(1) DEFAULT '0',
  problemas_respiratorios TINYINT(1) DEFAULT '0',
  doencas_infecciosas TINYINT(1) DEFAULT '0',
  doencas_osseas TINYINT(1) DEFAULT '0',
  cancer TINYINT(1) DEFAULT '0',
  disturbios_psicologicos TINYINT(1) DEFAULT '0',
  convulsoes TINYINT(1) DEFAULT '0',
  problemas_coagulacao TINYINT(1) DEFAULT '0',

  alergias VARCHAR(255) DEFAULT NULL,
  outras_doencas VARCHAR(255) DEFAULT NULL,

  em_tratamento_medico TINYINT(1) DEFAULT '0',
  medicamentos_em_uso VARCHAR(255) DEFAULT NULL,
  hospitalizado_ou_operado TINYINT(1) DEFAULT '0',
  detalhes_cirurgias VARCHAR(255) DEFAULT NULL,

  tabagista TINYINT(1) DEFAULT '0',
  tipo_tabaco VARCHAR(50) DEFAULT NULL,
  consumo_alcool TINYINT(1) DEFAULT '0',
  frequencia_alcool VARCHAR(50) DEFAULT NULL,

  escovacoes_por_dia INT DEFAULT '0',
  usa_fio_dental TINYINT(1) DEFAULT '0',
  bruxismo TINYINT(1) DEFAULT '0',
  apertamento TINYINT(1) DEFAULT '0',
  onicofagia TINYINT(1) DEFAULT '0',

  doencas_hereditarias VARCHAR(255) DEFAULT NULL,
  observacoes TEXT,

  PRIMARY KEY (id),
  KEY paciente_id (paciente_id),
  KEY dentista_id (dentista_id),
  CONSTRAINT anamneses_ibfk_1
    FOREIGN KEY (paciente_id) REFERENCES paciente(id),
  CONSTRAINT anamneses_ibfk_2
    FOREIGN KEY (dentista_id) REFERENCES dentista(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ================================
-- PROCEDIMENTOS
-- ================================
CREATE TABLE procedimentos (
  id INT NOT NULL AUTO_INCREMENT,
  nome VARCHAR(150) NOT NULL,
  descricao TEXT,
  valor DECIMAL(10,2) NOT NULL,
  ativo TINYINT(1) DEFAULT '1',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ================================
-- ORÇAMENTOS
-- ================================
CREATE TABLE orcamentos (
  id INT NOT NULL AUTO_INCREMENT,
  paciente_id INT NOT NULL,
  dentista_id INT NOT NULL,
  data_orcamento DATETIME DEFAULT CURRENT_TIMESTAMP,
  status ENUM('aberto','aprovado') DEFAULT 'aberto',
  valor_total DECIMAL(10,2) DEFAULT '0.00',
  PRIMARY KEY (id),
  KEY paciente_id (paciente_id),
  KEY dentista_id (dentista_id),
  CONSTRAINT orcamentos_ibfk_1
    FOREIGN KEY (paciente_id) REFERENCES paciente(id),
  CONSTRAINT orcamentos_ibfk_2
    FOREIGN KEY (dentista_id) REFERENCES dentista(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ================================
-- ORÇAMENTO ITENS
-- ================================
CREATE TABLE orcamento_itens (
  id INT NOT NULL AUTO_INCREMENT,
  orcamento_id INT NOT NULL,
  procedimento_id INT NOT NULL,
  dente INT NOT NULL,
  face CHAR(1) NOT NULL,
  valor DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (id),
  KEY orcamento_id (orcamento_id),
  KEY procedimento_id (procedimento_id),
  CONSTRAINT orcamento_itens_ibfk_1
    FOREIGN KEY (orcamento_id) REFERENCES orcamentos(id)
    ON DELETE CASCADE,
  CONSTRAINT orcamento_itens_ibfk_2
    FOREIGN KEY (procedimento_id) REFERENCES procedimentos(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE agenda (
    id INT AUTO_INCREMENT PRIMARY KEY,

    paciente_id INT NOT NULL,
    dentista_id INT NOT NULL,

    data DATE NOT NULL,
    hora TIME NOT NULL,

    sala_id INT NOT NULL,

    status ENUM(
        'pendente',
        'confirmado',
        'em_atendimento',
        'concluido',
        'cancelado'
    ) NOT NULL DEFAULT 'pendente',

    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE sala (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    ativo TINYINT(1) DEFAULT 1
);

CREATE TABLE consulta (
    id INT AUTO_INCREMENT PRIMARY KEY,

    paciente_id INT NOT NULL,

    agenda_id INT NULL,

    data_atendimento DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    evolucao TEXT NOT NULL,

    observacoes TEXT NULL,

    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);