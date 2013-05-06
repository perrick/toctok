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

class Tests_Toctok_Web_Action extends UnitTestCase {
	function test_form() {
		$action = new Toctok_Web_Action("test");
		$this->assertPattern("/action\[name\]/", $action->form());
		$this->assertPattern("/action\[source\]\[type\]/", $action->form());
		$this->assertPattern("/action\[source\]\[name\]/", $action->form());
		$this->assertPattern("/action\[source\]\[trigger\]/", $action->form());
		$this->assertPattern("/action\[effect\]\[type\]/", $action->form());
		$this->assertPattern("/action\[effect\]\[name\]/", $action->form());
		$this->assertPattern("/name=\"save\"/", $action->form());
	}
}
