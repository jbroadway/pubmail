<?php

chdir ('..');

$settings = parse_ini_file ('settings.php');

require_once ('lib/functions.php');

$pm = new PubMail ($settings);

if (! $pm->authenticate ()) {
	require_once ('html/admin_login.php');
	exit;
}

require_once ('html/admin_export.php');

?>