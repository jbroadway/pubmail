Requirements
------------

1. A website host running Apache + PHP5 with htaccess support (most hosts
have this) with FTP or SSH access to it.

2. Crontab for running scheduled background tasks on your site.

Installation and first steps
----------------------------

1. Unzip and FTP to the root folder of your website.

2. In FTP, edit the properties of the folder pubmail/admin/data
and set them to 0777 (read + write + execute for all).

3. Now open the file settings.php for editing and change the settings
found there. You will need to register at messagepub.com to fill in the
required messagepub_api_key value.

	While you're logged into messagepub.com, edit your account settings. Here
you should change two settings:

	a. Change your name: Enter your artist, band, label or company name here

	b. Replies setting: Enter your artist, band, label or company email address here

4. Edit your crontab and add the following line to it, which will run the
message sending script:

		*/2 * * * * cd /PATH/TO/SITE/pubmail; /usr/bin/php -f queue.php

	Make sure you change "/PATH/TO/SITE" to be the actual folder path to your
website, and /usr/bin/php may need to be changed to the location of PHP
on your server as well.

	If you can use SSH to log into your website, you can find out what the
path to your site is by typing "pwd" and hitting enter. You can find out
the path to PHP by typing "which php" and hitting enter.

5. Open your browser and go to /pubmail/admin at your site. You
should be able to log in using the admin username and password you set
in step 3.

6. Import your existing email addresses into the subscribers list.

7. Open the folder pubmail/html and change any of the default
info to suit your site.

8. To send a message, click "New Message" and enter a subject and body
for the message, then click "Send". The message will be added to the
queue and sent at a rate of 50 emails every 2 minutes, which complies
with the sending limits of messagepub.com.

That's all there is to it, you now have a working email newsletter for
yourself, your band, label or company!

Integrating into your website
-----------------------------

The easiest way to integrate the PubMail application into your website is
simply to link to /pubmail like this:

	<a href="/pubmail/">Sign up to our mailing list</a>

This will create a link to a sign-up form that takes care of the rest.

If you want to integrate the sign-up form into your web pages though,
then you can do this in one of three ways:

1. Include the sign-up form by adding this line of PHP code to any .php
file:

		<?php include_once ('pubmail/subscribe.php'); ?>

2. Include the subscribe.php form as an iframe in a static .html file:

		<iframe src="/pubmail/subscribe.php" width="300" height="20"></iframe>

3. Build your own sign-up form that submits to the PubMail subscription
handler:

		<form method="POST" action="/pubmail/">
		Subscribe to our mailing list:<br />
		<input type="text" name="email" />
		<input type="submit" value="Subscribe" />
		</form>

Feel free to customize the form all you like, but make sure to keep the
form tag and the email field name as-is or it won't work.

Customizing the look
--------------------

The files in the html folder help you customize the look of the subscription
page as well as the default messages. The files you'll want to customize are:

* default_message.php
* footer.php
* header.php
* style.css
* welcome_email.php

Mailing list etiquette
----------------------

Sending email to people who have subscribed to your newsletter is not spam.
However, it's easy to accidentally fall into spammy behaviour if you don't
know a bit of etiquette.

People don't like to be auto-subscribed to something they didn't ask for.
It's a great idea to provide incentives to sign up (a free MP3 in the
welcome email for example, or members-only exclusives), but let subscribers
opt-in versus having to manually opt-out and they'll like you more for it.

Similarly, when importing subscribers through the admin area, make sure
you've already got their permission to do so, usually from collecting them
at shows or events, or from a previous mailing list that this is replacing.

Another thing to note is that the reply-to address is going to receive
bounced message notices from time to time as email addresses change. When
a message comes back to you as bounced with a permanent failure error,
make sure you log into the admin area and set that email address to bounced
so it stops receiving messages. People can unsubscribe themselves from
a link in the messages, but you have to handle bounces yourself.

Remembering to do this helps free you from seeing that bounced message in
the future, but also saves you sending an extra message unnecessarily
("a penny saved is a penny earned...") and helps ensure email hosts don't
start thinking your messages are spam. Repeatedly sending to bounced
addresses is one way they use to try to detect spammers.

Being careful here can help ensure your messages get through to happy
subscribers, instead of being an annoyance to unwitting recipients.
Happy sending!

-----

Brought to you by [Johnny Broadway](http://www.johnnybroadway.com/).
