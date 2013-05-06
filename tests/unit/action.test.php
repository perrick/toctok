<?php
/*
	toctok
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/projets/opentime.fr/applications/ofr/inc/bot.inc.php $
	$Revision: 830 $

	Copyright (C) No Parking 2013 - 2013
*/

require dirname(__FILE__)."/../../../simpletest/autorun.php";
require dirname(__FILE__)."/../../inc/require.inc.php";

class Tests_Toctok_Action extends UnitTestCase {
	function test_save() {
		$configuration = __DIR__."/../var/toctok.test.json";
		
		$action = new Toctok_Action("action-sauvegardée");
		$action->configuration($configuration);
		$action->source = array(
			'type' => "file",
			'name' => __DIR__."/action.test.php",
			'trigger' => "last_modification",
		);
		$action->effect = array(
			'type' => "mp3",
			'name' => __DIR__."/../../medias/mp3/Ophelia-s-song.mp3",
		);
		$this->assertTrue($action->save());
		
		$this->assertTrue(file_exists($configuration));
		
		unset($configuration);
	}
}
