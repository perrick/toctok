<?php
/*
	toctok
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/projets/opentime.fr/applications/ofr/inc/bot.inc.php $
	$Revision: 830 $

	Copyright (C) No Parking 2013 - 2013
*/

require __DIR__."/../inc/require.inc.php";
require __DIR__."/../inc/web_menu.inc.php";

if (isset($_GET['content'])) {
	switch ($_GET['content']) {
		case "menu":
			$menu = new Toctok_Web_Menu();
			return $menu->content();
	} 
}