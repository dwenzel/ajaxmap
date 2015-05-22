<?php

namespace Webfox\Ajaxmap\Controller;
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
use Webfox\Ajaxmap\Domain\Model\Dto\PlaceDemand;

/**
 *
 *
 * @package ajaxmap
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class PlaceController extends AbstractController {

	/**
	 * placeRepository
	 *
	 * @var \Webfox\Ajaxmap\Domain\Repository\PlaceRepository
	 */
	protected $placeRepository;

	/**
	 * action list
	 *
	 * @return void
	 * @param \array $overwriteDemand
	 */
	public function listAction($overwriteDemand = NULL) {
		$demand = $this->createDemandFromSettings($this->settings);
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
	 * injectLocationRepository
	 *
	 * @param \Webfox\Ajaxmap\Domain\Repository\PlaceRepository $PlaceRepository
	 * @return void
	 */
	public function injectPlaceRepository(\Webfox\Ajaxmap\Domain\Repository\PlaceRepository $placeRepository) {
		$this->placeRepository = $placeRepository;
	}

	/**
	 * action show
	 *
	 * @param \Webfox\Ajaxmap\Domain\Model\Place $place
	 * @return void
	 */
	public function showAction(\Webfox\Ajaxmap\Domain\Model\Place $place) {
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
	 * @return string
	 */
	public function ajaxShowAction($placeId) {
		$result = '';
		$place = $this->placeRepository->findByUid($placeId);
		if($place) {
			$result = json_encode($place->toArray(10, $this->settings['mapping']));
		}
		return $result;
	}

	/**
	 * Create demand from settings
	 *
	 * @param \array $settings
	 * @return \Webfox\Ajaxmap\Domain\Model\Dto\PlaceDemand
	 */
	public function createDemandFromSettings ($settings) {
		/** @var PlaceDemand $demand */
		$demand = $this->objectManager->get('Webfox\\Ajaxmap\\Domain\\Model\\Dto\\PlaceDemand');
		if ($settings['orderBy']) {
			$demand->setOrder($settings['orderBy'] . '|' . $settings['orderDirection']);
		}
		(isset($settings['map']))? $demand->setMap($settings['map']) : NULL;
		(isset($settings['locationTypes'])) ? $demand->setLocationTypes($settings['locationTypes']) : NULL;
		(isset($settings['placeGroups'])) ? $demand->setPlaceGroups($settings['placeGroups']) : NULL;
		if(isset($settings['constraintsConjunction']) AND $settings['constraintsConjunction'] !== '') {
			$demand->setConstraintsConjunction($settings['constraintsConjunction']);
		}
		if(isset($settings['placeGroupConjunction']) AND $settings['placeGroupConjunction'] !== '') {
			$demand->setPlaceGroupConjunction($settings['placeGroupConjunction']);
		}
		(isset($settings['limit'])) ? $demand->setLimit($settings['limit']) : NULL;
		return $demand;
	}

}

