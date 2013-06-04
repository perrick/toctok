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

class Tests_Toctok_Message extends UnitTestCase {
	function test_verifies() {
		$message = new Toctok_Message("from@toctok.com", "subject", "body");
		
		$action = array(
			'from' => "/from@toctok\.com/",
			'subject' => "/SUCCESS/",
			'body' => "",
			'sound' => "/Users/perrick/Sites/toctok/medias/mp3/pic-vert.mp3", 
		);
		$this->assertFalse($message->verifies($action));
		
		$action = array(
			'from' => "/from@toctok\.com/",
			'subject' => "/subject/",
			'body' => "",
			'sound' => "/Users/perrick/Sites/toctok/medias/mp3/pic-vert.mp3",
		);
		$this->assertTrue($message->verifies($action));
		
		$action = array(
			'from' => "",
			'subject' => "",
			'body' => "",
			'sound' => "/Users/perrick/Sites/toctok/medias/mp3/pic-vert.mp3",
		);
		$this->assertTrue($message->verifies($action));

		$action = array(
			'sound' => "/Users/perrick/Sites/toctok/medias/mp3/pic-vert.mp3",
		);
		$this->assertTrue($message->verifies($action));
	}
}
