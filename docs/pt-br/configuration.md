# Configuração

Após instalar o aplicativo com sucesso, você deve configurá-lo no painel de administração do Nextcloud.

Navegue até **Configurações de Administração -> Talk** para encontrar a seção "Configurações da Ponte XMPP".

## Configurações de Conexão

Estas configurações são para a conta XMPP que a ponte usará para se conectar e ouvir por mensagens.

- **JID do Bot**
  - O Jabber ID (JID) completo para a conta do bot.
  - *Exemplo*: `nextcloud-bridge@seu-servidor-xmpp.com`

- **Senha do Bot**
  - A senha para a conta XMPP do bot.

- **Host**
  - O nome do host ou endereço IP do seu servidor XMPP.
  - *Exemplo*: `seu-servidor-xmpp.com`

- **Porta**
  - A porta para a conexão com o servidor XMPP. O padrão é `5222`.

## Configurações de Roteamento

Estas configurações controlam como as mensagens são roteadas entre o Talk e o XMPP.

- **ID de Usuário do Bot**
  - Este é o **ID de Usuário do Nextcloud** da conta que atuará como o bot dentro do Talk. Quando a ponte postar mensagens do XMPP em uma conversa do Talk, ela o fará como este usuário. Isso também é usado para prevenir loops de mensagens (a ponte ignorará mensagens enviadas por este usuário no Talk).
  - *Exemplo*: `bridge_bot`

- **Domínio XMPP (para chats 1-para-1)**
  - Quando uma mensagem é enviada em um chat 1-para-1 no Talk, a ponte precisa construir o JID do destinatário. Ela faz isso combinando o ID de Usuário do Nextcloud com este domínio.
  - *Fórmula*: `jid_destinatario = <id_usuario_nextcloud>@<dominio_xmpp>`
  - *Exemplo*: `example.com`

- **Servidor de Conferência XMPP (para chats em grupo)**
  - Quando uma mensagem é enviada em um chat em grupo no Talk, a ponte precisa construir o JID para a sala de Multi-User Chat (MUC). Ela faz isso combinando o nome da conversa do Talk com este domínio de servidor de conferência.
  - *Fórmula*: `jid_muc = <nome_da_sala_talk>@<servidor_de_conferencia>`
  - *Exemplo*: `conference.example.com`
