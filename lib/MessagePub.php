<?php

require_once ('lib/ActiveResource.php');

define ('MESSAGEPUB_URL', 'https://' . $settings['messagepub_api_key'] . '@messagepub.com/');

class Notification extends ActiveResource {
	var $site = MESSAGEPUB_URL;
	var $request_format = 'xml';
}

?>