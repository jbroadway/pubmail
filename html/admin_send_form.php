<?php require_once ('html/admin_header.php'); ?>

<h2>New message</h2>

<form method="POST">
<p>Subject: <input type="text" name="subject" size="40" value="<?php echo $settings['default_subject']; ?>" /></p>
<p>Message body:<br />
<textarea name="body" rows="20" class="body"><?php echo htmlentities (file_get_contents ('html/default_message.php')); ?></textarea></p>
<p><input type="submit" value="Send" /> &nbsp; <a href="index.php">Cancel</a></p>
</form>

<?php require_once ('html/admin_footer.php'); ?>