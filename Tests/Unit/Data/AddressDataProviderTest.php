<?php

namespace DWenzel\Ajaxmap\Tests\Unit\Data;

use DWenzel\Ajaxmap\Controller\MissingRequestArgumentException;
use DWenzel\Ajaxmap\Data\AddressDataProvider;
use DWenzel\Ajaxmap\Domain\Model\Address;
use DWenzel\Ajaxmap\Domain\Model\Place;
use DWenzel\Ajaxmap\Domain\Repository\PlaceRepository;
use Nimut\TestingFramework\TestCase\UnitTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
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
 * Class AddressDataProviderTest
 */
class AddressDataProviderTest extends UnitTestCase
{

    /**
     * @var AddressDataProvider|MockObject
     */
    protected $subject;

    /**
     * @var ObjectManagerInterface|MockObject
     */
    protected $objectManager;

    /**
     * @var PlaceRepository|MockObject
     */
    protected $placeRepository;

    public function setUp()
    {
        parent::setUp();
        $this->objectManager = $this->getMockBuilder(ObjectManagerInterface::class)
            ->setMethods(['get'])->getMockForAbstractClass();
        $this->placeRepository = $this->getMockBuilder(PlaceRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['findByUid'])->getMock();
        $this->objectManager->method('get')->willReturn($this->placeRepository);
        $this->subject = new AddressDataProvider($this->objectManager);
    }

    public function testGetThrowsMissingRequestArgumentException() {
        $queryParameter = ['foo'];
        $this->expectException(MissingRequestArgumentException::class);
        $this->subject->get($queryParameter);
    }

    public function testGetReturnsArray() {
        $queryParameter = [
            SI::API_PARAMETER_PLACE_ID => '15'
        ];
        $this->assertTrue(
            is_array($this->subject->get($queryParameter))
        );
    }

    public function testGetsArrayRepresentationOfAddressOfPlace() {
        $placeIdParameter = '15';
        $queryParameter = [
            SI::API_PARAMETER_PLACE_ID => $placeIdParameter
        ];
        $arrayRepresentation = ['foo' => 'bar'];
        $place = $this->getMockBuilder(Place::class)
            ->setMethods(['getAddress'])->getMock();
        $address = $this->getMockBuilder(Address::class)
            ->setMethods(['toArray'])
            ->getMock();

        $this->placeRepository->expects($this->once())
            ->method('findByUid')
            ->with((int)$placeIdParameter)
            ->willReturn($place);
        $place->expects($this->once())->method('getAddress')
            ->willReturn($address);
        $address->expects($this->once())->method('toArray')
            ->willReturn($arrayRepresentation);

        $this->assertSame(
            $arrayRepresentation,
            $this->subject->get($queryParameter)
        );
    }
}