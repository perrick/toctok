<?php

require dirname(__FILE__)."/../../../simpletest/autorun.php";
require dirname(__FILE__)."/../../inc/require.inc.php";

class Tests_Toctok_Web_Actions extends UnitTestCase {
	function test_catalogue() {
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
		$action->save();

		$actions = new Toctok_Web_Actions($configuration);
		$this->assertPattern("/action-sauvegardé/", $actions->catalogue());
		
		unset($configuration);
	}
}
