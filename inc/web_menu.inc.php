<?php
/*
	toctok
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/projets/opentime.fr/applications/ofr/inc/bot.inc.php $
	$Revision: 830 $

	Copyright (C) No Parking 2013 - 2013
*/

class Toctok_Web_Menu {
	function content() {
		$elements = array(
			array(
				'name' => __("List of actions"),
				'zone' => "body",
				'content' => "actions",
			),
			array(
				'name' => __("New action"),
				'zone' => "body",
				'content' => "action",
			),
		);

		$content = "<ul>";
		foreach ($elements as $element) {
			$content .= "<li><a href=\"#\" data-zone=\"".$element['zone']."\" data-content=\"".$element['content']."\">".$element['name']."</a></li>";
		}
		$content .= "</content>";

		return $content;
	}
}
