<?php

$url = 'https://paypal.com' . getenv('PAYPAL_URL');
$file = getenv('PAYPAL_FILE');
$webhook = getenv('SLACK_WEBHOOK');

$file = json_decode(file_get_contents($file), true);

$for = $file['fundraiser']['actions']['for']['output'][0];
$totalAmount = $file['fundraiser']['actions']['totalAmount']['output'][0];
$currentAmount = $file['fundraiser']['actions']['currentAmount']['output'][0];
$daysRemaining = rtrim($file['fundraiser']['actions']['daysRemaining']['output'][0]);

$percentage = round($currentAmount / $totalAmount * 100);

$targetMessage = '';
if ($percentage >= 100)
{
	$targetMessage = "\n\nTarget reached, nice one! :tada:";
}

$slackMessage = [
	'username' => 'PayPal Fundraiser',
	'icon_emoji' => ':gift:',
	'text' => "Fundraiser for *'$for'*, has raised *£$currentAmount* out of *£$totalAmount*, *$percentage%* total! The fundraiser has *$daysRemaining days left*.$targetMessage\n\n<$url>",
];

echo json_encode($slackMessage);

$options = [
	'http' => [
		'header' => "Content-Type: application/json\r\n",
		'method' => 'POST',
		'content' => json_encode($slackMessage),
	],
];

$context = stream_context_create($options);
$result = file_get_contents($webhook, false, $context);

var_dump($result);
