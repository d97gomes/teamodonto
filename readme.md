# 🦷 TeamOdonto

Sistema Web acadêmico para gestão completa de clínicas odontológicas.

---

## 📌 Visão Geral

O **TeamOdonto** é um sistema desenvolvido para fins acadêmicos, com o objetivo de aplicar conceitos de
desenvolvimento web utilizando PHP, MySQL e arquitetura MVC.

O sistema centraliza informações clínicas, administrativas e financeiras de uma clínica odontológica,
permitindo organização, controle e histórico de dados.

---

## 🧱 Arquitetura do Sistema

- **Padrão:** MVC (Model–View–Controller)
- **Front Controller:** `public/index.php`
- **Comunicação assíncrona:** Axios (JSON)
- **Controle de sessão:** PHP (`$_SESSION`)
<<<<<<< HEAD
- **Tratamento de exceções:** `try / catch` (Controller e Model)

### Fluxo Geral
Usuário → View → JavaScript (Axios)
→ public/index.php
→ Controller (try/catch)
→ Model (PDO)
→ Banco de Dados
→ JSON
→ View
=======

### Fluxo Geral
Navegador (HTML + JavaScript)
            ↓
        public/index.php (Front Controller)
            ↓
        Controller (ex: PacienteController)
            ↓
              Model
            ↓
            MySQL

O Front Controller centraliza tanto a navegação entre as páginas (views)
quanto as requisições de API, direcionando cada chamada ao controller
responsável.
>>>>>>> 8b3eb3a (Refatora estrutura para MVC com front controller)

---

## ⚙️ Tecnologias Utilizadas

### Back-end
- PHP 8.x
- MySQL
- PDO

### Front-end
- HTML5
- CSS3
- Bootstrap 5
- JavaScript puro
- Axios

### Infraestrutura
- XAMPP
- Git / GitHub

## 🚀 Como Executar o Projeto

1. Clone o repositório para a pasta `htdocs` do seu XAMPP.
2. Importe o arquivo `database.sql` (disponível na pasta `/sql` ou raiz) para o seu MySQL.
3. Certifique-se de que o módulo **Apache Rewrite** está ativo no seu servidor.
4. Acesse `http://localhost/teamodonto` no seu navegador.

## ✨ Principais Funcionalidades

- **CRUD Completo:** Gestão de pacientes, dentistas e agendas sem recarregamento de página.
- **Integração ViaCEP:** Preenchimento automático de endereços.
- **Segurança:** Proteção contra SQL Injection via Prepared Statements (PDO).
- **Módulo Financeiro:** Fluxo de caixa diário com registro automático de consultas.
- **Paginação:** Listagens otimizadas com LIMIT e OFFSET.

## 📁 Estrutura de Pastas

```text
app/          # Núcleo (Config, Controllers, Models, Views, Core)
public/       # Única pasta acessível (Assets, index.php)
vendor/       # Dependências (opcional)
.htaccess     # Configuração de URLs amigáveis

teamodonto/
│
├── app/
│   ├── config/
│   │   └── database.php
│   │
│   ├── core/
│   │   ├── App.php
│   │   └── Controller.php
│   │
│   ├── controllers/
│   │   ├── AuthController.php
│   │   ├── UsuarioController.php
│   │   ├── PacienteController.php
│   │   ├── DentistaController.php
│   │   ├── AnamneseController.php
│   │   ├── ExameClinicoController.php
│   │   ├── ProcedimentoController.php
│   │   ├── OrcamentoController.php
│   │   ├── AgendaController.php
│   │   └── FinanceiroController.php
│   │
│   ├── models/
│   │   ├── Endereco.php
│   │   ├── DadosPessoais.php
│   │   ├── Usuario.php
│   │   ├── Paciente.php
│   │   ├── Dentista.php
│   │   ├── Anamnese.php
│   │   ├── ExameClinico.php
│   │   ├── ExameClinicoDente.php
│   │   ├── Procedimento.php
│   │   ├── Orcamento.php
│   │   ├── OrcamentoItem.php
│   │   ├── Consulta.php
│   │   ├── Agenda.php
│   │   ├── Sala.php
│   │   ├── Caixa.php
│   │   └── MovimentacaoCaixa.php
│   │
│   └── views/
│       ├── auth/
│       ├── home/
│       ├── pacientes/
│       ├── dentistas/
│       ├── anamnese/
│       ├── exames/
│       ├── procedimentos/
│       ├── orcamentos/
│       ├── agenda/
│       ├── financeiro/
│       └── includes/
│           ├── navbar.php
│           ├── sidebar.php
│           ├── header.php
│           └── footer.php
│
├── public/
│   ├── css/
│   ├── js/
│   │   ├── axios.min.js
│   │   ├── endereco-viacep.js
│   │   └── app.js
│   ├── assets/
│   └── index.php
│
<<<<<<< HEAD
├── vendor/
│
└── .htaccess
=======
│
└── .htaccess
>>>>>>> 8b3eb3a (Refatora estrutura para MVC com front controller)
