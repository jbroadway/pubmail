<form method="post">
Mailing list (shows, news):
<input type="text" name="email" id="email" value="email address"
	onfocus="this.value = (this.value == 'email address') ? '' : this.value; return false"
	onblur="this.value = (this.value == '') ? 'email address' : this.value; return false"
/>
<input type="submit" value="Add" />
</form>
