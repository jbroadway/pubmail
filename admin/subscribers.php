<?php

chdir ('..');

$settings = parse_ini_file ('settings.php');

require_once ('lib/functions.php');

$pm = new PubMail ($settings);

if (! $pm->authenticate ()) {
	require_once ('html/admin_login.php');
	exit;
}

if (! isset ($_GET['view'])) {
	$_GET['view'] = 'active';
}

$subscribers = $pm->list_subscribers ($_GET['view']);

require_once ('html/admin_subscribers.php');

?>