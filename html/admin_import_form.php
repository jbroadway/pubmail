<?php require_once ('html/admin_header.php'); ?>

<h2>Import subscribers</h2>

<form method="POST">
<p>Copy and paste email addresses below, one per line:<br />
<textarea name="import" rows="20" cols="60"></textarea></p>
<p><input type="checkbox" id="send_welcome" name="send_welcome" value="yes" /> <label for="send_welcome">Send the welcome email to these subscribers.</label></p>
<p><input type="submit" value="Import" /> &nbsp; <a href="subscribers.php">Cancel</a></p>
</form>

<?php require_once ('html/admin_footer.php'); ?>