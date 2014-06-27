<?php


/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Dirk Wenzel <wenzel@webfox01.de>
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
 * Mapping Utility
 *
 * @package ajaxmap
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_Ajaxmap_Utility_MappingUtility {

	/**
	 * Return a new array mapped according settings
	 *
	 * @var array $source The array to be mapped.
	 * @var array $settings Array with mapping settings
	 * @return array
	 */
		public function map($source, $settings) {
			$result = $source;
			$mappedArray = array();
			$models = array_keys($source);
			foreach($source as $key=>$value) {
				if(array_key_exists($key, $settings)) {
					$mappedArray[$settings[$key]] = $value;
				} else {
					$mappedArray[$key] = $value;
				}
			}
			if(count($mappedArray)) {
				$result = $mappedArray;
			}
			return $result;
		}
} 
