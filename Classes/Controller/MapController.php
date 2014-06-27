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
class Tx_Ajaxmap_Controller_MapController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * mapRepository
	 *
	 * @var Tx_Ajaxmap_Domain_Repository_MapRepository
	 */
	protected $mapRepository;

	/**
	 * regionRepository
	 *
	 * @var Tx_Ajaxmap_Domain_Repository_RegionRepository
	 */
	protected $regionRepository;
    
    /**
     * placeRepository
     *
     * @var Tx_Ajaxmap_Domain_Repository_PlaceRepository
     */	
	protected $placeRepository;

	/**
	 * injectMapRepository
	 *
	 * @param Tx_Ajaxmap_Domain_Repository_MapRepository $mapRepository
	 * @return void
	 */
	public function injectMapRepository(Tx_Ajaxmap_Domain_Repository_MapRepository $mapRepository) {
		$this->mapRepository = $mapRepository;
	}
    /**
     * inject place repository
     *
     * @param Tx_Ajaxmap_Domain_Repository_PlaceRepository $placeRepository
     * @return void
     */
    public function injectPlaceRepository(Tx_Ajaxmap_Domain_Repository_PlaceRepository $placeRepository) {
        $this->placeRepository = $placeRepository;
    }
	
	/**
	 * injectRegionRepository
	 *
	 * @param Tx_Ajaxmap_Domain_Repository_RegionRepository $regionRepository
	 * @return void
	 */
	public function injectRegionRepository(Tx_Ajaxmap_Domain_Repository_RegionRepository $regionRepository) {
		$this->regionRepository = $regionRepository;
	}

	/**
	 * Sets the view
	 *
	 * This method should only be used for unit testing purposes.
	 * @param Tx_Fluid_View_TemplateView $view The new view
	 * @return void
	 */
	public function setView($view) {
		$this->view = $view;
	}

	/**
	 * action item - get map attributes
	 *
	 * @return json data
	 * @todo vary result by task given as argument (i.e. buildMap, updateMap...)
	 */
	public function itemAction() {
		// get arguments of request
		$arguments =  t3lib_div::_GET('arguments');
		$response = array();
		// get map ID
		$mapId = $arguments['mapId'];
		$placeId = $arguments['placeId'];
		
		/**
		* @var string
		*/
		$task = $arguments['task'];
		
		if ($mapId){
			$map = $this->mapRepository->findByUid($mapId);
			switch ($task) {
                case 'buildMap':
										$response = $map->toArray(100, $this->settings['mapping']);
                    break;
                case'loadCategories':
										if ($map->getCategories()){
											$categoriesObjArray = $map->getCategories()->toArray();
											foreach ($categoriesObjArray as $category){
												array_push(
														$response, 
														$category->toArray(10, $this->settings['mapping'])
												);
											}
										}
										break;
                case 'loadLocationTypes':
										if ($map->getLocationTypes()){
											$locationTypesObjArray = $map->getLocationTypes()->toArray();
											foreach ($locationTypesObjArray as $location){
												array_push(
														$response, 
														$location->toArray(10, $this->settings['mapping']));
											}
										}
										break;
                case 'loadPlaces':
                    $response = $this->getPlaces($map);
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
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$maps = $this->mapRepository->findAll();
		$this->view->assign('maps', $maps);
	}

	/**
	 * action show
	 *
	 * @param $map
	 * @return void
	 */
	public function showAction(Tx_Ajaxmap_Domain_Model_Map $map = NULL) {
		if ($map===NULL) {
			$mapId = $this->settings['map'];
			$map = $this->mapRepository->findOneByUid($mapId);
		}
		$this->view->assignMultiple(
				array(
					'map' => $this->mapRepository->findByUid($mapId),
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
	private function getPlaces(Tx_Ajaxmap_Domain_Model_Map $map = NULL){
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
        $select = 'uid, title, type, description, icon, category, geo_coordinates';
        //@todo respect storage page
	    $where = 'deleted = 0 AND hidden = 0';
			if($types != ''){ 
	    	$where .= ' AND type IN (' .$types .')';
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
