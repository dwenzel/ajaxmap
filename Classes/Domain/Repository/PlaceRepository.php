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
class Tx_Ajaxmap_Domain_Repository_PlaceRepository extends Tx_Extbase_Persistence_Repository {
    /**
     * 
     * Returns all objects of this repository with matching location type
     * 
     * @param Tx_Ajaxmap_Domain_Model_LocationType $locationType
     * 
     * @return Tx_Extbase_Persistence_QueryResult
     */
    public function findByType(Tx_Ajaxmap_Domain_Model_LocationType $locationType) {
        $typeId = $locationType->getUid();
/*    	$query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(FALSE);
        $query->matching($query->equals('type', $locationType));
        $result = $query->execute();*/
        
        $fields = '*';
        $table = 'tx_ajaxmap_domain_model_place';
        $where = 'deleted = 0 AND hidden = 0'; 
        $groupBy='';
        $orderBy='';
        $limit='';
        $result = $GLOBALS['TYPO3_DB']->exec_SELECTquery($fields,$table,$where,$groupBy,$orderBy,$limit);
        
        return $result;
    }
    
    /**
    *
    * Returns an array with all rows in repository
    */
    public function findRaw(){
    	$query = $this->createQuery();
		$query->getQuerySettings()->setReturnRawQueryResult(TRUE);
		$query->statement('SELECT * from tx_ajaxmap_domain_model_place');
		return $query->execute();
    }
    /**
    *@param string $where
    */
    public function findRawSelectWhere($select, $where){
    	$statement = 'SELECT ' .$select .' from tx_ajaxmap_domain_model_place WHERE ' . $where;
    	$query = $this->createQuery();
		$query->getQuerySettings()->setReturnRawQueryResult(TRUE);
		$query->statement($statement);
		return $query->execute();
    }
    
    public function findCategoriesForPlace($placeId){
        $statement = 'SELECT categories.uid, categories.title '
        .' FROM tx_ajaxmap_domain_model_place AS places '
        .'LEFT JOIN tx_ajaxmap_place_category_mm AS mm '
        .'ON (places.uid = mm.uid_local) '
        .'LEFT JOIN tx_ajaxmap_domain_model_category AS categories '
        .'ON (mm.uid_foreign = categories.uid) '
        .'WHERE places.category AND categories.uid AND places.uid=' .$placeId;
        $query = $this->createQuery();
        $query->getQuerySettings()->setReturnRawQueryResult(TRUE);
        $query->statement($statement);
        return $query->execute();
    }
    
    public function findAddressForPlace($placeId){
        $statement = 'SELECT * 
             FROM tt_address AS address ' 
        .'LEFT JOIN tx_ajaxmap_domain_model_place AS place '
        .'ON (place.address= address.uid) ' 
        . 'WHERE place.uid='.$placeId;
        $query = $this->createQuery();
        $query->getQuerySettings()->setReturnRawQueryResult(TRUE);
        $query->statement($statement);
        $result = $query->execute();
        return $result[0];
    }
}
?>
