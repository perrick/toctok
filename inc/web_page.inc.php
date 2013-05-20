<?php
/*
	toctok
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/projets/opentime.fr/applications/ofr/inc/bot.inc.php $
	$Revision: 830 $

	Copyright (C) No Parking 2013 - 2013
*/


class Toctok_Web_Page {
	public $body = "";
	
	function menu() {
		$elements = array(
			array(
				'name' => __("List of actions"),
				'url' => "index.php",
			),
			array(
				'name' => __("New action"),
				'url' => "index.php?action=1",
			),
		);

		$content = "<ul>";
		foreach ($elements as $element) {
			$content .= "<li><a href=\"".$element['url']."\">".$element['name']."</a></li>";
		}
		$content .= "</content>";

		return $content;
	}
	
	function body($body = null) {
		if ($body != null) {
			$this->body = $body;
		}
		return $this->body;
	}
	
	function response() {
		return '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>TocTok</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="medias/css/styles.css" />
</head>
<body>
	<div id="menu">'.$this->menu().'</div>
	<div id="body">'.$this->body().'</div>
	<div id="info">TocTok © Perrick Penet-Avez 2013</div>
</body>
</html>';
	}
}
