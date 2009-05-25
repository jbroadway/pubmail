<?php require_once ('html/admin_header.php'); ?>

<p>Subscriber moved to <a href="subscribers.php?view=<?php echo $_GET['to']; ?>"><?php echo $_GET['to']; ?></a>. <a href="subscribers.php">Back to subscribers</a>.</p>

<?php require_once ('html/admin_footer.php'); ?>