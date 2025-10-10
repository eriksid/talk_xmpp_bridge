<?php
script('talk_xmpp_bridge', 'admin');
?>

<div id="talk_xmpp_bridge_settings" class="section">
    <h2><?php p($l->t('XMPP Bridge Settings')); ?></h2>
    <p class="settings-hint"><?php p($l->t('Configure the XMPP bot account used for bridging.')); ?></p>

    <form id="xmpp-bridge-form" action="#" method="post">
        <p>
            <label for="xmpp_jid"><?php p($l->t('Bot JID')); ?></label>
            <input type="text" id="xmpp_jid" name="xmpp_jid" placeholder="bot@example.com" value="">
        </p>
        <p>
            <label for="xmpp_password"><?php p($l->t('Bot Password')); ?></label>
            <input type="password" id="xmpp_password" name="xmpp_password" value="">
        </p>
        <p>
            <label for="xmpp_host"><?php p($l->t('Host')); ?></label>
            <input type="text" id="xmpp_host" name="xmpp_host" placeholder="xmpp.example.com" value="">
        </p>
        <p>
            <label for="xmpp_port"><?php p($l->t('Port')); ?></label>
            <input type="number" id="xmpp_port" name="xmpp_port" placeholder="5222" value="">
        </p>

        <hr/>

        <h4><?php p($l->t('Routing Settings')); ?></h4>

        <p>
            <label for="bot_user_id"><?php p($l->t('Bot User ID')); ?></label>
            <input type="text" id="bot_user_id" name="bot_user_id" placeholder="nextcloud_bot_username">
            <em class="settings-hint"><?php p($l->t('The Nextcloud user ID that the bot uses. Used to prevent message loops.')); ?></em>
        </p>
        <p>
            <label for="xmpp_domain"><?php p($l->t('XMPP Domain (for 1-to-1 chats)')); ?></label>
            <input type="text" id="xmpp_domain" name="xmpp_domain" placeholder="example.com">
            <em class="settings-hint"><?php p($l->t('The domain used to construct user JIDs (e.g., user@<domain>).')); ?></em>
        </p>
        <p>
            <label for="conference_server"><?php p($l->t('XMPP Conference Server (for group chats)')); ?></label>
            <input type="text" id="conference_server" name="conference_server" placeholder="conference.example.com">
            <em class="settings-hint"><?php p($l->t('The MUC server domain (e.g., room@<domain>).')); ?></em>
        </p>

        <input type="submit" value="<?php p($l->t('Save')); ?>">
    </form>
</div>
