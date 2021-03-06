<?php
namespace DWenzel\Ajaxmap\Domain\Model;

use TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Reflection\ObjectAccess;
/**
 * Class ToArrayTrait
 *
 * @package DWenzel\Ajaxmap\Domain\Model
 */
trait ToArrayTrait {
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
			return NULL;
		}
		$treeDepth = $treeDepth - 1;
		$properties = ObjectAccess::getGettableProperties($this);
		$result = array();
		foreach($properties as $propertyName=>$propertyValue) {
			$maxDept = $treeDepth;

			if ($propertyValue instanceof LazyLoadingProxy) {
				$propertyValue = $propertyValue->_loadRealInstance();
			}

			$hasMapping = false;
			$className = get_class($this);
			if((bool)$mapping) {
				$hasMapping = isset($mapping[$className]);
			}
			if($hasMapping && array_key_exists($propertyName, $mapping[$className])) {
				if (isset($mapping[$className][$propertyName]['mapTo'])) {
					$propertyName = $mapping[$className][$propertyName]['mapTo'];
				} elseif (isset($mapping[$className][$propertyName]['exclude'])){
					continue;
				}

				if (isset($mapping[$className][$propertyName]['maxDept'])) {
					$maxDept = $mapping[$className][$propertyName]['maxDept'];
				}
			}
			$result[$propertyName] = $this->convertValueToArray($propertyValue, $maxDept, $mapping);
		}

		return $result;
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
