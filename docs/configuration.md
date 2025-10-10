# Configuration

After successfully installing the app, you must configure it from the Nextcloud administration panel.

Navigate to **Administration Settings -> Talk** to find the "XMPP Bridge Settings" section.

## Connection Settings

These settings are for the XMPP account that the bridge will use to connect and listen for messages.

- **Bot JID**
  - The full Jabber ID (JID) for the bot account.
  - *Example*: `nextcloud-bridge@your-xmpp-server.com`

- **Bot Password**
  - The password for the bot's XMPP account.

- **Host**
  - The hostname or IP address of your XMPP server.
  - *Example*: `your-xmpp-server.com`

- **Port**
  - The port for the XMPP server connection. Defaults to `5222`.

## Routing Settings

These settings control how messages are routed between Talk and XMPP.

- **Bot User ID**
  - This is the **Nextcloud User ID** of the account that will act as the bot within Talk. When the bridge posts messages from XMPP into a Talk conversation, it will do so as this user. This is also used to prevent message loops (the bridge will ignore messages sent by this user in Talk).
  - *Example*: `bridge_bot`

- **XMPP Domain (for 1-to-1 chats)**
  - When a message is sent in a 1-to-1 chat in Talk, the bridge needs to construct the recipient's JID. It does this by combining the Nextcloud User ID with this domain.
  - *Formula*: `recipient_jid = <nextcloud_user_id>@<xmpp_domain>`
  - *Example*: `example.com`

- **XMPP Conference Server (for group chats)**
  - When a message is sent in a group chat in Talk, the bridge needs to construct the JID for the Multi-User Chat (MUC) room. It does this by combining the Talk conversation name with this conference server domain.
  - *Formula*: `muc_jid = <talk_room_name>@<conference_server>`
  - *Example*: `conference.example.com`
