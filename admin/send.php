<?php

chdir ('..');

$settings = parse_ini_file ('settings.php');

require_once ('lib/functions.php');

$pm = new PubMail ($settings);

if (! $pm->authenticate ()) {
	require_once ('html/admin_login.php');
	exit;
}

if (! empty ($_POST['subject']) && ! empty ($_POST['body'])) {
	// add to queue
	/*$_POST['body'] = str_replace (
		'{unsubscribe_link}',
		'http://' . $_SERVER['HTTP_HOST'] . '/' . $pm->app_name () . '/unsubscribe.php?email={email_address}&key=' . $settings['unsubscribe_key'],
		$_POST['body']
	);*/
	$count = $pm->send_message ($_POST['subject'], $_POST['body']);
	require_once ('html/admin_sent.php');
} else {
	// show form
	require_once ('html/admin_send_form.php');
}

?>