# Architecture Overview

This document provides a high-level technical overview of the Talk XMPP Bridge application.

## Core Components

The application is built around a few key PHP classes and a background job.

- **`XMPPService`**: This is the core service class that handles all interactions with the XMPP server. It uses the `xmppo/xmpp-php` library to connect, send messages, and listen for incoming messages.

- **`TalkEventListener`**: This class implements `IEventListener` and listens for the `ChatMessageSentEvent` from the Talk app. This is the entry point for the **Talk -> XMPP** direction.

- **`XMPPListenerJob`**: This class implements `IJob` and is registered as a Nextcloud background job. Its purpose is to run a long-lived process that listens for incoming XMPP messages. This is the entry point for the **XMPP -> Talk** direction.

- **`AdminController` & `AdminSettings`**: These classes provide the administration panel for configuring the application.

- **`Application`**: This is the main app class that registers all services, listeners, and jobs in the Nextcloud dependency injection container.

## Data Flow

### Talk -> XMPP

1.  A user sends a message in a Nextcloud Talk conversation.
2.  The Talk app dispatches a `ChatMessageSentEvent`.
3.  Our `TalkEventListener` catches this event.
4.  The listener inspects the conversation to see if it's a group or 1-to-1 chat.
5.  It determines the correct recipient JID based on the routing settings (e.g., `user@xmpp.domain` or `room@conference.domain`).
6.  It calls `XMPPService->sendMessage()` to send the message to the XMPP server.

### XMPP -> Talk

1.  The Nextcloud Cron system executes the `XMPPListenerJob`.
2.  The job calls `XMPPService->listen()`, which starts a blocking loop, waiting for XMPP messages.
3.  A user sends a message to the bot's JID or to a MUC the bot is in.
4.  The `XMPPService->handleIncomingMessage()` callback is triggered.
5.  The callback inspects the message to determine the sender and if it's a group or 1-to-1 message.
6.  It uses the `Talk\Manager` service to find the corresponding Talk conversation.
7.  It uses the `Talk\Api\IChatManager` service to post the message into the found conversation, acting as the configured bot user.
