<?php

namespace Webfox\Ajaxmap\Tests;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Dirk Wenzel <wenzel@webfox01.de>
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
 * Test case for class Webfox\Ajaxmap\DomainObject\AbstractEntity.
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
class AbstractEntityTest extends \TYPO3\CMS\Extbase\Tests\Unit\BaseTestCase {
	/**
	 * @var Webfox\Ajaxmap\Domain\Model\Place
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new \Webfox\Ajaxmap\DomainObject\AbstractEntity();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function toJsonReturnsInitialValue() {
		$result = '{"pid":null,"uid":null}';

		$this->assertSame(
			$this->fixture->toJson(),
			$result
		);
	}

	/**
	 * @test
	 */
	public function toArrayReturnsInitialValue() {
		$result = array(
			"pid" => null,
			"uid" => null
		);

		$this->assertSame(
			$this->fixture->toArray(),
			$result
		);
	}

	/**
	 * @test
	 */
	public function toArrayDoesMappingForFieldNames() {
		$mapping = array(
			'Webfox\Ajaxmap\DomainObject\AbstractEntity' => array(
				"pid" => "key",
				"uid" => "page"
			)
		);
		$result = array(
			"key" => null,
			"page" => null
		);
		
		$this->assertSame(
			$this->fixture->toArray(10, $mapping),
			$result
		);
	}

	/**
	 * @test
	 */
	public function toArrayReturnsErrorMessageWhenMaximumTreedepthIsReached() {
		$this->assertSame(
			$this->fixture->toArray(0),
			'maximum tree depth reached!'
		);
	}
}
?>
