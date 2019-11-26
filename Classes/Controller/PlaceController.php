<?php

namespace DWenzel\Ajaxmap\Controller;
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
 *  the Free Software Foundation; either version 3 of the License, or
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

use DWenzel\Ajaxmap\Domain\Model\Place;
use DWenzel\Ajaxmap\Domain\Repository\PlaceRepository;
use DWenzel\Ajaxmap\Traits\PlaceDemandFactoryTrait;
use TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException;

/**
 *
 *
 * @package ajaxmap
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class PlaceController extends AbstractController
{
    use PlaceDemandFactoryTrait;

    /**
     * placeRepository
     *
     * @var PlaceRepository
     */
    protected $placeRepository;


    /**
     * action list
     *
     * @param array $overwriteDemand
     * @return void
     * @throws InvalidQueryException
     */
    public function listAction($overwriteDemand = null)
    {
        $demand = $this->getPlaceDemandFactory()->fromSettings($this->settings);
        $places = $this->placeRepository->findDemanded($demand);
        $this->view->assignMultiple(
            array(
                'places' => $places,
                'settings' => $this->settings,
                'overwriteDemand' => $overwriteDemand
            )
        );
    }

    /**
     * Inject place repository
     *
     * @param PlaceRepository $placeRepository
     * @return void
     */
    public function injectPlaceRepository(PlaceRepository $placeRepository)
    {
        $this->placeRepository = $placeRepository;
    }

    /**
     * action show
     *
     * @param Place $place
     * @return void
     */
    public function showAction(Place $place)
    {
        $this->view->assignMultiple(
            array(
                'place' => $place,
                'settings' => $this->settings
            )
        );
    }

    /**
     * action ajax show
     *
     * @param integer $placeId
     * @param bool $json Whether to return json string
     * @return string
     */
    public function ajaxShowAction($placeId, $json = false)
    {
        $result = '';

        if ($place = $this->placeRepository->findByUid($placeId)) {
            if ($json) {
                $result = json_encode($place->toArray(10, $this->settings['mapping']));
            } else {
                $this->view->assign('place', $place);
                $result = $this->view->render();
            }
        }
        return $result;
    }

}

