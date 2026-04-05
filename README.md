# SafeTickets - Sistema de Gerenciamento de Chamados (Sanitizado)

Este repositório contém uma versão refatorada, segura e sanitizada de um sistema legado de chamados em PHP. O objetivo desta refatoração foi transformar um projeto interno em um case técnico profissional para portfólio público.

## 🚀 Melhorias e Refatorações Realizadas

### 1. Segurança e Privacidade
- **Sanitização de Dados**: Remoção completa de dados sensíveis (e-mails reais, nomes de funcionários e histórico de chamados). Substituído por `database/seed.sql` com dados fictícios.
- **Hashing de Senhas**: Substituição de senhas em texto puro por `password_hash()` (BCRYPT) e `password_verify()`.
- **Proteção CSRF**: Implementada em todos os formulários de ação (Login, Abertura de Chamado, Atualização de Status).
- **Upload Seguro**: Sistema de anexos refatorado para validar tipos MIME, extensões e renomear arquivos com hashes aleatórios, prevenindo ataques de execução e path traversal.
- **Prevenção de SQL Injection**: Migração completa de queries interpoladas para **Prepared Statements** utilizando PDO.

### 2. Arquitetura e Manutenção
- **Reorganização de Pastas**: Segregação de responsabilidades:
  - `public/`: Único ponto de entrada web.
  - `src/`: Lógica centralizada, Helpers e Classes.
  - `config/`: Configurações globais e bootstrap.
  - `storage/`: Armazenamento local de logs e uploads (ignorado pelo Git).
- **Variáveis de Ambiente**: Uso do `vlucas/phpdotenv` para remover credenciais hardcoded do código-fonte.
- **Centralização de Sessão**: Configurações de cookies seguras (`HttpOnly`, `SameSite=Lax`) e regeneração de ID após o login.
- **Padronização de Banco de Dados**: Schema modernizado para `InnoDB` com tipos de dados adequados (`DATETIME` em vez de `VARCHAR`).

### 3. Interface e Experiência
- **Neutralização de Marca**: Remoção de logos e referências a empresas reais, substituído por uma identidade visual genérica ("SafeTickets").
- **Componentes Reutilizáveis**: Navbar e layout centralizados para facilitar a manutenção visual.
- **Flash Messages**: Feedback amigável para o usuário em ações de sucesso ou erro.

## 🛠️ Stack Técnica
- **PHP 8.x** (Sem frameworks)
- **MySQL (PDO)**
- **Bootstrap 5 & FontAwesome**
- **Composer** (vlucas/phpdotenv)

## 📦 Como Instalar Localmente

### Pré-requisitos
- Servidor Web (Apache/Nginx)
- PHP 8.x
- MySQL
- Composer

### Passo a Passo
1. Clone o repositório.
2. Na raiz do projeto, execute: `composer install`.
3. Renomeie o arquivo `.env.example` para `.env` e configure suas credenciais de banco de dados.
4. Crie o banco de dados no MySQL e importe os arquivos na ordem:
   - `database/schema.sql`
   - `database/seed.sql`
5. Configure seu servidor web para apontar o *Document Root* para a pasta `public/`.

## 🧪 Perfis de Acesso (Demo)
| Papel | E-mail | Senha |
|---|---|---|
| Administrador | `admin@safetickets.local` | `password` |
| Técnico | `tech1@safetickets.local` | `password` |
| Cliente (SubAdmin) | `subadmin@safetickets.local` | `password` |

---
**Nota Técnica**: Como este projeto possui um histórico de versionamento que continha dados sensíveis expostos anteriormente, recomenda-se o uso de ferramentas como `BFG Repo-Cleaner` ou `git filter-repo` se for clonar o histórico completo para uso público.
