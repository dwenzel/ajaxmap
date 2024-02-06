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
/**
 * Test case for class DWenzel\Ajaxmap\Domain\Model\Region.
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
use DWenzel\Ajaxmap\Domain\Model\Region;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class RegionTest extends UnitTestCase {
	/**
  * @var Region
  */
 protected $fixture;

	public function setUp() {
		$this->fixture = new Region();
	}

	/**
	 * @test
	 */
	public function setTitleForStringSetsTitle() { 
		$this->fixture->setTitle('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getTitle()
		);
	}
	
	/**
	 * @test
	 */
	public function setFileForStringSetsFile() { 
		$this->fixture->setFile('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getFile()
		);
	}
	
	/**
	 * @test
	 */
	public function getClickableReturnsInitialValueForBoolean() { 
		$this->assertSame(
			false,
			$this->fixture->getClickable()
		);
	}

	/**
	 * @test
	 */
	public function setClickableForBooleanSetsClickable() { 
		$this->fixture->setClickable(true);

		$this->assertSame(
			true,
			$this->fixture->getClickable()
		);
	}

	/**
	* @test
	*/
	public function isClickableForBooleanReturnsInitialFalse() {
		$this->assertFalse(
				$this->fixture->isClickable()
		);
	}

	/**
	 * @test
	 */
	public function isClickableForBooleanReturnsIsClickable() {
		$this->fixture->setClickable(true);
		$this->assertTrue(
				$this->fixture->isClickable()
		);
	}

	/**
	 * @test
	 */
	public function getSuppressInfoWindowsReturnsInitialValueForBoolean() { 
		$this->assertSame(
			false,
			$this->fixture->getSuppressInfoWindows()
		);
	}

	/**
	 * @test
	 */
	public function setSuppressInfoWindowsForBooleanSetsSuppressInfoWindows() { 
		$this->fixture->setSuppressInfoWindows(true);

		$this->assertSame(
			true,
			$this->fixture->getSuppressInfoWindows()
		);
	}
	
	/**
	* @test
	*/
	public function isSuppressInfoWindowsForBooleanReturnsInitialFalse() {
		$this->assertFalse(
				$this->fixture->isSuppressInfoWindows()
		);
	}

	/**
	 * @test
	 */
	public function isSuppressInfoWindowsForBooleanReturnsIsSuppressInfoWindows() {
		$this->fixture->setSuppressInfoWindows(true);
		$this->assertTrue(
				$this->fixture->isSuppressInfoWindows()
		);
	}

	/**
	 * @test
	 */
	public function getPreserveViewportReturnsInitialValueForBoolean() { 
		$this->assertSame(
			false,
			$this->fixture->getPreserveViewport()
		);
	}

	/**
	 * @test
	 */
	public function setPreserveViewportForBooleanSetsPreserveViewport() { 
		$this->fixture->setPreserveViewport(true);

		$this->assertSame(
			true,
			$this->fixture->getPreserveViewport()
		);
	}
	
	/**
	* @test
	*/
	public function isPreserveViewportForBooleanReturnsInitialFalse() {
		$this->assertFalse(
				$this->fixture->isPreserveViewport()
		);
	}

	/**
	 * @test
	 */
	public function isPreserveViewportForBooleanReturnsIsPreserveViewport() {
		$this->fixture->setPreserveViewport(true);
		$this->assertTrue(
				$this->fixture->isPreserveViewport()
		);
	}

}

