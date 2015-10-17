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
	public function convertObjectLeafToArrayConvertsReturnsEmptyArrayIfItemIsNotSerializable() {
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
	public function convertObjectLeafToArrayConvertsSerializableLeafItems() {
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
				$this->subject->_call('convertObjectLeafToArray', $mockObjectLeaf)
		);
	}

	/**
	 * @test
	 * @covers ::convertObjectLeafToArray
	 */
	public function convertObjectLeafToArrayRemovesKeys() {
		$mockSerializable = $this->getMock(
				'Webfox\\Ajaxmap\\DomainObject\\SerializableInterface',
				array('toArray', 'toJson'), array(), '', FALSE);
		$mockObjectLeaf = array(
				'item' => $mockSerializable
				);
		$convertedArray = array(
				'foo' => 'bar',
				'keyToRemove' => 'baz'
		);
		$expectedArray = array(
				'foo' => 'bar'
				);
		$mockSerializable->expects($this->once())
			->method('toArray')
			->with(10, NULL)
			->will($this->returnValue($convertedArray));
		$this->assertSame(
				 $expectedArray,
				$this->subject->_call('convertObjectLeafToArray', $mockObjectLeaf, 'keyToRemove')
		);
	}

	/**
	 * @test
	 * @covers ::convertObjectBranchToArray
	 */
	public function convertObjectBranchToArrayReturnsInitiallyFalse() {
		$mockObjectLeaf = array(
				'foo' => 'bar'
		);
		$this->assertFalse(
				$this->subject->_call('convertObjectBranchToArray', $mockObjectLeaf)
		);
	}

	/**
	 * @test
	 * @covers ::convertObjectBranchToArray
	 */
	public function convertObjectBranchToArrayConvertsBranch() {
		$subject = $this->getAccessibleMock(
				'Webfox\\Ajaxmap\\Utility\\TreeUtility',
				array('convertObjectLeafToArray'), array(), '', FALSE
		);
		$mockSerializable = $this->getMock(
				'Webfox\\Ajaxmap\\DomainObject\\SerializableInterface',
				array('toArray', 'toJson'), array(), '', FALSE);
		$mockObjectLeaf = array(
				'item' => $mockSerializable
		);
		$keyToRemove = 'foo,bar';
		$mapping = array('foo' => 'bar');

		$subject->expects($this->once())
			->method('convertObjectLeafToArray')
			->with($mockObjectLeaf, $keysToRemove, $mapping)
			->will($this->returnValue($result));

		$subject->_call('convertObjectBranchToArray', $mockObjectLeaf, $keysToRemove, $mapping);
	}

	/**
	 * @test
	 * @covers ::convertObjectBranchToArray
	 */
	public function convertObjectBranchToArrayConvertsChildren() {
		$subject = $this->getAccessibleMock(
				'Webfox\\Ajaxmap\\Utility\\TreeUtility',
				array('convertObjectLeafToArray'), array(), '', FALSE
		);
		$mockSerializable = $this->getMock(
				'Webfox\\Ajaxmap\\DomainObject\\SerializableInterface',
				array('toArray', 'toJson'), array(), '', FALSE);
		$child = 'foo';

		$mockObjectLeaf = array(
				'item' => $mockSerializable,
				'children' => array($child)
		);
		$keyToRemove = 'foo,bar';
		$mapping = array('foo' => 'bar');

		$subject->expects($this->exactly(2))
			->method('convertObjectLeafToArray')
			->withConsecutive(
					array($mockObjectLeaf, $keysToRemove, $mapping),
					array($child, $keysToRemove, $mapping)
			);

		$subject->_call('convertObjectBranchToArray', $mockObjectLeaf, $keysToRemove, $mapping);
	}

	/**
	 * @test
	 * @covers ::convertObjectTreeToArray
	 */
	public function convertObjectTreeToArrayReturnsInitiallyEmptyArray() {
		$objectTree = array(
			'foo'
			);
		$this->assertEquals(
				array(),
				$this->subject->convertObjectTreeToArray($objectTree)
		);
	}

	/**
	 * @test
	 * @covers ::convertObjectTreeToArray
	 */
	public function convertObjectTreeToArrayConvertsBranch() {
		$subject = $this->getAccessibleMock(
				'Webfox\\Ajaxmap\\Utility\\TreeUtility',
				array('convertObjectBranchToArray'), array(), '', FALSE
		);
		$branch = 'foo';
		$objectTree = array(
			$branch
			);
		$convertedBranch = 'bar';
		$mapping = array('fooBar');
		$keysToRemove = 'baz';

		$subject->expects($this->once())
			->method('convertObjectBranchToArray')
			->with($branch, $keysToRemove, $mapping)
			->will($this->returnValue($convertedBranch));

		$this->assertEquals(
				array($convertedBranch),
				$subject->convertObjectTreeToArray($objectTree, $keysToRemove, $mapping)
		);
	}

	/**
	 * @test
	 * @covers ::buildObjectTree
	 */
	public function buildObjectTreeReturnsInitiallyEmptyArray() {
		$queryResult = $this->getMock(
				'TYPO3\\CMS\\Extbase\\Persistence\\Generic\\QueryResult',
				array(), array(), '', FALSE);

		$queryResult->expects($this->once())
			->method('toArray')
			->will($this->returnValue(array()));
		$this->assertEquals(
				array(),
				$this->subject->buildObjectTree($queryResult)
		);
	}

	/**
	 * @test
	 * @covers ::buildObjectTree
	 */
	public function buildObjectTreeFlattensObjects() {
		$queryResult = $this->getMock(
				'TYPO3\\CMS\\Extbase\\Persistence\\Generic\\QueryResult',
				array(), array(), '', FALSE);
		$mockObject = $this->getMock(
				'Webfox\\Ajaxmap\\Domain\\Model\\TreeItemInterface',
				array(), array(), '', FALSE);
		$uid = 6;
		$expectedTree = array(
			$uid => array(
				'item' => $mockObject,
				'parent' => NULL
			)
		);

		$queryResult->expects($this->once())
			->method('toArray')
			->will($this->returnValue(array($mockObject)));
		$mockObject->expects($this->once())
			->method('getUid')
			->will($this->returnValue($uid));
		$this->assertEquals(
				$expectedTree,
				$this->subject->buildObjectTree($queryResult)
		);
	}

	/**
	 * @test
	 * @covers ::buildObjectTree
	 */
	public function buildObjectTreeSetsObjectsWithoutParentToParent() {
		$queryResult = $this->getMock(
				'TYPO3\\CMS\\Extbase\\Persistence\\Generic\\QueryResult',
				array(), array(), '', FALSE);
		$mockObject = $this->getMock(
				'Webfox\\Ajaxmap\\Domain\\Model\\TreeItemInterface',
				array(), array(), '', FALSE);
		/*$mockParent =  $this->getMock(
				'Webfox\\Ajaxmap\\Domain\\Model\\TreeItemInterface',
				array('getParent', 'getUid'), array(), '', FALSE);*/
		$mockParent = clone($mockObject);
		$uid = 6;
		$parentId = 99;
		$expectedTree = array(
			$parentId => array(
				'children' => array(
					$uid => array(
						'item' => $mockObject,
						'parent' => $parentId
					)
				),
				'item' => $mockParent,
				'parent' => NULL
			)
		);

		$queryResult->expects($this->once())
			->method('toArray')
			->will($this->returnValue(array($mockObject, $mockParent)));
		$mockObject->expects($this->once())
			->method('getUid')
			->will($this->returnValue($uid));
		$mockObject->expects($this->exactly(2))
			->method('getParent')
			->will($this->returnValue($mockParent));
		$mockParent->expects($this->exactly(2))
			->method('getUid')
			->will($this->returnValue($parentId));

		$this->assertEquals(
				$expectedTree,
				$this->subject->buildObjectTree($queryResult)
		);
	}
}

