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
     * placeRepository
     *
     * @var \Webfox\Ajaxmap\Domain\Repository\PlaceRepository
     */	
	protected $placeRepository;

	/**
	 * injectMapRepository
	 *
	 * @param \Webfox\Ajaxmap\Domain\Repository\MapRepository $mapRepository
	 * @return void
	 */
	public function injectMapRepository(\Webfox\Ajaxmap\Domain\Repository\MapRepository $mapRepository) {
		$this->mapRepository = $mapRepository;
	}
    /**
     * inject place repository
     *
     * @param \Webfox\Ajaxmap\Domain\Repository\PlaceRepository $placeRepository
     * @return void
     */
    public function injectPlaceRepository(\Webfox\Ajaxmap\Domain\Repository\PlaceRepository $placeRepository) {
        $this->placeRepository = $placeRepository;
    }
	
	/**
	 * injectRegionRepository
	 *
	 * @param \Webfox\Ajaxmap\Domain\Repository\RegionRepository $regionRepository
	 * @return void
	 */
	public function injectRegionRepository(\Webfox\Ajaxmap\Domain\Repository\RegionRepository $regionRepository) {
		$this->regionRepository = $regionRepository;
	}

	/**
	 * action item - get map attributes
	 * 
	 * @param \string $task
	 * @param \integer $mapId
	 * @param \integer $pageId
	 * @param \integer $placeId
	 * @return json data
	 */
	public function itemAction($task, $mapId = NULL, $pageId = NULL, $placeId = NULL ) {
		$response = array();
		if ($mapId){
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
	 * @param \integer $pageId
	 * @return json
	 */
	public function ajaxListPlacesAction($mapId = NULL, $pageId = NULL) {
		$places = array();
		if($mapId) {
			// places from map
			$map = $this->mapRepository->findByUid($mapId);
			if($map) {
				if($map->getPlaces()) {
					// map got places
					$places = $map->getPlaces()->toArray();
				} elseif ($map->getLocationTypes()) {
					// get places by location type
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
	 * @return json
	 */
	public function ajaxListCategoriesAction($mapId = NULL) {
		$categories = array();
		if($mapId) {
			$map = $this->mapRepository->findByUid($mapId);
			if ($map AND $map->getCategories()){
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
	 * Ajax list location types action
	 *
	 * @param \integer $mapId
	 * @return json
	 */
	public function ajaxListLocationTypesAction($mapId = NULL) {
		$locationTypes = array();
		if($mapId) {
			$map = $this->mapRepository->findByUid($mapId);
			if ($map AND $map->getLocationTypes()){
				$locationTypesObjArray = $map->getLocationTypes()->toArray();
				foreach ($locationTypesObjArray as $locationType){
					array_push(
						$locationTypes,
						$locationType->toArray(10, $this->settings['mapping'])
					);
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
	public function showAction(\Webfox\Ajaxmap\Domain\Model\Map $map = NULL) {
		if ($map===NULL) {
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
	 * Get all places (defined by categories, location, manually selected in map)
	 * @param $map > 
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
	
	private function getAddressForPlace($placeId){
	    if($placeId){
            //@todo provide a label (set by TypoScript)
	        return $this->placeRepository->findAddressForPlace($placeId);
	    }
	}
	
}
?>
