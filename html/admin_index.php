<?php require_once ('html/admin_header.php'); ?>

<p>Messages | <a href="subscribers.php">Subscribers</a> | <a href="logout.php">Log Out</a></p>

<p><a href="send.php">New message</a></p>

<p>
<table width="100%" cellspacing="0" cellpadding="2">
	<thead>
	<tr>
		<th align="left" width="50%">Subject</th>
		<th align="left" width="33%">Sent</th>
		<th align="center" width="17%">Recipients</th>
	</tr>
	</thead>
	<tbody>
<?php foreach ($pm->list_messages () as $n => $message) { ?>
	<?php echo ($n > 0 && ($n % 50) == 0) ? "</tbody>\n\t<tbody>\n" : ''; ?>
	<tr<?php echo (($n % 2) == 0) ? ' class="even"' : ''; ?>>
		<td><a href="view.php?id=<?php echo $message->id; ?>" rel="colorbox-<?php echo $message->id; ?>"><?php echo $message->subject; ?></a></td>
		<td><?php echo date ('F j, Y - g:ia', strtotime ($message->date)); ?></td>
		<td align="center"><?php echo (string) $message->recipients; ?></td>
	</tr>
<?php } ?>
	</tbody>
</table>
</p>

<?php require_once ('html/admin_footer.php'); ?>