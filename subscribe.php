<?php

$settings = parse_ini_file ('settings.php');

require_once ('lib/functions.php');

$pm = new PubMail ($settings);

if (! empty ($_POST['email'])) {
	$pm->add_subscribers ($_POST['email'], true);
	require_once ('html/subscribe_added.php');
} else {
	require_once ('html/subscribe_form.php');
}

?>