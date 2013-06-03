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
		    		$subject = $overview->subject;
		    		$body = imap_body($mailbox, $number);
		    		foreach ($GLOBALS['configuration']['actions'] as $key => $action) {
		    			$answer = false;
		    			if (isset($action['subject']) and !empty($action['subject'])) {
		    				if (preg_match($action['subject'], $subject)) {
		    					$answer = true;
		    				}
		    			}
		    			if (isset($action['body']) and !empty($action['body'])) {
		    				if (preg_match($action['body'], $body)) {
		    					$answer = true;
		    				}
		    			}
			    		if ($answer) {
			    			exec("afplay --time 2 ".$action['sound']);
			    		}
		    		}
		    		imap_delete($mailbox, $number);
				}
				imap_expunge($mailbox);
			}
			imap_close($mailbox);
		}
	}

	function play_sample() {
		exec("afplay --time 2 ".dirname(__FILE__)."/../medias/audio/Ophelia-s-song.mp3");
	}
}
