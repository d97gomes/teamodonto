-- ================================
-- BANCO DE DADOS: teamodonto
-- ================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE DATABASE IF NOT EXISTS teamodonto
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_0900_ai_ci;

USE teamodonto;

-- ================================
-- ENDERECO
-- ================================
CREATE TABLE IF NOT EXISTS endereco (
  id INT AUTO_INCREMENT PRIMARY KEY,
  cep VARCHAR(9) NOT NULL,
  logradouro VARCHAR(150) NOT NULL,
  numero VARCHAR(20),
  complemento VARCHAR(100),
  bairro VARCHAR(100) NOT NULL,
  cidade VARCHAR(100) NOT NULL,
  estado CHAR(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ================================
-- DADOS PESSOAIS
-- ================================
CREATE TABLE IF NOT EXISTS dados_pessoais (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(150) NOT NULL,
  cpf VARCHAR(14) NOT NULL UNIQUE,
  sexo ENUM('MASCULINO','FEMININO','OUTROS') NOT NULL DEFAULT 'OUTROS',
  telefone VARCHAR(20),
  email VARCHAR(150),
  data_nascimento DATE,
  endereco_id INT NOT NULL,
  FOREIGN KEY (endereco_id) REFERENCES endereco(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ================================
-- PACIENTE
-- ================================
CREATE TABLE IF NOT EXISTS paciente (
  id INT AUTO_INCREMENT PRIMARY KEY,
  dados_pessoais_id INT NOT NULL,
  observacoes TEXT,
  ativo TINYINT(1) DEFAULT 1,
  FOREIGN KEY (dados_pessoais_id) REFERENCES dados_pessoais(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ================================
-- DENTISTA
-- ================================
CREATE TABLE IF NOT EXISTS dentista (
  id INT AUTO_INCREMENT PRIMARY KEY,
  dados_pessoais_id INT NOT NULL,
  cro VARCHAR(20) NOT NULL UNIQUE,
  especialidade VARCHAR(100),
  ativo TINYINT(1) DEFAULT 1,
  FOREIGN KEY (dados_pessoais_id) REFERENCES dados_pessoais(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ================================
-- USUARIO
-- ================================
CREATE TABLE IF NOT EXISTS usuario (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(150) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  senha_hash VARCHAR(255) NOT NULL,
  perfil ENUM('admin','recepcao') NOT NULL,
  ativo TINYINT(1) DEFAULT 1,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- USUARIO PADRAO (LOGIN FUNCIONA EM QUALQUER AMBIENTE)
INSERT IGNORE INTO usuario (nome, email, senha_hash, perfil)
VALUES (
  'Administrador',
  'admin@admin.com',
  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
  'admin'
);

-- ================================
-- ANAMNESES
-- ================================
CREATE TABLE IF NOT EXISTS anamneses (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ================================
-- PROCEDIMENTOS
-- ================================
CREATE TABLE IF NOT EXISTS procedimentos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(150) NOT NULL,
  descricao TEXT,
  valor DECIMAL(10,2) NOT NULL,
  ativo TINYINT(1) DEFAULT 1,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ================================
-- AGENDA
-- ================================
CREATE TABLE IF NOT EXISTS agenda (
  id INT AUTO_INCREMENT PRIMARY KEY,
  paciente_id INT NOT NULL,
  dentista_id INT NOT NULL,
  data DATE NOT NULL,
  hora TIME NOT NULL,
  status ENUM('pendente','confirmado','em_atendimento','concluido','cancelado') DEFAULT 'pendente',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (paciente_id) REFERENCES paciente(id),
  FOREIGN KEY (dentista_id) REFERENCES dentista(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ================================
-- CONSULTAS
-- ================================
CREATE TABLE IF NOT EXISTS consultas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  agenda_id INT NOT NULL,
  paciente_id INT NOT NULL,
  dentista_id INT NOT NULL,
  data_inicio DATETIME NOT NULL,
  data_fim DATETIME,
  evolucao TEXT,
  status ENUM('em_atendimento','finalizada') DEFAULT 'em_atendimento',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (agenda_id) REFERENCES agenda(id),
  FOREIGN KEY (paciente_id) REFERENCES paciente(id),
  FOREIGN KEY (dentista_id) REFERENCES dentista(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ================================
-- ORCAMENTOS
-- ================================
CREATE TABLE IF NOT EXISTS orcamentos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  paciente_id INT NOT NULL,
  dentista_id INT NOT NULL,
  consulta_id INT DEFAULT NULL,
  data_orcamento DATETIME DEFAULT CURRENT_TIMESTAMP,
  status ENUM('aberto','aprovado') DEFAULT 'aberto',
  valor_total DECIMAL(10,2) DEFAULT 0.00,
  FOREIGN KEY (paciente_id) REFERENCES paciente(id),
  FOREIGN KEY (dentista_id) REFERENCES dentista(id),
  FOREIGN KEY (consulta_id) REFERENCES consultas(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ================================
-- ORCAMENTO ITENS
-- ================================
CREATE TABLE IF NOT EXISTS orcamento_itens (
  id INT AUTO_INCREMENT PRIMARY KEY,
  orcamento_id INT NOT NULL,
  procedimento_id INT NOT NULL,
  dente INT NOT NULL,
  face CHAR(1) NOT NULL,
  valor DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (orcamento_id) REFERENCES orcamentos(id) ON DELETE CASCADE,
  FOREIGN KEY (procedimento_id) REFERENCES procedimentos(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS = 1;