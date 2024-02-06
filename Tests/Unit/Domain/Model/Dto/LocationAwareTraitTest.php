<?php

namespace DWenzel\Ajaxmap\Tests;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2019 Dirk Wenzel
 *  All rights reserved
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the text file GPL.txt and important notices to the license
 * from the author is found in LICENSE.txt distributed with these scripts.
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use DWenzel\Ajaxmap\Domain\Model\Dto\LocationAwareTrait;
use Nimut\TestingFramework\TestCase\UnitTestCase;

/**
 * Test case for class \DWenzel\Ajaxmap\Domain\Model\Dto\LocationAwareTrait.
 */
class LocationAwareTraitTest extends UnitTestCase
{

    /**
     * @var LocationAwareTrait
     */
    protected $fixture;

    public function setUp()
    {
        $this->fixture = $this->getMockForTrait(LocationAwareTrait::class);
    }

    /**
     * @test
     */
    public function getLocationReturnsInitialValueForString()
    {
        $expected = '';
        $this->assertSame(
            $expected,
            $this->fixture->getLocation()
        );
    }

    /**
     * @test
     */
    public function setLocationForStringSetsLocation()
    {
        $this->fixture->setLocation('ping');
        $this->assertSame('ping', $this->fixture->getLocation());
    }

    /**
     * @test
     */
    public function getRadiusReturnsInitialValueForInteger()
    {
        $this->assertSame(
            0,
            $this->fixture->getRadius());
    }

    /**
     * @test
     */
    public function setRadiusForIntegerSetsRadius()
    {
        $this->fixture->setRadius(5000);
        $this->assertSame(5000, $this->fixture->getRadius());
    }

    /**
     * @test
     */
    public function getBoundsReturnsInitialValueForArray()
    {
        $this->assertSame(
            [],
            $this->fixture->getBounds());
    }

    /**
     * @test
     */
    public function setBoundsForArraySetsBounds()
    {
        $bounds = ['test' => 'value'];
        $this->fixture->setBounds($bounds);
        $this->assertSame($bounds, $this->fixture->getBounds());
    }
}
