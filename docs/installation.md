# Installation

Follow these steps to install the Talk XMPP Bridge application.

## Prerequisites

1.  A working Nextcloud instance (Version 25+).
2.  The **Talk** (spreed) application must be installed and enabled.
3.  `composer` must be installed on your server.
4.  You need shell access to your Nextcloud server.
5.  A properly configured system cron for Nextcloud background jobs is highly recommended for the XMPP -> Talk bridge to work reliably.

## Installation Steps

1.  **Navigate to your Nextcloud apps directory.**
    ```bash
    cd /path/to/your/nextcloud/apps
    ```

2.  **Get the application code.**
    Clone or download the `talk_xmpp_bridge` directory into this `apps/` folder.

3.  **Navigate into the app directory.**
    ```bash
    cd talk_xmpp_bridge
    ```

4.  **Install PHP dependencies.**
    Run composer to download the required libraries (like the XMPP client).
    ```bash
    composer install --no-dev
    ```

5.  **Set file permissions.**
    Ensure the app directory has the same ownership and permissions as your other Nextcloud apps. The owner should typically be your web server user (e.g., `www-data`).
    ```bash
    chown -R www-data:www-data .
    ```

6.  **Enable the App.**
    Go to your Nextcloud "Apps" page, find "Talk XMPP Bridge" in the list of disabled apps, and click "Enable".

7.  **Configure the App.**
    After enabling, proceed to the [Configuration](configuration.md) steps.
