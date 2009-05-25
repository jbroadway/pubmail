<?php

chdir ('..');

$settings = parse_ini_file ('settings.php');

require_once ('lib/functions.php');

$pm = new PubMail ($settings);

if (! $pm->authenticate ()) {
	require_once ('html/admin_login.php');
	exit;
}

$msg = $pm->view_message ($_GET['id']);

echo '<pre>' . $msg->body . '</pre>';

?>