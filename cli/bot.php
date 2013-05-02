<?php
/*
	toctok
	$Author: frank $
	$URL: svn://svn.noparking.net/var/repos/projets/norska/cli/bot.php $
	$Revision: 29 $

	Copyright (C) No Parking 2013 - 2013
*/

require dirname(__FILE__) . "/../inc/require.inc.php";

if (isset($argv)) {
	$arguments = $argv;
	array_shift($arguments);
} else {
	$arguments = $_GET;
}

$bot = new Toctok_Bot();

$method = array_shift($arguments);
if (preg_match("/^--/", $method)) {
	$method = str_replace("-", "", $method);
	if (method_exists($bot, $method)) {
		$return = $bot->$method($arguments);
		if ($return === true or $return === false) {
			return $return;
		} else {
			echo $return;
		}
	}
	else {
		echo $bot->help();
	}
} else {
	echo $bot->help();
}
