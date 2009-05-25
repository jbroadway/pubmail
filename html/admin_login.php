<?php require_once ('html/admin_header.php'); ?>

<form method="post" action="index.php">

<?php echo (! empty ($_POST['username'])) ? '<p>Invalid username or password. Please try again.' : ''; ?>

<p>Username:<br />
<input type="text" name="username" value="<?php echo $_POST['username']; ?>" /></p>

<p>Password:<br />
<input type="password" name="password" value="<?php echo $_POST['password']; ?>" /></p>

<p><input type="submit" value="Enter" /></p>

</form>

<?php require_once ('html/admin_footer.php'); ?>