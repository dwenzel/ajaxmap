<?php

namespace Webfox\Ajaxmap\Tests;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Dirk Wenzel <wenzel@webfox01.de>
 *  			
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
/**
 * Test case for class Webfox\Ajaxmap\Utility\MappingUtility.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage Ajax Map
 *
 * @author Dirk Wenzel <wenzel@webfox01.de>
 */
class MappingUtilityTest extends \TYPO3\CMS\Extbase\Tests\Unit\BaseTestCase {
	
	/**
	 * @var Webfox\Ajaxmap\Utility\MappingUtility
	 */
	protected $fixture;

	public function setUp() {	
		$this->fixture = new \Webfox\Ajaxmap\Utility\MappingUtility();
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

