<?php
/*
	toctok
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/projets/opentime.fr/applications/ofr/inc/bot.inc.php $
	$Revision: 830 $

	Copyright (C) No Parking 2013 - 2013
*/


function __($string, $replacements = null) {
	if (isset($GLOBALS['__'][$string])) {
		$string = $GLOBALS['__'][$string];
	} else {
		trigger_error("Translation '".$string."' is missing.", E_USER_WARNING);
	}
	switch (true) {
		case $replacements === null:
			return $string;
		case is_array($replacements):
			return vsprintf($string, $replacements);
	}
}

function play_file($filename) {
	$cmd = $GLOBALS['configuration']['player'];
	$cmd = vsprintf($cmd, array($filename));

	shell_exec($cmd);
}
