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
 * Abstract Entity
 *
 * @package ajaxmap
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_Ajaxmap_DomainObject_AbstractEntity 
	extends Tx_Extbase_DomainObject_AbstractEntity 
	implements Tx_Ajaxmap_DomainObject_SerializableInterface {

	/**
	 * Return the object as array
	 *
	 * @return array
	 */
	public function toArray() {
		$properties = \TYPO3\CMS\Extbase\Reflection\ObjectAccess::getGettableProperties($this);
		\TYPO3\CMS\Core\Utility\GeneralUtility::devLog('get props', 'ajaxmap', 1, $properties);
		$result = array();
		foreach($properties as $propertyName=>$propertyValue) {
			if(is_a($propertyValue, 'TYPO3\CMS\Extbase\Persistence\ObjectStorage')) {
				$objectArray = $propertyValue->toArray();
				$children = array();
				foreach($objectArray as $object) {
					if(method_exists($object, 'toArray')) {
						$children[] = $object->toArray();
					} else {
						$children[] = 'not implemented yet';
					}
				}
				$result[$propertyName] = $children;
			} elseif (
					is_object($propertyValue) 
					&& method_exists($propertyValue, 'toArray')
				) {
					$result[propertyName] = $propertyValue->toArray();
			} else {
				$result[$propertyName] = $propertyValue;
			}
		}
		\TYPO3\CMS\Core\Utility\GeneralUtility::devLog('toArray', 'ajaxmap', 1, $result);
		return $result;
	}

	/**
	 * Returns a JSON Representation of the object
	 *
	 * @return string
	 */
	public function toJson() {
		return json_encode($this->toArray());
	}
}
?>
