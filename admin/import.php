<?php

chdir ('..');

$settings = parse_ini_file ('settings.php');

require_once ('lib/functions.php');

$pm = new PubMail ($settings);

if (! $pm->authenticate ()) {
	require_once ('html/admin_login.php');
	exit;
}

if (! empty ($_POST['import'])) {
	// import subscribers
	if ($_POST['send_welcome'] == 'yes') {
		$count = $pm->add_subscribers ($_POST['import'], true);
	} else {
		$count = $pm->add_subscribers ($_POST['import']);
	}
	require_once ('html/admin_imported.php');
} else {
	// show form
	require_once ('html/admin_import_form.php');
}

?>