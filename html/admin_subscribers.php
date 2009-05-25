<?php require_once ('html/admin_header.php'); ?>

<p><a href="index.php">Messages</a> | Subscribers</p>

<p style="float: right">View:
	<a href="?view=active">Active</a> |
	<a href="?view=unsubscribed">Unsubscribed</a> |
	<a href="?view=bounced">Bounced</a> |
	<a href="?view=deleted">Deleted</a>
</p>

<p style="float: left"><?php echo count ($subscribers); ?> subscribers. <a href="import.php">Add subscribers</a></p>

<p style="clear: both">
<table width="100%" cellspacing="0" cellpadding="2">
	<tr>
		<th align="left" width="50%">Email</th>
		<th align="right" width="50%">Actions</th>
	</tr>
<?php foreach ($subscribers as $subscriber) { ?>
	<tr>
		<td><?php echo $subscriber->email; ?></td>
		<td align="right"><form style="display: inline" method="GET" action="move.php">
			<input type="hidden" name="email" value="<?php echo $subscriber->email; ?>" />
			Move to: <select name="to" onchange="this.form.submit ()">
				<option value="">- SELECT -</option>
				<option value="active">Active</option>
				<option value="unsubscribed">Unsubscribed</option>
				<option value="bounced">Bounced</option>
				<option value="deleted">Deleted</option>
			</select>
		</form></td>
	</tr>
<?php } ?>
</table>
</p>

<?php require_once ('html/admin_footer.php'); ?>