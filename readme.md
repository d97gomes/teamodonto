# TEAMODONTO

Sistema web acadêmico para gerenciamento de clínicas odontológicas.

---

## 📌 Visão Geral

O **TEAMODONTO** é um sistema web desenvolvido com fins acadêmicos para auxiliar na organização e gerenciamento de clínicas odontológicas.  
O sistema foi projetado para controlar pacientes, seus dados de endereço e, futuramente, informações clínicas como anamnese, exame clínico, orçamento, agendamento e consultas.

O projeto prioriza **clareza**, **organização**, **lógica clínica correta** e **escopo adequado para avaliação universitária**.

---

## 🎯 Objetivo do Projeto

Centralizar e organizar as informações de uma clínica odontológica, permitindo:

- Cadastro e gerenciamento de pacientes
- Cadastro de endereço vinculado ao paciente
- Listagem com paginação e busca
- Estrutura preparada para módulos clínicos
- Interface administrativa organizada com sidebar

---

## 🛠 Tecnologias Utilizadas

- PHP 8.x  
- MySQL  
- HTML5  
- CSS3  
- Bootstrap 5  
- JavaScript  
- Axios  
- XAMPP  

---

## 🧱 Arquitetura do Sistema

O projeto utiliza uma **arquitetura MVC simplificada**, adequada para projetos acadêmicos:

- **Model**: acesso ao banco de dados  
- **Controller**: regras de negócio e fluxo de dados  
- **API**: comunicação entre front-end e back-end  
- **Public**: páginas acessadas pelo usuário e layout  

Não é utilizado framework PHP nem Composer, pois o projeto é desenvolvido em **PHP puro**, conforme o escopo acadêmico.

## 👤 Módulo Paciente

O módulo **Paciente** é o núcleo inicial do sistema e serve como base para os demais módulos clínicos.

Funcionalidades implementadas e planejadas:

- Cadastro de paciente
- Cadastro de endereço vinculado
- Listagem de pacientes
- Busca por nome ou CPF
- Paginação (10 registros por página)
- Edição e exclusão de pacientes

---

## 🏠 Endereço

O **endereço** é tratado como uma **entidade de apoio**, não possuindo módulo próprio.

Características:
- O endereço é cadastrado junto com o paciente
- Cada paciente possui um endereço
- O endereço é armazenado em tabela separada
- Evita duplicação de dados
- Mantém a normalização do banco

---

## 🔄 Fluxo de Cadastro do Paciente

O fluxo de cadastro segue a seguinte ordem:

1. O usuário informa os dados do endereço  
2. O sistema cria o endereço no banco de dados  
3. O `endereco_id` gerado é recuperado  
4. O paciente é cadastrado utilizando esse `endereco_id`  

Esse fluxo é controlado pelo **PacienteController**, garantindo a integridade dos dados.

---

## 🧭 Interface do Usuário

A interface do sistema segue o padrão de sistemas administrativos:

- **Navbar lateral fixa (sidebar)**
- Menu principal com acesso aos módulos
- Área de conteúdo dinâmica
- Barra de ações em cada módulo (Criar + Buscar)
- Tabelas de dados
- Paginação

---

## 📄 Paginação e Histórico

O sistema **não possui um módulo de histórico separado**.

O histórico é obtido através das **listagens paginadas de cada funcionalidade**, como:
- Anamneses do paciente
- Exames clínicos
- Orçamentos
- Agendamentos
- Consultas

Cada módulo é responsável por manter seus próprios registros.

---

## ✅ Estado Atual do Projeto

Até este ponto, o projeto possui:

- Banco de dados criado
- Tabelas estruturadas
- Backend funcional
- CRUD de Paciente planejado
- Endereço integrado ao paciente
- Estrutura de layout definida
- Documentação completa

O sistema está preparado para evolução dos módulos clínicos e administrativos.

---

## 📌 Observações Finais

Este projeto foi desenvolvido exclusivamente para fins acadêmicos, priorizando simplicidade, clareza e organização, sem o uso de frameworks complexos ou dependências externas desnecessárias.