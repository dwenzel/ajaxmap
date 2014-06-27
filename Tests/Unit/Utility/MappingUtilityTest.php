<?php

class Tx_Ajaxmap_Utility_MappingUtilityTest extends Tx_Extbase_Tests_Unit_BaseTestCase {
	
	/**
	 * @var Tx_Ajaxmap_Utility_MappingUtility
	 */
	protected $fixture;

	public function setUp() {	
		$this->fixture = new Tx_Ajaxmap_Utility_MappingUtility();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function mapReturnsSourceForArrayWhenSettingsEmpty() {
		$emptySettings = array();
		
		$source = array(
				'model' => array(
					'fooField' => 1,
					'barField' => 'ping'
				),
		);
		$this->assertSame(
				$this->fixture->map($source, $emptySettings),
				$source
		);
	}

	/**
	 * @test
	 */
	public function mapReturnsSourceForArrayWhenNoMatchingSettingsFound() {
		$nonMatchingSettings = array(
			'foo' => array (
				'model' => array(
						'fooField' => 'bar',
						'barField' => 13
				),
			),
		);
		
		$source = array(
				'model' => array(
					'fooField' => 1,
					'barField' => 'ping'
				),
		);
		
		$this->assertSame(
				$this->fixture->map($source, $nonMatchingSettings),
				$source
		);
	}

	/**
	 * @test
	 */
	public function mapReturnsMappedArrayForArray() {
		$settings = array(
			'existingFieldName' => 'newFieldNameFoo',
			'notExistingFieldName' => 'newFieldNameBar'
		);
		$source = array(
			'existingFieldName' => 'valueFoo',
			'fieldFooBar' => 'valueFooBar'
		);
		$result = array(
			'newFieldNameFoo' => 'valueFoo',
			'fieldFooBar' => 'valueFooBar'
		);
		
		$this->assertSame(
			$this->fixture->map($source, $settings),
			$result
		);
	}
	
}
?>

