<?php

require dirname(__FILE__)."/../../../simpletest/autorun.php";
require dirname(__FILE__)."/../../inc/toctok.php";

class TestsforToctok extends UnitTestCase {
	function testLastRun() {
		$toctok = new Toctok();
		$toctok->couch->put_if_necessary($toctok->admin->connection['database']);
		
		$this->assertTrue($toctok->is_live());
		$this->assertEqual($toctok->last_run(), 0);
		$this->assertEqual($toctok->last_run(123456), 123456);
		$this->assertEqual($toctok->last_run(), 123456);
		$this->assertEqual($toctok->last_run(1234567), 1234567);
		$this->assertEqual($toctok->last_run(), 1234567);
		
		$toctok->couch->delete($toctok->admin->connection['database']);
	}
	
	function testMakesSomeNoise() {
		$toctok = new Toctok();
		$toctok->admin->records = array();
		
		$record = array(
			'filter' => array(
				'key' => "clef",
				'operand' => "==",
				'value' => "valeur",
			),
			'condition' => array(
				'key' => "row_count",
				'operand' => ">",
				'value' => 1,
			),
			'audio' => "path/to/mp3",
		);
		$toctok->admin->load_record($record);
	}
}
