<!--
  - SPDX-FileCopyrightText: 2025 Erik Sidnei Corrêa
  - SPDX-License-Identifier: CC0-1.0
-->
# Talk XMPP Bridge

**A bridge between Nextcloud Talk and the XMPP protocol.**

[Leia em Português (Brasil)](README_pt_br.md)

| Elevator                                  |
|-------------------------------------------|
| [✨ Why is this so awesome?](#-why-is-this-so-awesome) |
| [📚 Documentation](#-documentation)       |
| [🚧 Development Setup](#-development-setup) |

## ✨ Why is this so awesome?

This app bridges Nextcloud Talk conversations with XMPP.

* 💬 **Two-way Chat Sync!** Synchronize conversations between Nextcloud Talk and XMPP.
* 👥 **Direct & Group Messages!** Supports both 1-on-1 Talk conversations (as XMPP direct messages) and Talk group conversations (as XMPP Multi-User Chats - MUCs).
* 🌐 **Federated Communication!** Connect your Nextcloud instance with the wider XMPP network.
* 🚀 **Seamless Integration!** Works as a bridge, listening to events in Talk and relaying them to XMPP, and vice-versa.

If you have suggestions or problems, please open an issue.

---

## 📚 Documentation

* **[📗 Installation](docs/installation.md)**
* **[⚙️ Configuration](docs/configuration.md)**
* **[🏗️ Architecture](docs/architecture.md)**
* **[🚑 Troubleshooting](docs/troubleshooting.md)**

### 📦 Installing for Production

Nextcloud Talk XMPP Bridge is easy to install. You just need to enable the app from the Nextcloud App Store.

After installation, you must follow the [configuration guide](docs/configuration.md) to set up the connection to your XMPP server.

---

## 🚧 Development Setup

1. Simply clone this repository into the `apps` folder of your Nextcloud development instance.
2. Run `composer install` to install the dependencies.
3. Then activate it through the apps management. 🎉


---

## 💙 Contribution Guidelines

Contributions are welcome! Feel free to open an issue or submit a pull request.
