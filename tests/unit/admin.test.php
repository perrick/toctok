<?php

require dirname(__FILE__)."/../../../simpletest/autorun.php";
require dirname(__FILE__)."/../../inc/admin.php";

class TestsforAdmin extends UnitTestCase {
	function skip() {
		$this->skipUnless(is_writable(dirname(__FILE__)), "The test directory needs to be writable");
	}
	
	function testAdmin() {
		$admin = new Toctok_Admin();
		$this->assertEqual($admin->connection, array());
		$this->assertEqual($admin->records, array());
	}
	
	function testAdminLoadedWithConnection() {
		$admin = new Toctok_Admin();

		$this->assertFalse($admin->is_connection_valid("temp"));
		$connection = array(
			'host' => "clef",
			'port' => "==",
			'database' => "valeur",
		);
		$this->assertTrue($admin->is_connection_valid($connection));		
	}
	
	function testAdminLoadedWithOneFilter() {
		$admin = new Toctok_Admin();

		$this->assertFalse($admin->is_valid_record("temp"));
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
		$this->assertTrue($admin->is_valid_record($record));
		$this->assertTrue($admin->is_valid_record(json_encode($record)));

		$this->assertFalse($admin->load_record("temp"));
		$this->assertEqual(count($admin->records), 0);

		$this->assertTrue($admin->load_record($record));
		$this->assertEqual(count($admin->records), 1);

		$this->assertTrue($admin->load_record(json_encode($record)));
		$this->assertEqual(count($admin->records), 2);
	}
	
	function testAdminLoadedFromMultipleLines() {
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
		$content = json_encode($record);
		
		$admin = new Toctok_Admin();
		$this->assertTrue($admin->load_records(""));
		$this->assertEqual(count($admin->records), 0);
		$this->assertFalse($admin->load_records("temp"));
		$this->assertEqual(count($admin->records), 0);
		$this->assertTrue($admin->load_records($content));
		$this->assertEqual(count($admin->records), 1);
		$this->assertTrue($admin->load_records($content."\n".$content));
		$this->assertEqual(count($admin->records), 3);
	}
	
	function testAdminCanBeLoadedFromFile() {
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
		$content = json_encode($record);
		file_put_contents(dirname(__FILE__)."/temp.js", $content);

		$admin = new Toctok_Admin();
		$this->assertTrue($admin->load_records_from_file(dirname(__FILE__)."/temp.js"));
		$this->assertEqual(count($admin->records), 1);
		unlink(dirname(__FILE__)."/temp.js");
	}
	
	function testAdminCanBeLoadedWithEverythingFromFile() {
		$connection = array(
			'host' => "127.0.0.1",
			'port' => "1234",
			'database' => "toctok",
		);
		$content = json_encode($connection)."\n";
		
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
		$content .= json_encode($record);
		file_put_contents(dirname(__FILE__)."/temp.js", $content);

		$admin = new Toctok_Admin();
		$this->assertTrue($admin->load_from_file(dirname(__FILE__)."/temp.js"));
		$this->assertEqual($admin->connection, $connection);
		$this->assertEqual(count($admin->records), 1);
		unlink(dirname(__FILE__)."/temp.js");
	}

	function testForm() {
		$admin = new Toctok_Admin();
		$this->assertPattern("/<form/", $admin->form());
		$this->assertPattern("/connection\[host\]/", $admin->form());
		$this->assertPattern("/connection\[port\]/", $admin->form());
		$this->assertPattern("/connection\[database\]/", $admin->form());
		$this->assertPattern("/connection\[user\]/", $admin->form());
		$this->assertPattern("/connection\[password\]/", $admin->form());
		$this->assertPattern("/records\[0\]/", $admin->form());
		$this->assertPattern("/records\[0\]\[filter\]/", $admin->form());
		$this->assertPattern("/records\[0\]\[condition\]/", $admin->form());
		$this->assertPattern("/records\[0\]\[audio\]/", $admin->form());
		
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
		$admin->load_record($record);
		$this->assertPattern("/records\[1\]/", $admin->form());
		$this->assertPattern("/records\[1\]\[filter\]/", $admin->form());
		$this->assertPattern("/records\[1\]\[condition\]/", $admin->form());
		$this->assertPattern("/records\[1\]\[audio\]/", $admin->form());
	}
	
	function testWriteAndReadFromJSConfigFile() {
		$admin = new Toctok_Admin();
		$this->assertFalse($admin->read());
		$this->assertTrue($admin->write());

		$this->assertFalse($admin->read());
		$this->assertEqual(count($admin->connection), 0);
		$this->assertEqual(count($admin->records), 0);
		
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
		$admin->load_record($record);
		$connection = array(
			'host' => "127.0.0.1",
			'port' => "1234",
			'database' => "toctok",
		);
		$admin->load_connection($connection);
		$this->assertTrue($admin->write());

		$this->assertTrue($admin->read());
		$this->assertEqual(count($admin->connection), 3);
		$this->assertEqual(count($admin->records), 1);
		
		$this->assertTrue($admin->delete());
	}
	
	function testCreateMapFromRecord() {
		$admin = new Toctok_Admin();
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
		$admin->load_record($record);
		
		$maps = $admin->maps("123456");
		$this->assertEqual($maps[0], "function(doc) { if (doc.clef == 'valeur' && doc.time >= 123456) { emit(null, doc); } }");
	}
}
