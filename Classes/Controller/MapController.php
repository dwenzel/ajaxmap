<?php
namespace Webfox\Ajaxmap\Controller;
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
use Webfox\Ajaxmap\Domain\Repository\MapRepository;
use Webfox\Ajaxmap\Domain\Repository\PlaceRepository;
use Webfox\Ajaxmap\Domain\Repository\RegionRepository;
use Webfox\Ajaxmap\Domain\Model\Category;
use Webfox\Ajaxmap\Domain\Model\LocationType;
use Webfox\Ajaxmap\Domain\Model\Map;
use Webfox\Ajaxmap\Domain\Model\PlaceGroup;
use Webfox\Ajaxmap\Utility\TreeUtility;

/**
 * @package ajaxmap
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class MapController extends AbstractController {
	/**
	 * mapRepository
	 *
	 * @var \Webfox\Ajaxmap\Domain\Repository\MapRepository
	 */
	protected $mapRepository;

	/**
	 * regionRepository
	 *
	 * @var \Webfox\Ajaxmap\Domain\Repository\RegionRepository
	 */
	protected $regionRepository;

	/**
	 * Place Repository
	 *
	 * @var \Webfox\Ajaxmap\Domain\Repository\PlaceRepository
	 */
	protected $placeRepository;

	/**
	 * Place Group Repository
	 *
	 * @var \Webfox\Ajaxmap\Domain\Repository\PlaceGroupRepository
	 * @inject
	 */
	protected $placeGroupRepository;

	/**
	 * injectMapRepository
	 *
	 * @param \Webfox\Ajaxmap\Domain\Repository\MapRepository $mapRepository
	 * @return void
	 */
	public function injectMapRepository(MapRepository $mapRepository) {
		$this->mapRepository = $mapRepository;
	}

	/**
	 * inject place repository
	 *
	 * @param \Webfox\Ajaxmap\Domain\Repository\PlaceRepository $placeRepository
	 * @return void
	 */
	public function injectPlaceRepository(PlaceRepository $placeRepository) {
		$this->placeRepository = $placeRepository;
	}

	/**
	 * injectRegionRepository
	 *
	 * @param \Webfox\Ajaxmap\Domain\Repository\RegionRepository $regionRepository
	 * @return void
	 */
	public function injectRegionRepository(RegionRepository $regionRepository) {
		$this->regionRepository = $regionRepository;
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
		if ($mapId) {
			/** @var \Webfox\Ajaxmap\Domain\Model\Map $map */
			$map = $this->mapRepository->findByUid($mapId);
			switch ($task) {
				case 'buildMap':
					$response = $map->toArray(100, $this->settings['mapping']);
					break;
				case 'getAddress':
					$response = $this->getAddressForPlace($placeId);
					break;
				default:

			}
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
			$map = $this->mapRepository->findByUid($mapId);
			if ($map) {
				if ($map->getPlaces()) {
					$places = $map->getPlaces()->toArray();
				} elseif ($map->getLocationTypes()) {
					$places = $this->getPlaces($map);
				}
			}
		} else {
			// get all places
			$places = $this->placeRepository->findAll()->toArray();
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
				foreach ($categoryObjArray as $category){
					array_push(
						$categories,
						$category->toArray(10, $this->settings['mapping'])
					);
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
				if ((bool)$placeGroupObjArray) {
					$rootIds = array();
					foreach ($placeGroupObjArray as $placeGroup) {
						/** @var PlaceGroup $placeGroup */
						$rootIds[] = $placeGroup->getUid();
					}
					$rootIdList = implode(',', $rootIds);
					if ($children = $this->placeGroupRepository->findChildren($rootIdList, FALSE)) {
						$objectTree = TreeUtility::buildObjectTree($children);
						$placeGroups = TreeUtility::convertObjectTreeToArray(
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
	 * @param \Webfox\Ajaxmap\Domain\Model\Map $map
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
	 * Get all places (defined by placeGroups, location, manually selected in map)
	 *
	 * @param \Webfox\Ajaxmap\Domain\Model\Map $map
	 * @return array
	 */
	private function getPlaces(\Webfox\Ajaxmap\Domain\Model\Map $map = NULL){
	    // - make empty list of places
	    $places = array();
	    
	    //@todo - add all manually selected places (from map - field is currently hidden in backend) 
	    
	    // - add all places of selected location types (from map)
        $typesArr = array();
        foreach ($map->getLocationTypes()->toArray() as $type) {
					array_push($typesArr, $type->getUid());
        }
        // convert types array to string for query
        $types = implode(',',$typesArr);
        $select = 'uid, title, location_type, description, icon, category, geo_coordinates';
        //@todo respect storage page
	    $where = 'deleted = 0 AND hidden = 0';
			if($types != ''){ 
	    	$where .= ' AND location_type IN (' .$types .')';
			}
        $places = $this->placeRepository->findRawSelectWhere($select, $where);
       	
       	// replace category count by array of categories
       	foreach ($places as &$place) {
			   if($place['category']){
			       $categories = $this->placeRepository->findCategoriesForPlace($place[uid]);
			       $place['category'] = $categories;
			   }
		   }  
	return $places;
	}

	/**
	 * @param integer $placeId
	 * @return array|NULL
	 */
	private function getAddressForPlace($placeId) {
		return $this->placeRepository->findAddressForPlace($placeId);
	}

}

