# Troubleshooting

This page lists common issues and how to resolve them.

### Issue: Settings are not saving

- **Symptom**: You click "Save" in the admin panel, but the values are not retained after reloading the page.
- **Solution**: 
  1. Check your browser's developer console for any JavaScript errors when you click save.
  2. Check your main Nextcloud log file (`nextcloud.log`) for errors related to the `AdminController` or database issues.
  3. Ensure your Nextcloud instance has write permissions to its `config/` directory.

### Issue: Messages from Talk are not appearing in XMPP

- **Symptom**: Messages sent in a configured Talk room do not appear in the corresponding XMPP room/chat.
- **Solution**:
  1. Check the Nextcloud log file (`nextcloud.log`) for any errors from the `talk_xmpp_bridge` app. Look for messages related to `TalkEventListener` or `XMPPService`.
  2. **Verify all settings** in the admin panel are correct, especially the Bot JID, password, and host.
  3. Ensure your Nextcloud server can reach your XMPP server on the configured host and port. A firewall might be blocking the connection.
  4. Check the logs on your **XMPP server** to see if a connection attempt from the bridge is being made.

### Issue: Messages from XMPP are not appearing in Talk

- **Symptom**: Messages sent from an XMPP client to the bot or a MUC do not appear in the corresponding Talk conversation.
- **Solution**:
  1. **This is almost always a Cron Job issue.** The XMPP listener runs as a background job. Go to **Administration Settings -> Basic settings**. Look for the "Background jobs" section. 
  2. Ensure you have selected "Cron" as the execution method.
  3. Check the "Last job execution" timestamp. If it is old, your system's cron is not configured correctly to run the Nextcloud cron.php script. Please follow the [Nextcloud documentation](https://docs.nextcloud.com/server/latest/admin_manual/configuration_server/background_jobs_configuration.html) to set this up.
  4. If the cron job is running, check the Nextcloud log file for errors from `XMPPListenerJob` or `XMPPService`.
  5. Verify that the user/room you are sending from in XMPP has a corresponding conversation in Talk that the bot user (`bot_user_id`) has access to.
