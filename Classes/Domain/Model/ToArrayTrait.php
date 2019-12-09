<?php
namespace DWenzel\Ajaxmap\Domain\Model;

use DWenzel\Ajaxmap\Domain\Model\Dto\MappingAwareInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Reflection\ObjectAccess;

/**
 * Class ToArrayTrait
 *
 * @package DWenzel\Ajaxmap\Domain\Model
 */
trait ToArrayTrait
{
    use FileObjectResolverTrait;

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
                } elseif (isset($mapping[$className][$propertyName]['replace'])) {
                    $propertyValue = $this->replacePropertyValueIdentifiers($mapping[$className][$propertyName]['replace'], $properties);
                } elseif ($this instanceof MappingAwareInterface && $this->canPropertyBeMapped($propertyName, $mapping[$className][$propertyName])) {
                    $propertyValue = $this->mapProperty($propertyName, $mapping[$className][$propertyName]);
				} elseif (isset($mapping[$className][$propertyName]['exclude'])) {
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
				} else {
                    $children[] = $this->resolveFileObject($object) ?? $object;
                }
			}
			$result = $children;
		} elseif (is_object($value) AND method_exists($value, 'toArray')){
			$result = $value->toArray($treeDepth, $mapping);
		} else {
            $result = $this->resolveFileObject($value) ?? $value;
        }
		return $result;
	}

    /**
     * @param string $propertyValue
     * @param array $properties
     * @return mixed
     */
    protected function replacePropertyValueIdentifiers(string $propertyValue, array $properties): string
    {
        $value = $propertyValue;

        if (strpos($propertyValue, '{') === false) {
            return $value;
        }

        preg_match_all('/{([^{}]*)}/', $propertyValue, $matches, PREG_PATTERN_ORDER | PREG_OFFSET_CAPTURE);
        if (empty($matches[0])) {
            return $value;
        }

        for ($i = count($matches[0]) - 1; $i >= 0; $i--) {
            $identifier = $matches[1][$i][0];
            $position = $matches[0][$i][1];
            $length = mb_strlen($matches[0][$i][0]);
            $replacementValue = (string) ObjectAccess::getPropertyPath($properties, $identifier);
            $value = substr_replace($value, $replacementValue, $position, $length);
        }

        return $this->replacePropertyValueIdentifiers($value, $properties);
    }
}
