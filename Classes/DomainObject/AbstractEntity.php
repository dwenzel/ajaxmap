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
	 * @param integer $treeDepth maximum tree depth
	 * @param array $mapping An array with keys for each model
	 * which should be mapped. 
	 * @return array
	 */
	public function toArray($treeDepth = 100, $mapping = NULL) {
		if($treeDepth < 1) {
			return 'maximum tree depth reached!';
		}
		$treeDepth = $treeDepth - 1;
		$properties = \TYPO3\CMS\Extbase\Reflection\ObjectAccess::getGettableProperties($this);
		$result = array();
		foreach($properties as $propertyName=>$propertyValue) {
			$className = strtolower(get_class($this));
			if(count($mapping) && array_key_exists($propertyName, $mapping[$className])) {
				$propertyName = $mapping[$className][$propertyName];
			}
			$result[$propertyName] = $this->convertValueToArray($propertyValue, $treeDepth);
		}
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

	/**
	 * Convert a property value to an array
	 *
	 * @var integer $treeDepth maximum tree depth, default 100
	 * @var mixed $value Value of the property
	 * return mixed 
	 */
	protected function convertValueToArray($value, $treeDepth = 100, $mapping = NULL) {
		if(is_a($value, 'TYPO3\CMS\Extbase\Persistence\ObjectStorage')) {
			$objectArray = $value->toArray();
			$children = array();
			foreach($objectArray as $object) {
				if(method_exists($object, 'toArray')) {
					$children[] = $object->toArray($treeDepth, $mapping);
				} 			}
			$result = $children;
		} elseif (is_object($value) && method_exists($value, 'toArray')) {
				$result = $value->toArray($treeDepth, $mapping);
		} else {
			$result = $value;
		}
		return $result;
	}
}
?>
