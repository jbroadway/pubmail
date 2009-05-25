<?php

chdir ('..');

$settings = parse_ini_file ('settings.php');

require_once ('lib/functions.php');

$pm = new PubMail ($settings);

if (! $pm->authenticate ()) {
	require_once ('html/admin_login.php');
	exit;
}

$pm->initialize ();
require_once ('html/admin_index.php');

?>