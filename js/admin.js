document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('xmpp-bridge-form');
    if (!form) {
        return;
    }

    // Also, load current values
    const inputs = form.elements;
    const appName = 'talk_xmpp_bridge';
    OC.AppConfig.getValue(appName, 'xmpp_jid', (val) => inputs.xmpp_jid.value = val || '');
    OC.AppConfig.getValue(appName, 'xmpp_host', (val) => inputs.xmpp_host.value = val || '');
    OC.AppConfig.getValue(appName, 'xmpp_port', (val) => inputs.xmpp_port.value = val || '5222');
    OC.AppConfig.getValue(appName, 'bot_user_id', (val) => inputs.bot_user_id.value = val || '');
    OC.AppConfig.getValue(appName, 'xmpp_domain', (val) => inputs.xmpp_domain.value = val || '');
    OC.AppConfig.getValue(appName, 'conference_server', (val) => inputs.conference_server.value = val || '');
    // Password is not loaded for security reasons

    form.addEventListener('submit', function (event) {
        event.preventDefault();

        const url = OC.generateUrl('/apps/talk_xmpp_bridge/settings');
        const formData = new FormData(form);
        const params = new URLSearchParams();
        for (const pair of formData) {
            params.append(pair[0], pair[1]);
        }

        fetch(url, {
            method: 'POST',
            body: params,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'requesttoken': OC.requestToken,
            },
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Request failed');
            }
            return response.json();
        })
        .then(data => {
            if (data.status === 'success') {
                OC.Notification.show(t('talk_xmpp_bridge', 'Settings saved successfully'), { type: 'success' });
            } else {
                OC.Notification.show(t('talk_xmpp_bridge', 'Failed to save settings'), { type: 'error' });
            }
        })
        .catch(error => {
            console.error('Error saving settings:', error);
            OC.Notification.show(t('talk_xmpp_bridge', 'An error occurred while saving settings'), { type: 'error' });
        });
    });
});
