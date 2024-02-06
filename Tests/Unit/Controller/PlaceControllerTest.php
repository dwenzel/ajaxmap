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
 * Test case for class DWenzel\Ajaxmap\Controller\PlaceController.
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

use DWenzel\Ajaxmap\Controller\PlaceController;
use DWenzel\Ajaxmap\Domain\Factory\Dto\PlaceDemandFactory;
use DWenzel\Ajaxmap\Domain\Model\Dto\PlaceDemand;
use DWenzel\Ajaxmap\Domain\Model\Place;
use DWenzel\Ajaxmap\Domain\Repository\PlaceRepository;
use Nimut\TestingFramework\TestCase\UnitTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

/**
 * Class PlaceControllerTest
 *
 * @package DWenzel\Ajaxmap\Tests
 */
class PlaceControllerTest extends UnitTestCase
{

    /**
     * @var PlaceController
     */
    protected $subject;

    /**
     * @var PlaceDemand
     */
    protected $mockDemand;

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     */
    protected $mockObjectManager;

    /**
     * @var PlaceRepository|MockObject
     */
    protected $placeRepository;

    /**
     * @var ViewInterface|MockObject
     */
    protected $view;

    /**
     * @var PlaceDemandFactory|MockObject
     */
    protected $placeDemandFactory;

    /**
     * @test
     * @return void
     * @throws InvalidQueryException
     */
    public function listActionFindsDemandedPlacesByDemandFromSettings()
    {
        $settings = [
            'list' => 'foo',
            'orderBy' => 'datetime',
            'orderDirection' => 'bar'
        ];
        $mockQueryResult = $this->getMockBuilder(QueryResultInterface::class)
            ->getMockForAbstractClass();

        $this->inject(
            $this->subject,
            'settings',
            $settings
        );

        $expectedVariables = ['places' => $mockQueryResult,
            'settings' => $settings,
            'overwriteDemand' => NULL
        ];

        $this->placeDemandFactory->expects($this->once())
            ->method('fromSettings')
            ->willReturn($this->mockDemand);


        $this->placeRepository->expects($this
            ->once())
            ->method('findDemanded')
            ->with($this->mockDemand)->willReturn($mockQueryResult);
        $this->view->expects($this->once())
            ->method('assignMultiple')
            ->with($expectedVariables);
        $this->subject->listAction();
    }

    /**
     * Test for creating correct demand call
     *
     * @test
     * @return void
     */
    public function ajaxShowActionFindsOneByUid()
    {
        $placeId = 1;
        $mockPlace = $this->getMockBuilder(Place::class)
            ->getMock();
        $this->placeRepository->expects(
            $this->once())
            ->method('findByUid')
            ->will($this->returnValue($mockPlace));

        $this->subject->ajaxShowAction($placeId);
    }

    /**
     * Test for assigning variables to view
     *
     * @test
     * @return void
     */
    public function showActionAssignsVariables()
    {
        $settings = ['foo' => 'bar'];
        $mockPlace = $this->getMockBuilder(Place::class)
            ->getMock();
        $this->inject(
            $this->subject,
            'settings',
            $settings
        );
        $this->view->expects($this->once())
            ->method('assignMultiple')
            ->with(
                ['place' => $mockPlace, 'settings' => $settings]
            );
        $this->subject->showAction($mockPlace);
    }

    protected function setUp()
    {
        $this->subject = $this->getMockBuilder(PlaceController::class)
            ->disableOriginalConstructor()
            ->setMethods(['dummy'])->getMock();
        $this->mockObjectManager = $this->getMockBuilder(ObjectManager::class)
            ->setMethods(['get'])->getMock();
        $this->inject(
            $this->subject,
            'objectManager',
            $this->mockObjectManager
        );

        $this->mockDemand = $this->getMockBuilder(PlaceDemand::class)
            ->getMock();
        $this->placeRepository = $this->getMockBuilder(PlaceRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->inject($this->subject, 'placeRepository', $this->placeRepository);
        $this->view = $this->getMockBuilder(ViewInterface::class)
            ->setMethods(['assign', 'assignMultiple'])
            ->getMockForAbstractClass();
        $this->inject($this->subject, 'view', $this->view);
        $this->placeDemandFactory = $this->getMockBuilder(PlaceDemandFactory::class)
            ->getMock();
        $this->placeDemandFactory->injectObjectManager($this->mockObjectManager);
        $this->subject->injectPlaceDemandFactory($this->placeDemandFactory);
    }
}
