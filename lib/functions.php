<?php

require_once ('lib/MessagePub.php');
require_once ('lib/Database.php');

class PubMail {
	/**
	 * The global settings.
	 */
	var $settings = array ();

	/**
	 * Are they logged in?
	 */
	var $valid = false;

	/**
	 * An error returned from send_mail().
	 */
	var $error = false;

	/**
	 * Pass the settings to the constructor.
	 */
	function __construct ($settings) {
		$this->settings = $settings;
	}

	/**
	 * Initialize database tables.
	 */
	function initialize () {
		db_execute ('create table subscribers (
			email char(128) not null,
			status char(12) not null,
			primary key (email)
		)');
		db_execute ('create table messages (
			id integer primary key,
			subject char(128) not null,
			date datetime not null,
			recipients integer not null default 0,
			body text not null
		)');
		db_execute ('create table queue (
			id integer primary key,
			email char(128) not null,
			message_id integer not null,
			subject char(128) not null,
			body text not null
		)');
	}

	/**
	 * Check admin login status.
	 */
	function authenticate () {
		session_start ();

		if (! empty ($_COOKIE['pubmail']) && $_COOKIE['pubmail'] == $_SESSION['pubmail']) {
			$this->valid = true;
			return true;
		}

		if (! empty ($_POST['username']) && ! empty ($_POST['password'])) {
			if ($_POST['username'] == $this->settings['admin_username'] && $_POST['password'] == $this->settings['admin_password']) {
				$key = md5 (mt_rand () . $_POST['username'] . $_POST['password']);
				setcookie ('pubmail', $key);
				$_SESSION['pubmail'] = $key;
				$this->valid = true;
				return true;
			}
		}

		return false;
	}

	/**
	 * Send an actual message through messagepub.com
	 */
	function send_mail ($to, $subject, $body) {
		// create the message
		$recipients = array ();
		$n = 1;
		foreach ($to as $email) {
			$recipients[] = array (
				'position' => $n,
				'channel' => 'email',
				'address' => $email,
			);
			$n++;
		}
		$n = new Notification (array (
			'body' => $body,
			'subject' => $subject,
			'escalation' => '0',
			'recipients' => array ('recipient' => $recipients)
		));
	
		// send the message
		$n->save ();
		if ($n->error) {
			$this->error = $n->error;
			return false;
		}
		return true;
	}

	/**
	 * Add one or more subscribers (one-per line or an array) to the database.
	 * Will optionally send them a welcome email.
	 */
	function add_subscribers ($emails, $send_welcome = false) {
		if (strpos ($emails, "\n") !== false) {
			$emails = explode ("\n", $emails);
		}
		if (! is_array ($emails)) {
			$emails = array ($emails);
		}
		foreach ($emails as $email) {
			$email = strtolower (trim ($email));
			if (empty ($email)) {
				continue;
			}
			db_execute ('insert into subscribers values (%s, "active")', $email);
			if ($send_welcome) {
				$this->add_to_queue (
					$email,
					0,
					'', //Thanks for subscribing!',
					'' //file_get_contents ('html/welcome_email.php')
				);
			}
		}
		return count ($emails);
	}

	/**
	 * Change a subscriber's status between active, unsubscribed, bounced, and deleted.
	 */
	function move_subscriber ($email, $to) {
		return db_execute (
			'update subscribers set status = %s where email = %s',
			$to,
			$email
		);
	}

	/**
	 * List all subscribers by status.
	 */
	function list_subscribers ($status = 'active') {
		return db_fetch_array (
			'select * from subscribers where status = %s order by email asc',
			$status
		);
	}

	/**
	 * List all past messages.
	 */
	function list_messages () {
		return db_fetch_array (
			'select id, subject, date, recipients from messages order by date desc'
		);
	}

	/**
	 * Retrieve a single past message.
	 */
	function view_message ($id) {
		return db_single (
			'select * from messages where id = %s',
			$id
		);
	}

	/**
	 * Saves a message and adds the current subscribers to the queue to
	 * receive it.
	 */
	function send_message ($subject, $body) {
		// 1. save message
		db_execute (
			'insert into messages (subject, date, body) values (%s, datetime("now"), %s)',
			$subject,
			$body
		);

		$message_id = db_lastid ();

		// 2. get subscribers and add them to the queue
		$subscribers = $this->list_subscribers ();
		foreach ($subscribers as $subscriber) {
			//$_body = str_replace ('{email_address}', $subscriber->email, $body);
			$this->add_to_queue (
				$subscriber->email,
				$message_id,
				$subject,
				$body
			);
		}
	}

	/**
	 * Adds a message to the queue to be sent out.
	 */
	function add_to_queue ($email, $message_id, $subject, $body) {
		return db_execute (
			'insert into queue (email, message_id, subject, body) values (%s, %s, %s, %s)',
			$email,
			$message_id,
			'', //$subject,
			'' //$body
		);
	}

	/**
	 * Send messages from the queue. Takes any welcome messages first, then looks for
	 * the next message_id in the queue and tries to send up to 50 messages for that
	 * message at a time. This means a max of 2 messages (with multiple recipients)
	 * per run, which adds up to 60 requests per hour with 3,000 recipients for
	 * messages plus however many welcome messages on top of that.
	 */
	function run_queue () {
		$res = db_fetch_array (
			'select * from queue where message_id = 0'
		);

		if (count ($res) > 0) {
			$emails = array ();
			foreach ($res as $row) {
				$emails[] = $row->email;
			}
			if ($this->send_mail (
				$emails,
				'Thanks for subscribing!',
				file_get_contents ('html/welcome_email.php')
			)) {
				foreach ($res as $row) {
					db_execute ('delete from queue where id = %s', $row->id);
				}
			} else {
				echo 'Error: ' . $this->error . "\n";
			}
		}

		$message_id = db_shift ('select message_id from queue where message_id > 0 order by message_id asc limit 1');

		if ($message_id) {
			$res = db_fetch_array (
				'select * from queue where message_id = %s limit 50',
				$message_id
			);

			$message = db_single ('select * from messages where id = %s', $message_id);

			if (count ($res) > 0) {
				$emails = array ();
				foreach ($res as $row) {
					$emails[] = $row->email;
				}
				if ($this->send_mail (
					$emails,
					$message->subject,
					$message->body
				)) {
					foreach ($res as $row) {
						db_execute ('delete from queue where id = %s', $row->id);
					}
					db_execute ('update messages set recipients = recipients + %s where id = %s', count ($res), $message_id);
				} else {
					echo 'Error: ' . $this->error . "\n";
				}
			}
		}
	}

	/**
	 * The app folder name, in case it was renamed.
	 */
	function app_name () {
		return basename (getcwd ());
	}
}

?>