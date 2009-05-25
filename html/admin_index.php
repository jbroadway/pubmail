<?php require_once ('html/admin_header.php'); ?>

<p>Messages | <a href="subscribers.php">Subscribers</a></p>

<p><a href="send.php">New message</a></p>

<p>
<table width="100%" cellspacing="0" cellpadding="2">
	<tr>
		<th align="left" width="50%">Subject</th>
		<th align="left" width="33%">Sent</th>
		<th align="center" width="17%">Recipients</th>
	</tr>
<?php foreach ($pm->list_messages () as $message) { ?>
	<tr>
		<td><a href="view.php?id=<?php echo $message->id; ?>" rel="colorbox-<?php echo $message->id; ?>"><?php echo $message->subject; ?></a></td>
		<td><?php echo date ('F j, Y - g:ia', strtotime ($message->date)); ?></td>
		<td align="center"><?php echo (string) $message->recipients; ?></td>
	</tr>
<?php } ?>
</table>
</p>

<?php require_once ('html/admin_footer.php'); ?>