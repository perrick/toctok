<?php
/*
	toctok
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/projets/opentime.fr/applications/ofr/inc/bot.inc.php $
	$Revision: 830 $

	Copyright (C) No Parking 2013 - 2013
*/


class Toctok_Bot {
	function __construct() {
	}

	function help() {
		$help = __("Methods available with Toctok_Bot:") . "\n";
		$ReflectionClass = new ReflectionClass("Toctok_Bot");
		foreach ($ReflectionClass->getMethods() as $method) {
			if (!in_array($method->getName(), array ("help", "__construct"))) {
				$help .= "--" . $method->getName() . "\n";
			}
		}

		return $help;
	}

	function answer() {
		$mailbox = imap_open("{".$GLOBALS['configuration']['imap_mailbox']."}INBOX", $GLOBALS['configuration']['imap_user'], $GLOBALS['configuration']['imap_password']);
		if ($mailbox) {
			$check = imap_check($mailbox);
			if ($check->Nmsgs > 0) {
				$result = imap_fetch_overview($mailbox, "1:{$check->Nmsgs}", 0);
				$number = 0;
				foreach ($result as $overview) {
					$number++;
					$message = new Toctok_Message($overview->from, $overview->subject, imap_body($mailbox, $number));
					$sound = false;
		    		foreach ($GLOBALS['configuration']['actions'] as $key => $action) {
		    			if ($message->verifies($action)) {
		    				$sound = $action['sound'];
		    				break;
		    			}
		    		}
		    		imap_delete($mailbox, $number);
					if ((bool)$sound) {
		    			exec("afplay --time 5 '".$sound."'");
		    			break;
		    		}
				}
				imap_expunge($mailbox);
			}
			imap_close($mailbox);
		}
	}

	function play_sample() {
		exec("afplay --time 5 ".dirname(__FILE__)."/../medias/mp3/pic-vert.mp3");
	}
}
