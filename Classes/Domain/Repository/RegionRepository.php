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
class Tx_Ajaxmap_Domain_Repository_RegionRepository extends Tx_Extbase_Persistence_Repository {

	/**
	 * findByMap
	 *
	 * @param $map
	 * @param $limit
	 * @return
	 */
	public function findByMap(Tx_Ajaxmap_Domain_Model_Map $map, $limit = 100) {
		
		// devlog
		$msg = 'findByMap';
       	$extKey = 'ajaxmap';
        $severity =  '1';
        $dataVar = $map;
        //t3lib_div::devLog($msg, $extKeyl, $severity, $dataVar); 
       
		$query = $this->createQuery();
        $query->matching('Tx_Ajaxmap_Domain_Model_Map', $map);
        	/*$query->logicalAnd(
        		$query->matching('map', $map),
        		$query->equals('pid', $this->storagePid)
        	)
        );*/
        $query->setLimit((integer)$limit);
        return $this->findByUid($query->execute());
	}

}
?>