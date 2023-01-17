PayPal Fundraiser Slack Notifier
================================

A small repo to use `domcurl` to curl a PayPal Fundraiser page and then use PHP to parse the HTML file and send a Slack Incoming Webhook request.

Required Env Vars
-----------------

`PAYPAL_URL` - The PayPal Fundraiser URL
`PAYPAL_FILE` - The filename to save the HTML page to
`SLACK_WEBHOOK` - The Slack Webhook URL to send the message to
