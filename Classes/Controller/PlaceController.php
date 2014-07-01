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

/**
 *
 *
 * @package ajaxmap
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class PlaceController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

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
	 * @param \Webfox\Ajaxmap\Domain\Model\Place
	 */
	public function listAction() {
		$places = $this->placeRepository->findAll();
		$this->view->assign('places', $places);
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
	 * @param \integer $placeId
	 * @return void
	 */
	public function ajaxShowAction($placeId) {
		$result = '';
		$place = $this->placeRepository->findByUid($placeId);
		if($place) {
			$result = json_encode($place->toArray());
		}
		return $result;
	}

}
?>
