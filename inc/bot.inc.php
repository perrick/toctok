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
	
	function play_sample() {
		exec("afplay --time 2 ".dirname(__FILE__)."/../medias/audio/Ophelia-s-song.mp3");
	}
}
