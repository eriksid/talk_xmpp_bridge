# Visão Geral da Arquitetura

Este documento fornece uma visão geral técnica de alto nível do aplicativo Ponte Talk XMPP.

## Componentes Principais

O aplicativo é construído em torno de algumas classes PHP chave e uma tarefa de fundo.

- **`XMPPService`**: Esta é a classe de serviço principal que lida com todas as interações com o servidor XMPP. Ela usa a biblioteca `xmppo/xmpp-php` para conectar, enviar mensagens e ouvir por mensagens recebidas.

- **`TalkEventListener`**: Esta classe implementa `IEventListener` e ouve pelo evento `ChatMessageSentEvent` do aplicativo Talk. Este é o ponto de entrada para a direção **Talk -> XMPP**.

- **`XMPPListenerJob`**: Esta classe implementa `IJob` e é registrada como uma tarefa de fundo (background job) do Nextcloud. Seu propósito é executar um processo de longa duração que ouve por mensagens XMPP recebidas. Este é o ponto de entrada para a direção **XMPP -> Talk**.

- **`AdminController` & `AdminSettings`**: Estas classes fornecem o painel de administração para configurar o aplicativo.

- **`Application`**: Esta é a classe principal do aplicativo que registra todos os serviços, ouvintes (listeners) e tarefas no contêiner de injeção de dependência do Nextcloud.

## Fluxo de Dados

### Talk -> XMPP

1.  Um usuário envia uma mensagem em uma conversa do Nextcloud Talk.
2.  O aplicativo Talk dispara um `ChatMessageSentEvent`.
3.  Nosso `TalkEventListener` captura este evento.
4.  O ouvinte inspeciona a conversa para ver se é um chat em grupo ou 1-para-1.
5.  Ele determina o JID do destinatário correto com base nas configurações de roteamento (ex: `usuario@dominio.xmpp` ou `sala@servidor.conferencia`).
6.  Ele chama `XMPPService->sendMessage()` para enviar a mensagem para o servidor XMPP.

### XMPP -> Talk

1.  O sistema Cron do Nextcloud executa o `XMPPListenerJob`.
2.  A tarefa chama `XMPPService->listen()`, que inicia um loop de bloqueio, esperando por mensagens XMPP.
3.  Um usuário envia uma mensagem para o JID do bot ou para uma sala MUC em que o bot está.
4.  O callback `XMPPService->handleIncomingMessage()` é acionado.
5.  O callback inspeciona a mensagem para determinar o remetente e se é uma mensagem de grupo ou 1-para-1.
6.  Ele usa o serviço `Talk\Manager` para encontrar a conversa correspondente no Talk.
7.  Ele usa o serviço `Talk\Api\IChatManager` para postar a mensagem na conversa encontrada, agindo como o usuário bot configurado.
