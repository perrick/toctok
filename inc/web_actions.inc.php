<?php
/*
	toctok
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/projets/opentime.fr/applications/ofr/inc/bot.inc.php $
	$Revision: 830 $

	Copyright (C) No Parking 2013 - 2013
*/


class Toctok_Web_Actions extends Toctok_Actions {
	function __construct($filepath = null, $instance = null) {
		if ($instance == null) {
			$this->instance = "Toctok_Web_Action";
		} else {
			$this->instance = $instance;
		}
		parent::__construct($filepath, $this->instance);
	}

	function catalogue() {
		$elements = array();
		foreach ($this as $action) {
			$elements[] = $action->link();
		}

		if (count($elements) > 0) {
			return '<ul><li>'.join("</li><li>", $elements).'</li></ul>';
		} else {
			return "";
		}
	}
}
