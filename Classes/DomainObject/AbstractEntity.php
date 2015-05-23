<?php

namespace Webfox\Ajaxmap\DomainObject;
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
use TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy;
use TYPO3\CMS\Extbase\Persistence\Generic\LazyObjectStorage;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Reflection\ObjectAccess;
/**
 * Abstract Entity
 *
 * @package ajaxmap
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class AbstractEntity 
	extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity 
	implements SerializableInterface {

	/**
	 * Return the object as array
	 *
	 * @param integer $treeDepth maximum tree depth
	 * @param array $mapping An array with keys for each model
	 * which should be mapped. 
	 * @return array
	 */
	public function toArray($treeDepth = 100, $mapping = NULL) {
		if($this instanceof LazyLoadingProxy) {
			$this->_loadRealInstance();
		}
		if($treeDepth < 1) {
			return 'maximum tree depth reached!';
		}
		$treeDepth = $treeDepth - 1;
		$properties = ObjectAccess::getGettableProperties($this);
		$result = array();
		foreach($properties as $propertyName=>$propertyValue) {
			$hasMapping = FALSE;
			$className = get_class($this);
			if($mapping && count($mapping)) {
				$hasMapping = isset($mapping[$className]);
			}
			if($hasMapping && array_key_exists($propertyName, $mapping[$className])) {
				$propertyName = $mapping[$className][$propertyName];
			}
			$result[$propertyName] = $this->convertValueToArray($propertyValue, $treeDepth, $mapping);
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
	 * @param mixed $value
	 * @param int $treeDepth
	 * @param null $mapping
	 * @return mixed
	 * @internal param mixed $value Value of the property
	 * @internal param int $treeDepth maximum tree depth, default 100
	 * @var array $mapping An array with mapping rules
	 */
	protected function convertValueToArray($value, $treeDepth = 100, $mapping = NULL) {
		if($value instanceof ObjectStorage) {
			$objectArray = $value->toArray();
			$children = array();
			foreach($objectArray as $object) {
				if(method_exists($object, 'toArray')) {
					$children[] = $object->toArray($treeDepth, $mapping);
				} 			}
			$result = $children;
		} elseif (is_object($value) AND method_exists($value, 'toArray')){
			$result = $value->toArray($treeDepth, $mapping);
		} else {
			$result = $value;
		}
		return $result;
	}
}

