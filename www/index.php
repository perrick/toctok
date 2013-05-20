<?php
/*
	toctok
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/projets/opentime.fr/applications/ofr/inc/bot.inc.php $
	$Revision: 830 $

	Copyright (C) No Parking 2013 - 2013
*/

require __DIR__."/../inc/require.inc.php";

if (isset($_POST)) {
	if (isset($_POST['save']) and isset($_POST['action']) and is_array($_POST['action'])) {
		$action = new Toctok_Action($_POST['action']['name']);
		$action->fill($_POST['action']);
		$action->save();
	}
}

$actions = new Toctok_Web_Actions();
$body = $actions->catalogue();
			
switch (true) {
	case isset($_GET['action']):
		$action = new Toctok_Web_Action($_GET['action']);
		$action->load_configuration();
		$body = $action->form();
		break;
}

$page = new Toctok_Web_Page();
$page->body($body);

echo $page->response();
