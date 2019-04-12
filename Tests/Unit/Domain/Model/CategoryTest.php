<?php

namespace DWenzel\Ajaxmap\Tests;
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
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use DWenzel\Ajaxmap\Domain\Model\Category;
use TYPO3\CMS\Core\Tests\UnitTestCase;

/**
 * Test case for class DWenzel\Ajaxmap\Domain\Model\Category.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage Ajax Map
 *
 * @author Dirk Wenzel <dirk.wenzel@cps-it.de>
 * @coversDefaultClass DWenzel\Ajaxmap\Domain\Model\Category
 */
class CategoryTest extends UnitTestCase {
	/**
	 * @var \DWenzel\Ajaxmap\Domain\Model\Category
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new \DWenzel\Ajaxmap\Domain\Model\Category();
	}

	/**
	 * @test
	 * @covers ::getParent
	 */
	public function getParentReturnsInitiallyNull() {
		$this->assertNull(
			$this->fixture->getParent()
		);
	}

	/**
	 * @test
	 * @covers ::setParent
	 */
	public function setParentForObjectSetsParent() {
		$parentCategory = new \DWenzel\Ajaxmap\Domain\Model\Category();
		$this->fixture->setParent($parentCategory);

		$this->assertSame(
			$parentCategory,
			$this->fixture->getParent()
		);
	}

	/**
	 * @test
	 * @covers ::getParent
	 */
	public function getParentLoadsRealInstanceForLazyLoadingProxy() {
		$fixture = $this->getAccessibleMock(
			'DWenzel\\Ajaxmap\\Domain\\Model\\Category',
			array('dummy'), array(), '', false
		);
		$mockParent = $this->getAccessibleMock(
			'TYPO3\\CMS\\Extbase\\Persistence\\Generic\\LazyLoadingProxy',
			array('_loadRealInstance'), array(), '', false
		);
		$fixture->_set('parent', $mockParent);
		$mockParent->expects($this->once())->method('_loadRealInstance');
		$fixture->getParent();
	}

	/**
	 * @test
	 */
	public function toArrayReturnsInitialValue() {
		$result = array(
			'description' => '',
			'icon' => '',
			'parent' => null,
			'pid' => null,
			'title' => '',
			'uid' => null
		);
		$this->assertSame(
			$this->fixture->toArray(),
			$result
		);
	}

	/**
	 * @test
	 */
	public function toArrayReturnsArrayWithCorrectValues() {
		$parentCategory = new \DWenzel\Ajaxmap\Domain\Model\Category();
		$this->fixture->setParent($parentCategory);
		$this->fixture->setDescription('foo');
		$this->fixture->setIcon('bar');
		$this->fixture->setPid(1);
		$this->fixture->setTitle('foobar');
		$this->fixture->_setProperty('uid', 2);
		$result = array(
						'description' => 'foo',
						'icon' => 'bar',
						'parent' => array(
							'description' => null,
							'icon' => null,
							'parent' => null,
							'pid' => null,
							'title' => null,
							'uid' => null
						),
						'pid' => 1,
						'title' => 'foobar',
						'uid' => 2

		);
		$this->assertEquals(
			$result,
			$this->fixture->toArray()
		);
	}
}

