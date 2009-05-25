<?php require_once ('html/admin_header.php'); ?>

<h2>Export subscribers</h2>

<p>Copy and paste the email addresses below into any file or program to export your database:<br />
<textarea rows="20" cols="60"><?php

foreach ($pm->list_subscribers ('active') as $subscriber) {
	echo $subscriber->email . "\n";
}

?></textarea></p>

<p><a href="subscribers.php">Back</a></p>

<?php require_once ('html/admin_footer.php'); ?>