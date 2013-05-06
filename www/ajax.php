<?php
/*
 toctok
$Author: perrick $
$URL: svn://svn.noparking.net/var/repos/projets/opentime.fr/applications/ofr/inc/bot.inc.php $
$Revision: 830 $

Copyright (C) No Parking 2013 - 2013
*/

require __DIR__."/../inc/require.inc.php";

$html = "";
if (isset($_GET['content'])) {
	switch ($_GET['content']) {
		case "actions":
			$actions = new Toctok_Web_Actions();
			$html = $actions->catalogue();
			break;
		case "action":
			$action = new Toctok_Web_Action(isset($_GET['name']) ? $_GET['name'] : "");
			$html = $action->form();
			break;
		case "menu":
			$menu = new Toctok_Web_Menu();
			$html = $menu->content();
			break;
	}
}

echo $html;
die();
