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
class Webfox\Ajaxmap\Controller\RegionController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * regionRepository
	 *
	 * @var Webfox\Ajaxmap\Domain\Repository\RegionRepository
	 */
	protected $regionRepository;

	/**
	 * action list
	 *
	 * @return void
	 */
	
	/**
	 * injectRegionRepository
	 *
	 * @param Webfox\Ajaxmap\Domain\Repository\RegionRepository $regionRepository
	 * @return void
	 */
	public function injectRegionRepository(Webfox\Ajaxmap\Domain\Repository\RegionRepository $regionRepository) {
		$this->regionRepository = $regionRepository;
	}

	/**
	 * listAction
	 *
	 * @return
	 */
	public function listAction() {
		$regions = $this->regionRepository->findAll();
		$this->view->assign('regions', $regions);
	}

}
?>
