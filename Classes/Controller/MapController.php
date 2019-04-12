<?php
namespace DWenzel\Ajaxmap\Controller;

/***************************************************************
 *  Copyright notice
 *  (c) 2012 Dirk Wenzel <wenzel@webfox01.de>
 *  All rights reserved
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
use TYPO3\CMS\Extbase\Persistence\Generic\QueryResult;
use TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface;
use DWenzel\Ajaxmap\Domain\Model\Place;
use DWenzel\Ajaxmap\Domain\Repository\MapRepository;
use DWenzel\Ajaxmap\Domain\Repository\PlaceRepository;
use DWenzel\Ajaxmap\Domain\Repository\RegionRepository;
use DWenzel\Ajaxmap\Domain\Model\Category;
use DWenzel\Ajaxmap\Domain\Model\LocationType;
use DWenzel\Ajaxmap\Domain\Model\Map;
use DWenzel\Ajaxmap\Domain\Model\PlaceGroup;
use DWenzel\Ajaxmap\Utility\TreeUtility;

/**
 * @package ajaxmap
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class MapController extends AbstractController {

	/**
	 * mapRepository
	 *
	 * @var \DWenzel\Ajaxmap\Domain\Repository\MapRepository
	 */
	protected $mapRepository;

	/**
	 * regionRepository
	 *
	 * @var \DWenzel\Ajaxmap\Domain\Repository\RegionRepository
	 */
	protected $regionRepository;

	/**
	 * Place Repository
	 *
	 * @var \DWenzel\Ajaxmap\Domain\Repository\PlaceRepository
	 */
	protected $placeRepository;

	/**
	 * Place Group Repository
	 *
	 * @var \DWenzel\Ajaxmap\Domain\Repository\PlaceGroupRepository
	 * @TYPO3\CMS\Extbase\Annotation\Inject
	 */
	protected $placeGroupRepository;

	/**
	 * Category Repository
	 *
	 * @var \DWenzel\Ajaxmap\Domain\Repository\CategoryRepository
	 * @TYPO3\CMS\Extbase\Annotation\Inject
	 */
	protected $categoryRepository;

	/**
	 * @var \DWenzel\Ajaxmap\Utility\TreeUtility
	 */
	protected $treeUtility;

	/**
	 * injectMapRepository
	 *
	 * @param \DWenzel\Ajaxmap\Domain\Repository\MapRepository $mapRepository
	 * @return void
	 */
	public function injectMapRepository(MapRepository $mapRepository) {
		$this->mapRepository = $mapRepository;
	}

	/**
	 * inject place repository
	 *
	 * @param \DWenzel\Ajaxmap\Domain\Repository\PlaceRepository $placeRepository
	 * @return void
	 */
	public function injectPlaceRepository(PlaceRepository $placeRepository) {
		$this->placeRepository = $placeRepository;
	}

	/**
	 * injectRegionRepository
	 *
	 * @param \DWenzel\Ajaxmap\Domain\Repository\RegionRepository $regionRepository
	 * @return void
	 */
	public function injectRegionRepository(RegionRepository $regionRepository) {
		$this->regionRepository = $regionRepository;
	}

	/**
	 * inject tree utility
	 *
	 * @param \DWenzel\Ajaxmap\Utility\TreeUtility $treeUtility
	 * @return void
	 */
	public function injectTreeUtility(TreeUtility $treeUtility) {
		$this->treeUtility = $treeUtility;
	}

	/**
	 * action item - get map attributes
	 *
	 * @param \string $task
	 * @param \integer $mapId
	 * @param \integer $placeId
	 * @return string JSON data
	 */
	public function itemAction($task, $mapId = NULL, $placeId = NULL) {
		$response = array();
		/** @var \DWenzel\Ajaxmap\Domain\Model\Map $map */
		$map = $this->mapRepository->findByUid($mapId);
		switch ($task) {
			case 'buildMap':
				if ($mapId) {
					$response = $map->toArray(5, $this->settings['mapping']);
				}
				break;
			case 'getAddress':
				$response = $this->getAddressForPlace($placeId);
				break;
			default:

		}

		return json_encode($response);
	}

	/**
	 * Ajax list place action
	 *
	 * @param \integer $mapId
	 * @return string JSON encoded array of places
	 */
	public function ajaxListPlacesAction($mapId = NULL) {
		$places = array();
		if ($mapId) {
			/** @var Map $map */
			if ($map = $this->mapRepository->findByUid($mapId)) {
				if ($map->getPlaces()) {
					$places = $map->getPlaces()->toArray();
				} else {
					$placeDemand = $this->buildPlaceDemandFromMap($map);
					/** @var QueryResult $placeObjects */
					$placeObjects = $this->placeRepository->findDemanded($placeDemand, true, NULL, false);
					/** @var Place $place */
					foreach ($placeObjects as $place) {
						$places[] = $place->toArray(2, $this->settings['mapping']['listPlaces']);
					}
				}
			}
		}

		return json_encode($places);
	}

	/**
	 * Ajax list categories action
	 *
	 * @param \integer $mapId
	 * @return string JSON
	 */
	public function ajaxListCategoriesAction($mapId = NULL) {
		$categories = array();
		if ($mapId) {
			$map = $this->mapRepository->findByUid($mapId);
			if ($map AND $map->getCategories()) {
				$categoryObjArray = $map->getCategories()->toArray();
				if ((bool) $categoryObjArray) {
					$rootIds = array();
					/** @var Category $category */
					foreach ($categoryObjArray as $category) {
						$rootIds[] = $category->getUid();
					}
					$rootIdList = implode(',', $rootIds);
					if ($children = $this->categoryRepository->findChildren($rootIdList)) {
						$objectTree = $this->treeUtility->buildObjectTree($children);
						$categories = $this->treeUtility->convertObjectTreeToArray(
							$objectTree,
							'parent,pid',
							$this->settings['mapping']
						);
					}
				}
			}
		}

		return json_encode($categories);
	}

	/**
	 * Ajax list place groups action
	 *
	 * @param \integer $mapId
	 * @return string JSON
	 */
	public function ajaxListPlaceGroupsAction($mapId = NULL) {
		$placeGroups = array();
		if ($mapId) {
			/** @var Map $map */
			$map = $this->mapRepository->findByUid($mapId);
			if ($map AND $map->getPlaceGroups()) {
				$placeGroupObjArray = $map->getPlaceGroups()->toArray();
				if ((bool) $placeGroupObjArray) {
					$rootIds = array();
					foreach ($placeGroupObjArray as $placeGroup) {
						/** @var PlaceGroup $placeGroup */
						$rootIds[] = $placeGroup->getUid();
					}
					$rootIdList = implode(',', $rootIds);
					if ($children = $this->placeGroupRepository->findChildren($rootIdList, false)) {
						$objectTree = $this->treeUtility->buildObjectTree($children);
						$placeGroups = $this->treeUtility->convertObjectTreeToArray(
							$objectTree,
							'parent,pid',
							$this->settings['mapping']
						);
					}
				}
			}
		}

		return json_encode($placeGroups);
	}

	/**
	 * Ajax list location types action
	 *
	 * @param \integer $mapId
	 * @return string json
	 */
	public function ajaxListLocationTypesAction($mapId = NULL) {
		$locationTypes = array();
		if ($mapId) {
			$map = $this->mapRepository->findByUid($mapId);
			if ($map AND $map->getLocationTypes()) {
				$locationTypesObjArray = $map->getLocationTypes()->toArray();
				foreach ($locationTypesObjArray as $locationType) {
					/** @var LocationType $locationType */
					$locationTypes[] = $locationType->toArray(10, $this->settings['mapping']);
				}
			}
		}

		return json_encode($locationTypes);
	}

	/**
	 * action show
	 *
	 * @param \DWenzel\Ajaxmap\Domain\Model\Map $map
	 * @return void
	 */
	public function showAction(Map $map = NULL) {
		if ($map === NULL) {
			$mapId = $this->settings['map'];
			$map = $this->mapRepository->findByUid($mapId);
		}
		$this->view->assignMultiple(
			array(
				'map' => $map,
				'settings' => $this->settings,
				'pid' => $GLOBALS['TSFE']->id
			)
		);
	}

	/**
	 * Builds a demand object from map properties
	 *
	 * @param Map $map
	 * @return \DWenzel\Ajaxmap\Domain\Model\Dto\PlaceDemand
	 */
	protected function buildPlaceDemandFromMap(Map $map) {
		/** @var \DWenzel\Ajaxmap\Domain\Model\Dto\PlaceDemand $placeDemand */
		$placeDemand = $this->objectManager->get('DWenzel\\Ajaxmap\\Domain\\Model\\Dto\\PlaceDemand');
		$placeDemand->setConstraintsConjunction('or');

		$locationTypes = array();
		/** @var LocationType $type */
		foreach ($map->getLocationTypes()->toArray() as $type) {
			$locationTypes[] = $type->getUid();
		}
		if ((bool) $locationTypes) {
			$types = implode(',', $locationTypes);
			$placeDemand->setLocationTypes($types);
		}

		return $placeDemand;
	}

	/**
	 * @param integer $placeId
	 * @return array|NULL
	 */
	private function getAddressForPlace($placeId) {
		$address = array();
		/** @var Place $place */
		$place = $this->placeRepository->findByUid($placeId);
		if ($place) {
			$address = $place->getAddress()->toArray();
		}

		return $address;
	}

}

