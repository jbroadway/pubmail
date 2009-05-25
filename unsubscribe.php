<?php

$settings = parse_ini_file ('settings.php');

require_once ('lib/functions.php');

$pm = new PubMail ($settings);

if (! empty ($_GET['email']) && $_GET['key'] == $settings['unsubscribe_key']) {
	$pm->move_subscriber ($_GET['email'], 'unsubscribed');
	require_once ('html/unsubscribed.php');
}

?>