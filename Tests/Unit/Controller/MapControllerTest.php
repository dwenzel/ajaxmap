<?php

namespace DWenzel\Ajaxmap\Tests\Controller;
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

use DWenzel\Ajaxmap\Configuration\SettingsInterface as SI;
use DWenzel\Ajaxmap\Controller\MapController;
use DWenzel\Ajaxmap\Domain\Model\Map;
use DWenzel\Ajaxmap\Domain\Repository\MapRepository;
use Nimut\TestingFramework\TestCase\UnitTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Fluid\View\TemplateView;

/**
 * Test case for class \DWenzel\Ajaxmap\Controller\MapController.
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

/**
 * Class MapControllerTest
 *
 * @package DWenzel\Ajaxmap\Tests
 */
class MapControllerTest extends UnitTestCase
{

    /**
     * @var MapController
     */
    protected $subject;

    /**
     * @var ViewInterface|MockObject
     */
    protected $view;

    /**
     * @var MapRepository|MockObject
     */
    protected $mapRepository;

    public function setUp()
    {
        $this->subject = $this->getMockBuilder(MapController::class)
            ->disableOriginalConstructor()
            ->setMethods(['dummy'])->getMock();

        $this->mapRepository = $this->getMockBuilder(MapRepository::class)
            ->disableOriginalConstructor()->getMock();
        $this->subject->injectMapRepository($this->mapRepository);
        $this->view = $this->getMockBuilder(TemplateView::class)
            ->disableOriginalConstructor()->getMock();

        $this->inject(
            $this->subject,
            'view',
            $this->view
        );
    }

    /**
     * Test for assigning variables to view
     *
     * @test
     * @return void
     */
    public function showActionAssignsVariables()
    {
        $mockMap = $this->getMockBuilder(Map::class)
            ->getMock();
        $settings = ['map' => '1'];
        $expectedMapSettings = SI::MAP_SETTINGS;
        $expectedMapSettings['id'] = $settings['map'];

        $this->inject(
            $this->subject,
            'settings',
            $settings
        );
        $this->view->expects($this->once())
            ->method('assignMultiple')
            ->with(
                [
                    'map' => $mockMap,
                    'settings' => $settings,
                    'mapSettings' => \json_encode($expectedMapSettings)
                ]
            );
        $this->subject->showAction($mockMap);
    }
}


