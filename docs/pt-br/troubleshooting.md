# Solução de Problemas

Esta página lista problemas comuns e como resolvê-los.

### Problema: As configurações não estão sendo salvas

- **Sintoma**: Você clica em "Salvar" no painel de administração, mas os valores não são mantidos após recarregar a página.
- **Solução**:
  1. Verifique o console de desenvolvedor do seu navegador por quaisquer erros de JavaScript quando você clica em salvar.
  2. Verifique seu arquivo de log principal do Nextcloud (`nextcloud.log`) por erros relacionados ao `AdminController` ou problemas de banco de dados.
  3. Garanta que sua instância do Nextcloud tenha permissões de escrita no seu diretório `config/`.

### Problema: Mensagens do Talk não estão aparecendo no XMPP

- **Sintoma**: Mensagens enviadas em uma sala configurada do Talk não aparecem na sala/chat XMPP correspondente.
- **Solução**:
  1. Verifique o arquivo de log do Nextcloud (`nextcloud.log`) por quaisquer erros do aplicativo `talk_xmpp_bridge`. Procure por mensagens relacionadas ao `TalkEventListener` ou `XMPPService`.
  2. **Verifique todas as configurações** no painel de administração, especialmente o JID do Bot, senha e host.
  3. Garanta que seu servidor Nextcloud consegue alcançar seu servidor XMPP no host e porta configurados. Um firewall pode estar bloqueando a conexão.
  4. Verifique os logs no seu **servidor XMPP** para ver se uma tentativa de conexão da ponte está sendo feita.

### Problema: Mensagens do XMPP não estão aparecendo no Talk

- **Sintoma**: Mensagens enviadas de um cliente XMPP para o bot ou uma sala MUC não aparecem na conversa correspondente do Talk.
- **Solução**:
  1. **Isso é quase sempre um problema com a tarefa de fundo (Cron Job).** O ouvinte XMPP é executado como uma tarefa de fundo. Vá para **Configurações de Administração -> Configurações básicas**. Procure pela seção "Tarefas em segundo plano".
  2. Garanta que você selecionou "Cron" como o método de execução.
  3. Verifique o timestamp da "Última execução da tarefa". Se estiver antigo, o cron do seu sistema não está configurado corretamente para executar o script cron.php do Nextcloud. Por favor, siga a [documentação do Nextcloud](https://docs.nextcloud.com/server/latest/admin_manual/configuration_server/background_jobs_configuration.html) para configurar isso.
  4. Se a tarefa de fundo estiver sendo executada, verifique o arquivo de log do Nextcloud por erros do `XMPPListenerJob` ou `XMPPService`.
  5. Verifique se o usuário/sala de onde você está enviando no XMPP tem uma conversa correspondente no Talk à qual o usuário do bot (`bot_user_id`) tem acesso.
