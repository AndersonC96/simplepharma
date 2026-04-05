# SafeTickets Pro - Portfolio Case Study

**SafeTickets Pro** é o resultado de uma refatoração profunda de um sistema legado de suporte de TI. O objetivo deste projeto foi transformar um código "espaguete" e inseguro em uma aplicação PHP moderna, sanitizada e tecnicamente defensável para exibição em portfólio profissional.

---

## 📖 O Desafio da Refatoração (Legacy to Pro)
O sistema original apresentava vulnerabilidades críticas e uma arquitetura desorganizada. Minha missão foi reconstruir a base mantendo a stack original (PHP/MySQL), mas aplicando padrões de engenharia de software de alto nível.

### Evolução Técnica Principal:
- **Arquitetura**: Migração de um diretório raiz desorganizado para o padrão `public/` (Document Root), isolando a lógica de negócio (`src/`) e configurações (`config/`) do acesso público direto.
- **Segurança**: Substituí todas as interações inseguras de `mysqli` por **PDO com Prepared Statements**. Implementei hashing de senhas com BCRYPT e proteção contra ataques CSRF e Path Traversal.
- **Autoloading**: Implementação de **PSR-4 Autoloading** via Composer, eliminando a necessidade de `include` manuais em todo o projeto.

---

## 🛠️ Funcionalidades por Nível de Acesso

### 1. Painel Administrativo (Gestão Total)
- **Dashboard de Monitoramento**: Visualização em tempo real do volume de chamados em aberto e concluídos.
- **Gestão de Usuários e Técnicos**: Fluxo unificado para criação, edição e controle de acesso de todos os perfis do sistema.
- **Auditoria de Chamados**: Acesso completo ao histórico e detalhes de qualquer ticket gerado na plataforma.

### 2. Painel do Técnico (Operacional)
- **Fila de Atendimento**: Visualização exclusiva de chamados atribuídos ou pendentes.
- **Ciclo de Vida do Ticket**: Controle de estados (Aberto -> Em Atendimento -> Concluído) com registro automático de timestamps.
- **Histórico Individual**: Acompanhamento de indicadores de performance e tickets finalizados pelo próprio técnico.

### 3. Painel do Usuário / Cliente (Solicitante)
- **Abertura de Chamados**: Interface simplificada para descrição de problemas.
- **Sistema de Anexos**: Upload seguro de evidências (prints, logs) com sanitização automática de nomes de arquivos.
- **Acompanhamento**: Visualização do status atual sem a necessidade de contato direto com o suporte.

---

## 🛡️ Camada de Segurança (Deep Dive)
- **Proteção CSRF**: Classe `App\Csrf` dedicada que gera e valida tokens em todas as requisições POST.
- **Upload Sanitizado**: Classe `App\Uploader` que valida tipos MIME reais (não apenas extensões) e renomeia arquivos para hashes aleatórios.
- **RBAC (Role-Based Access Control)**: Middleware leve de autenticação que valida permissões granulares antes de renderizar qualquer rota.
- **Sanitização de Histórico**: Este repositório foi higienizado com ferramentas de limpeza de Git para garantir que nenhum dado sensível real ficasse rastreável no histórico de commits.

---

## 🎨 Design System V2 (Premium SaaS)
A interface foi projetada para oferecer uma experiência "SaaS-ready":
- **Sidebar Navigation**: Menu lateral retrátil inspirado em softwares profissionais.
- **UI Moderna**: Tipografia **Inter**, paleta de cores Indigo/Slate e componentes com *Glassmorphism*.
- **UX Responsivo**: Sistema adaptável para dispositivos móveis e desktops.

---

## 🚀 Instalação e Setup

1. **Requisitos**: PHP 8.1+, MySQL 8.0+, Composer.
2. **Dependências**: `composer install` para baixar o `vlucas/phpdotenv`.
3. **Ambiente**: Renomeie `.env.example` para `.env` e configure suas credenciais.
4. **Database**:
   - Execute `database/schema.sql` (Estrutura).
   - Execute `database/seed.sql` (Dados Fictícios de Demonstração).
5. **Vhost**: Aponte o Document Root para a pasta `/public`.

### Usuários de Demo:
| Perfil | Login | Senha |
|---|---|---|
| Administrador | `admin@safetickets.local` | `password` |
| Técnico | `tech1@safetickets.local` | `password` |
| Cliente | `subadmin@safetickets.local` | `password` |

---
**Desenvolvido como um case técnico de refatoração e engenharia de software.**
