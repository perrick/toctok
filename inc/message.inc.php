<?php
/*
	toctok
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/projets/opentime.fr/applications/ofr/inc/bot.inc.php $
	$Revision: 830 $

	Copyright (C) No Parking 2013 - 2013
*/

class Toctok_Message {
	public $from = "";
	public $subject = "";
	public $body = "";
	
	function __construct($from, $subject, $body) {
		$this->from = $from;
		$this->subject = $subject;
		$this->body = $body;
	}
	
	function verifies($action) {
		$conditions = array("from", "subject", "body");
		$verifications = array();
		foreach ($conditions as $condition) {
			if (isset($action[$condition]) and !empty($action[$condition])) {
				$verifications[] = $condition;
			}
		}

		$result = true;
		foreach ($verifications as $verification) {
			if (!preg_match($action[$verification], $this->{$verification})) {
				$result = false;
				break;
			}
		}
		return $result;
	}
}
