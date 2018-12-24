<?php
declare(strict_types=1);

use ElCoop\Valuestore\Valuestore;
use PHPUnit\Framework\TestCase;


class ValuestoreTest extends TestCase {

	protected $file;

	protected function setUp() {
		$this->file = dirname(__FILE__) . "\\test.json";
		file_put_contents($this->file, json_encode([
			'one' => 'test',
			'two' => 'test2',
			'two_two' => 'test2'
		]));
	}

	protected function tearDown() {
		unlink($this->file);
	}

	public function test_file_gets_created_if_when_file_doesnt_exists() {
		$file = dirname(__FILE__) . "\\nofile.json";
		$valuestore = new Valuestore($file);
		$this->assertFileExists($file);
		$this->assertInstanceOf(Valuestore::class,$valuestore);
		unlink($file);
	}

	public function test_get_exception_when_file_not_json() {
		$file = dirname(__FILE__) . "\\test.txt";
		$this->expectExceptionMessage('File is not json');
		$valuestore = new Valuestore($file);

	}

	public function test_valuestore_created_when_file_is_json() {

		$valuestore = new Valuestore($this->file);
		$this->assertInstanceOf(Valuestore::class, $valuestore);
	}

	public function test_all_gets_all_values() {
		$valuestore = new Valuestore($this->file);
		$this->assertEquals([
			'one' => 'test',
			'two' => 'test2',
			'two_two' => 'test2'
		], $valuestore->all());
	}

	public function test_put_puts_new_value() {
		$valuestore = new Valuestore($this->file);
		$valuestore->put('test', true);
		$this->assertContains(['test' => true], $valuestore->all());
	}

	public function test_get_exception_when_put_name_not_string() {
		$valuestore = new Valuestore($this->file);
		$this->expectExceptionMessage('Name has to be string');
		$valuestore->put(5, true);
	}

	public function test_get_null_when_get_name_doesnt_exist_and_no_default(){
		$valuestore = new Valuestore($this->file);
		$get = $valuestore->get('test');
		$this->assertEquals(null,$get);
	}

	public function test_get_default_when_get_name_doesnt_exist_and_given_default(){
		$valuestore = new Valuestore($this->file);
		$get = $valuestore->get('test','value');
		$this->assertEquals('value',$get);
	}

	public function test_get_gets_value_with_correct_input() {
		$valuestore = new Valuestore($this->file);
		$value = $valuestore->get('one');
		$this->assertEquals('test', $value);
	}

	public function test_get_allStartingWith_returns_all_values_where_key_starts_with_input() {
		$valuestore = new Valuestore($this->file);
		$values = $valuestore->allStartingWith('two');
		$this->assertEquals([
			'two' => 'test2',
			'two_two' => 'test2'
		], $values);
	}

	public function test_get_empty_array_when_none_starting_with_given_input() {
		$valuestore = new Valuestore($this->file);
		$values = $valuestore->allStartingWith('test');
		$this->assertEquals([], $values);
	}
}
