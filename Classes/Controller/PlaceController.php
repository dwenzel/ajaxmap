<?php

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
class Tx_Ajaxmap_Controller_PlaceController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * placeRepository
	 *
	 * @var Tx_Ajaxmap_Domain_Repository_PlaceRepository
	 */
	protected $placeRepository;

	/**
	 * action list
	 *
	 * @return void
	 * @param Tx_Ajaxmap_Domain_Model_Place
	 */
	public function listAction() {
		$places = $this->placeRepository->findAll();
		$this->view->assign('places', $places);
	}

	/**
	 * injectLocationRepository
	 *
	 * @param Tx_Ajaxmap_Domain_Repository_PlaceRepository $PlaceRepository
	 * @return void
	 */
	public function injectPlaceRepository(Tx_Ajaxmap_Domain_Repository_PlaceRepository $placeRepository) {
		$this->placeRepository = $placeRepository;
	}

	/**
	 * action show
	 *
	 * @param $place
	 * @return void
	 */
	public function showAction(Tx_Ajaxmap_Domain_Model_Place $place) {
		$this->view->assign('place', $place);
	}

	/**
	 * action ajax show
	 *
	 * @param $place
	 * @return void
	 */
	public function showAction(Tx_Ajaxmap_Domain_Model_Place $place) {
		return $place;
	}

}
?>
