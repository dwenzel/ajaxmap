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
 * Test case for class DWenzel\Ajaxmap\Domain\Model\LocationType.
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
use DWenzel\Ajaxmap\Domain\Model\LocationType;
use Nimut\TestingFramework\TestCase\UnitTestCase;

/**
 * Class LocationTypeTest
 *
 * @package DWenzel\Ajaxmap\Tests
 */
class LocationTypeTest extends UnitTestCase
{
    /**
     * @var LocationType
     */
    protected $fixture;

    public function setUp()
    {
        $this->fixture = new LocationType();
    }

    /**
     * @test
     */
    public function getTitleReturnsInitialValueForString()
    {
        $this->assertNull(
            $this->fixture->getTitle()
        );
    }

    /**
     * @test
     */
    public function setTitleForStringSetsTitle()
    {
        $this->fixture->setTitle('Conceived at T3CON10');

        $this->assertSame(
            'Conceived at T3CON10',
            $this->fixture->getTitle()
        );
    }

    /**
     * @test
     */
    public function getDescriptionReturnsInitialValueForString()
    {
        $this->assertNull(
            $this->fixture->getDescription()
        );
    }

    /**
     * @test
     */
    public function setDescriptionForStringSetsDescription()
    {
        $this->fixture->setDescription('Conceived at T3CON10');

        $this->assertSame(
            'Conceived at T3CON10',
            $this->fixture->getDescription()
        );
    }

    /**
     * @test
     */
    public function getIconReturnsInitialValueForString()
    {
        $this->assertNull(
            $this->fixture->getIcon()
        );
    }

    /**
     * @test
     */
    public function setIconForStringSetsIcon()
    {
        $this->fixture->setIcon('Conceived at T3CON10');

        $this->assertSame(
            'Conceived at T3CON10',
            $this->fixture->getIcon()
        );
    }

    /**
     * @test
     */
    public function toArrayReturnsInitialValueForArray()
    {
        $result = [
            'description' => null,
            'icon' => null,
            'iconActive' => null,
            'pid' => null,
            'title' => null,
            'uid' => null
        ];
        $this->assertSame(
            $this->fixture->toArray(),
            $result
        );
    }

}

