<?php

require dirname(__FILE__)."/../../../simpletest/autorun.php";
require dirname(__FILE__)."/../../inc/couch.php";

class TestsforCouch extends UnitTestCase {
	function __construct() {
		$this->couch = new Toctok_Couch(
				array(
						'host' => "127.0.0.1",
						'port' => 5984,
						'database' => "test",
				)
		);
		parent::__construct();
	}

	function tearDown() {
		$this->couch->delete();
	}

	function skip() {
		$this->skipUnless($this->couch->is_host_live(), "A running Couch server is necessary to run the tests");
	}

	function testCouchServerCanBeCheck() {
		$couch = new Toctok_Couch();
		$this->assertFalse($couch->is_host_live());

		$couch = new Toctok_Couch(
				array(
						'host' => "",
						'port' => 5984,
				)
		);
		$this->assertFalse($couch->is_host_live());

		$this->assertTrue($this->couch->is_host_live());
	}

	function testCouchServerCreatesDatabase() {
		$this->assertFalse($this->couch->is_live());
		$this->assertTrue($this->couch->put());
		$this->assertTrue($this->couch->is_live());
		$this->assertFalse($this->couch->put());
		$this->assertTrue($this->couch->is_live());
		$this->assertTrue($this->couch->delete());
		$this->assertFalse($this->couch->is_live());

		$this->assertTrue($this->couch->put_if_necessary());
		$this->assertTrue($this->couch->is_live());

		$this->assertTrue($this->couch->put_if_necessary());
		$this->assertTrue($this->couch->is_live());
	}

	function testCouchServerCreatesDocument() {
		$this->couch->put_if_necessary();
		$this->assertFalse($this->couch->put(null, array()));
		$this->assertFalse($this->couch->put(null, "string"));
		$this->assertTrue($this->couch->put("temp", array('key' => "value")));
		$this->assertTrue($this->couch->put(null, array('key' => "value")));
	}

	function testLastResponse() {
		$this->assertTrue($this->couch->put());
		$this->assertIsA($this->couch->last_response(), "stdClass");
		$response = $this->couch->last_response();
		$this->assertEqual($response->ok, true);

		$this->assertTrue($this->couch->delete());
		$this->assertIsA($this->couch->last_response(), "stdClass");
		$response = $this->couch->last_response();
		$this->assertEqual($response->ok, true);
	}

	function testCouchServerPost() {
		$this->couch->put();
		$this->couch->put("temp", array('key' => "value"));

		$map = "function(doc) { emit(null, doc); }";
		$this->assertTrue($this->couch->post("_temp_view", array('map' => $map)));
		$this->assertIsA($this->couch->last_response(), "stdClass");
		$response = $this->couch->last_response();
		$this->assertEqual($response->total_rows, 1);

		$map = "function(doc) { if ('key' == 'other-value') { emit(null, doc); } }";
		$this->assertTrue($this->couch->post("_temp_view", array('map' => $map)));
		$this->assertIsA($this->couch->last_response(), "stdClass");
		$response = $this->couch->last_response();
		$this->assertEqual($response->total_rows, 0);
	}

	function testCouchServerCanSwitchDatabase() {
		$this->couch->put();
		$this->assertTrue($this->couch->put(uniqid(), array('key' => "value")));
		$this->assertTrue($this->couch->put(uniqid(), array('key' => "value")));

		$this->couch->database("test2");
		$this->couch->put();
		$this->assertTrue($this->couch->put(uniqid(), array('key' => "value")));

		$map = "function(doc) { emit(null, doc); }";
		$this->couch->post("_temp_view", array('map' => $map));
		$response = $this->couch->last_response();
		$this->assertEqual($response->total_rows, 1);
		$this->couch->delete();

		$this->couch->database("test");
		$map = "function(doc) { emit(null, doc); }";
		$this->couch->post("_temp_view", array('map' => $map));
		$response = $this->couch->last_response();
		$this->assertEqual($response->total_rows, 2);
	}

	function testCouchServerCanGetValues() {
		$this->couch->put();

		$this->assertFalse($this->couch->get("last_run"));

		$this->assertTrue($this->couch->put("last_run", array('time' => "123")));
		$this->assertTrue($this->couch->get("last_run"));
		$last_run = $this->couch->last_response();
		$this->assertEqual($last_run->time, 123);

	}
}
