<?php

$url = getenv('PAYPAL_URL');
$file = getenv('PAYPAL_FILE');
$webhook = getenv('SLACK_WEBHOOK');

$dom = new DOMDocument;
libxml_use_internal_errors(true);
$dom->loadHTMLFile($file);

$ele = $dom->getElementsByTagName('title');

$for = trim($ele[0]->textContent);

$ele = $dom->getElementsByTagName('progress');

$currentAmount = null;
$totalAmount = null;
foreach ($ele[0]->attributes as $attribute)
{
	if ($attribute->name === 'max')
	{
		$totalAmount = $attribute->value;
	}

	if ($attribute->name === 'value')
	{
		$currentAmount = $attribute->value;
	}
}

$percentage = round($currentAmount / $totalAmount * 100);

$daysRemaining = $ele[0]->parentNode->parentNode->nextSibling->childNodes[1]->textContent;
$daysRemaining = str_replace('dagen', 'days', $daysRemaining);

$targetMessage = '';
if ($percentage >= 100)
{
	$targetMessage = "\n\nTarget reached, nice one! :tada:";
}

$slackMessage = [
	'username' => 'PayPal Fundraiser',
	'icon_emoji' => ':gift:',
	'text' => "Fundraiser for *'$for'*, has raised *£$currentAmount* out of *£$totalAmount*, *$percentage%* total! The fundraiser has *$daysRemaining left*.$targetMessage\n\n<$url>",
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
