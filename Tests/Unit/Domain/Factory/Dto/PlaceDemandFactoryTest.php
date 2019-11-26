<?php

namespace DWenzel\Ajaxmap\Tests\Unit\Domain\Factory\Dto;

use DWenzel\Ajaxmap\Domain\Factory\Dto\PlaceDemandFactory;
use DWenzel\Ajaxmap\Domain\Model\Dto\DemandInterface;
use DWenzel\Ajaxmap\Domain\Model\Dto\PlaceDemand;
use Nimut\TestingFramework\TestCase\UnitTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use DWenzel\Ajaxmap\Configuration\SettingsInterface as SI;

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

/**
 * Class PlaceDemandFactoryTest
 */
class PlaceDemandFactoryTest extends UnitTestCase
{
    /**
     * @var PlaceDemandFactory|MockObject
     */
    protected $subject;

    /**
     * @var ObjectManager|MockObject
     */
    protected $objectManager;

    public function setUp()
    {
        $this->objectManager = $this->getMockBuilder(ObjectManager::class)
            ->setMethods(['get'])->getMock();
        $this->subject = new PlaceDemandFactory();
        $this->subject->injectObjectManager($this->objectManager);

        $placeDemand = new PlaceDemand();

        $this->objectManager->expects($this->any())
            ->method('get')
            ->willReturn($placeDemand);
    }

    public function testFromSettingsReturnsDemandObject()
    {
        $settings = [];

        $this->assertInstanceOf(
            DemandInterface::class,
            $this->subject->fromSettings($settings)
        );
    }

    /**
     * @return array
     */
    public function settablePropertiesDataProvider()
    {
        /** propertyName, $settingsValue, $expectedValue */
        return [
            [SI::LOCATION_TYPES, '1,2', '1,2'],
            [SI::CONSTRAINTS_CONJUNCTION, 'and', 'AND'],
            [SI::PLACE_GROUPS, '5,6', '5,6'],
            [SI::MAP, '50', 50],
            [SI::ORDER, 'foo|bar,baz|asc', 'foo|bar,baz|asc']
        ];
    }

    /**
     * @dataProvider settablePropertiesDataProvider
     * @param string $propertyName
     * @param string|int $settingsValue
     * @param mixed $expectedValue
     */
    public function testFromSettingsSetsSettableProperties($propertyName, $settingsValue, $expectedValue)
    {
        $settings = [
            $propertyName => $settingsValue
        ];

        $demand = $this->subject->fromSettings($settings);
        $accessor = 'get' . ucfirst($propertyName);

        $this->assertSame(
            $expectedValue,
            $demand->{$accessor}()
        );
    }

}