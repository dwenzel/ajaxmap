<?php
namespace Webfox\Ajaxmap\Tests;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2015 Dirk Wenzel <dirk.wenzl@cps-it.de>
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
use TYPO3\CMS\Core\Tests\UnitTestCase;

/**
 * Test case for class Webfox\Ajaxmap\Utility\TreeUtility.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage Ajax Map
 *
 * @author Dirk Wenzel <dirk.wenzel@cps-it.de>
 * @coversDefaultClass Webfox\Ajaxmap\Utility\TreeUtility
 */
class TreeUtilityTest extends UnitTestCase {
	/**
	 * @var \Webfox\Ajaxmap\Utility\TreeUtility
	 */
	protected $subject;

	public function setUp() {
		$this->subject = $this->getAccessibleMock(
				'Webfox\\Ajaxmap\\Utility\\TreeUtility',
				array('dummy'), array(), '', FALSE
		);
	}

	public function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 * @covers ::convertObjectLeafToArray
	 */
	public function convertObjectLeafToArrayInitiallyReturnsEmptyArray() {
		$mockObjectLeaf = array(
				'foo' => 'bar'
				);

		$this->assertSame(
				array(),
				$this->subject->_call('convertObjectLeafToArray', array($mockObjectLeaf))
		);
	}

	/**
	 * @test
	 * @covers ::convertObjectLeafToArray
	 */
	public function converObjectLeafToArrayConvertsReturnsEmptyArrayIfItemIsNotSerializable() {
		$mockObjectLeaf = array(
				'item' => 'bar'
				);

		$this->assertSame(
				array(),
				$this->subject->_call('convertObjectLeafToArray', array($mockObjectLeaf))
		);
	}

	/**
	 * @test
	 * @covers ::convertObjectLeafToArray
	 */
	public function converObjectLeafToArrayConvertsSerializableLeafItems() {
		$mockSerializable = $this->getMock(
				'Webfox\\Ajaxmap\\DomainObject\\SerializableInterface',
				array('toArray', 'toJson'), array(), '', FALSE);
		$mockObjectLeaf = array(
				'item' => $mockSerializable
				);
		$expectedArray = array('foo' => 'bar');
		$mockSerializable->expects($this->once())
			->method('toArray')
			->with(10, NULL)
			->will($this->returnValue($expectedArray));
		$this->assertSame(
				 $expectedArray,
				$this->subject->_call('convertObjectLeafToArray', array($mockObjectLeaf))
		);
	}
}

