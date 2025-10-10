# Instalação

Siga estes passos para instalar o aplicativo Ponte Talk XMPP.

## Pré-requisitos

1.  Uma instância funcional do Nextcloud (Versão 25+).
2.  O aplicativo **Talk** (spreed) deve estar instalado e ativado.
3.  O `composer` deve estar instalado no seu servidor.
4.  Você precisa de acesso via shell ao seu servidor Nextcloud.
5.  Uma cron de sistema configurada corretamente para as tarefas de fundo do Nextcloud é altamente recomendada para que a ponte na direção XMPP -> Talk funcione de forma confiável.

## Passos de Instalação

1.  **Navegue até o diretório de aplicativos do seu Nextcloud.**
    ```bash
    cd /caminho/para/seu/nextcloud/apps
    ```

2.  **Obtenha o código do aplicativo.**
    Clone ou baixe o diretório `talk_xmpp_bridge` para dentro desta pasta `apps/`.

3.  **Navegue para dentro do diretório do aplicativo.**
    ```bash
    cd talk_xmpp_bridge
    ```

4.  **Instale as dependências PHP.**
    Execute o composer para baixar as bibliotecas necessárias (como o cliente XMPP).
    ```bash
    composer install --no-dev
    ```

5.  **Defina as permissões de arquivo.**
    Garanta que o diretório do aplicativo tenha o mesmo proprietário e permissões que seus outros aplicativos do Nextcloud. O proprietário geralmente deve ser o usuário do seu servidor web (ex: `www-data`).
    ```bash
    chown -R www-data:www-data .
    ```

6.  **Ative o Aplicativo.**
    Vá para a página de "Aplicativos" do seu Nextcloud, encontre "Talk XMPP Bridge" na lista de aplicativos desativados e clique em "Ativar".

7.  **Configure o Aplicativo.**
    Após ativar, prossiga para os passos de [Configuração](configuration.md).
