<!--
  - SPDX-FileCopyrightText: 2025 Erik Sidnei Corrêa
  - SPDX-License-Identifier: CC0-1.0
-->
# Talk XMPP Bridge

**Uma ponte entre o Nextcloud Talk e o protocolo XMPP.**

| Navegação Rápida                          |
|-------------------------------------------|
| [✨ Por que isso é tão incrível?](#-por-que-isso-é-tão-incrível) |
| [📚 Documentação](#-documentação)          |
| [🚧 Ambiente de Desenvolvimento](#-ambiente-de-desenvolvimento) |

## ✨ Por que isso é tão incrível?

Este aplicativo faz a ponte entre as conversas do Nextcloud Talk e o XMPP.

* 💬 **Sincronização bidirecional de chats!** Sincroniza conversas entre o Nextcloud Talk e o XMPP.  
* 👥 **Mensagens diretas e em grupo!** Suporta tanto conversas individuais (como mensagens diretas XMPP) quanto conversas em grupo (como Salas de Chat Multiusuário — MUCs).  
* 🌐 **Comunicação federada!** Conecte sua instância do Nextcloud à ampla rede XMPP.  
* 🚀 **Integração transparente!** Atua como uma ponte, ouvindo eventos no Talk e retransmitindo-os para o XMPP — e vice-versa.  

Se tiver sugestões ou encontrar algum problema, abra uma *issue*.

---

## 📚 Documentação

* **[📗 Instalação](docs/installation.md)**
* **[⚙ Configuração](docs/configuration.md)**
* **[🏗 Arquitetura](docs/architecture.md)**
* **[🚑 Solução de Problemas](docs/troubleshooting.md)**

### 📦 Instalação em Produção

O Nextcloud Talk XMPP Bridge é fácil de instalar.  
Basta ativar o aplicativo pela **Loja de Aplicativos do Nextcloud**.

Após a instalação, siga o [guia de configuração](docs/configuration.md) para definir a conexão com o seu servidor XMPP.

---

## 🚧 Ambiente de Desenvolvimento

1. Clone este repositório na pasta `apps` da sua instância de desenvolvimento do Nextcloud.  
2. Execute `composer install` para instalar as dependências.  
3. Ative o aplicativo pelo painel de gerenciamento de apps. 🎉  

---

## 💙 Diretrizes de Contribuição

Contribuições são bem-vindas!  
Sinta-se à vontade para abrir uma *issue* ou enviar um *pull request*.

