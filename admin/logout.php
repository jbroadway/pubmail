<?php

chdir ('..');

$settings = parse_ini_file ('settings.php');

require_once ('lib/functions.php');

$pm = new PubMail ($settings);

$_SESSION['pubmail'] = null;
setcookie ('pubmail', false);

header ('Location: index.php');
exit;

?>