<?php

namespace DWenzel\Ajaxmap\Tests\Unit\Data;

use DWenzel\Ajaxmap\Controller\MissingRequestArgumentException;
use DWenzel\Ajaxmap\Data\CategoryDataProvider;
use DWenzel\Ajaxmap\Domain\Model\Category;
use DWenzel\Ajaxmap\Domain\Model\Map;
use DWenzel\Ajaxmap\Domain\Model\Place;
use DWenzel\Ajaxmap\Domain\Repository\CategoryRepository;
use DWenzel\Ajaxmap\Domain\Repository\MapRepository;
use DWenzel\Ajaxmap\Domain\Repository\PlaceRepository;
use DWenzel\Ajaxmap\Utility\TreeUtility;
use Nimut\TestingFramework\TestCase\UnitTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
use DWenzel\Ajaxmap\Configuration\SettingsInterface as SI;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

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
 * Class CategoryDataProviderTest
 */
class CategoryDataProviderTest extends UnitTestCase
{

    /**
     * @var CategoryDataProvider|MockObject
     */
    protected $subject;

    /**
     * @var ObjectManagerInterface|MockObject
     */
    protected $objectManager;

    /**
     * @var MapRepository|MockObject
     */
    protected $mapRepository;

    /**
     * @var TreeUtility|MockObject
     */
    protected $treeUtility;

    /**
     * @var CategoryRepository|MockObject
     */
    protected $categoryRepository;

    public function setUp()
    {
        parent::setUp();
        $this->objectManager = $this->getMockBuilder(ObjectManagerInterface::class)
            ->setMethods(['get'])->getMockForAbstractClass();
        $this->categoryRepository = $this->getMockBuilder(CategoryRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['findByUid', 'findChildren'])->getMock();
        $this->mapRepository = $this->getMockBuilder(MapRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['findByUid'])->getMock();
        $this->treeUtility = $this->getMockBuilder(TreeUtility::class)
            ->setMethods(['buildObjectTree', 'convertObjectTreeToArray'])
            ->getMock();

        $this->objectManager->expects($this->exactly(3))
            ->method('get')
            ->withConsecutive(
                [MapRepository::class],
                [CategoryRepository::class],
                [TreeUtility::class]
            )
            ->willReturnOnConsecutiveCalls(
                $this->mapRepository,
                $this->categoryRepository,
                $this->treeUtility
            );
        $this->subject = new CategoryDataProvider($this->objectManager);
    }

    public function testGetThrowsMissingRequestArgumentException() {
        $queryParameter = ['foo'];
        $this->expectException(MissingRequestArgumentException::class);
        $this->subject->get($queryParameter);
    }

    public function testGetReturnsArray() {
        $queryParameter = [
            SI::API_PARAMETER_MAP_ID => '15'
        ];
        $this->assertTrue(
            is_array($this->subject->get($queryParameter))
        );
    }

    public function testGetsArrayRepresentationOfCategoriesOfMap() {
        $mapIdParameter = '15';
        $categoryId = 2;
        $queryParameter = [
            SI::API_PARAMETER_MAP_ID => $mapIdParameter
        ];

        $arrayRepresentation = [];
        $map = $this->getMockBuilder(Map::class)
            ->setMethods(['getCategories'])->getMock();

        $category = $this->getMockBuilder(Category::class)
            ->setMethods(['getUid'])
            ->getMock();
        $objectStorageWithMaps = new ObjectStorage();
        $objectStorageWithMaps->attach($category);

        $this->mapRepository->expects($this->once())
            ->method('findByUid')
            ->with((int)$mapIdParameter)
            ->willReturn($map);

        $map->expects($this->atLeast(1))
            ->method('getCategories')
            ->willReturn($objectStorageWithMaps);
        $category->expects($this->once())->method('getUid')
            ->willReturn($categoryId);

        $this->assertSame(
            $arrayRepresentation,
            $this->subject->get($queryParameter)
        );
    }
}