# 🏥 SaaS Clínicas

Sistema **SaaS para gestão de clínicas**, com foco em **agendamentos**, **controle de presença**, **cancelamentos**, **faltas** e **regras de negócio bem definidas**.

Este projeto foi desenvolvido com foco em **boas práticas**, **organização de código**, **testes automatizados** e **lógica de domínio real**, simulando problemas enfrentados em sistemas usados no dia a dia.

---

## 🚀 Funcionalidades

### 📅 Agendamentos
- Criar agendamentos por profissional e paciente
- Validação de conflitos de horário
- Controle de horário de início e fim

### 🔄 Status do Agendamento
- Confirmar presença
- Cancelar agendamento
- Marcar falta
- Concluir atendimento

### ⚠️ Regras de Negócio
- ❌ Não permite cancelar com menos de 1h de antecedência
- ❌ Não permite alterar status de agendamento cancelado
- ❌ Não permite marcar falta antes do tempo de tolerância
- ❌ Não permite concluir agendamento já concluído ou cancelado
- ✅ Controle rigoroso de transições de status

### 🧪 Testes Automatizados
- Testes de **Feature**
- Testes focados em **regras de negócio**
- Uso de **Carbon::setTestNow** para simular cenários reais de tempo

---

## 🧱 Arquitetura

- Separação clara de responsabilidades
- Uso de **Actions** para encapsular regras de negócio
- Exceptions específicas para cada regra inválida
- Enum para controle de status
- Código organizado e fácil de manter

---

## 🛠️ Tecnologias Utilizadas

- **PHP 8.2**
- **Laravel**
- **MySQL**
- **Blade**
- **SCSS**
- **PHPUnit**
- **Carbon**

---

## 🧪 Executando os testes

```bash
php artisan test
```

---

## ⚙️ Instalação do Projeto

```bash
git clone https://github.com/ViniciusCosta126/saas-clinicas.git
cd saas-clinicas
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

---

## 🎯 Objetivo do Projeto

Este projeto foi criado com o objetivo de demonstrar domínio de Laravel, regras de negócio reais, boas práticas de arquitetura e testes automatizados.

---

## 👨‍💻 Autor

**Vinicius Costa**  
GitHub: https://github.com/ViniciusCosta126
