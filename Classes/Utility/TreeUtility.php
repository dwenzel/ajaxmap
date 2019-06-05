<?php
namespace Webfox\Ajaxmap\Utility;

/***************************************************************
 *  Copyright notice
 *  (c) 2015 Dirk Wenzel <dirk.wenzel@cps-it.de>
 *  All rights reserved
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use Webfox\Ajaxmap\Domain\Model\TreeItemInterface;
use Webfox\Ajaxmap\DomainObject\SerializableInterface;

/**
 * Class TreeUtility
 *
 * @package Webfox\Ajaxmap\Utility
 */
class TreeUtility {
	/**
	 * Builds a tree of objects.
	 *
	 * @param QueryResultInterface $objects
	 * @return array
	 */
	public function buildObjectTree(QueryResultInterface $objects) {
		$tree = array();
		$objects = $objects->toArray();

		$flatObjects = array();
		/** @var TreeItemInterface $object */
		foreach ($objects as $object) {
			$flatObjects[$object->getUid()] = array(
				'item' => $object,
				'parent' => ($object->getParent()) ? $object->getParent()->getUid() : NULL
			);
		}
		// If leaves are selected without its parents selected, those are shown as parent
		foreach ($flatObjects as $id => &$flatObject) {
			if (!isset($flatObjects[$flatObject['parent']])) {
				$flatObject['parent'] = NULL;
			}
		}
		foreach ($flatObjects as $id => &$node) {
			if ($node['parent'] === NULL) {
				$tree[$id] = &$node;
			} else {
				$flatObjects[$node['parent']]['children'][$id] = &$node;
			}
		}

		return $tree;
	}

	/**
	 * @param array $objectTree
	 * @return mixed
	 */
	public function convertObjectTreeToArray($objectTree, $keysToRemove = NULL, $mapping = NULL) {
		$treeArray = array();
		foreach ($objectTree as $objectTreeItem) {
			if ($treeArrayItem = $this->convertObjectBranchToArray($objectTreeItem, $keysToRemove, $mapping)) {
				$treeArray[] = $treeArrayItem;
			}
		}

		return $treeArray;
	}

	/**
	 * @param array $objectTreeItem
	 * @return mixed
	 */
	protected function convertObjectBranchToArray($objectTreeItem, $keysToRemove = NULL, $mapping = NULL) {
		if (isset($objectTreeItem['item'])
			AND $objectTreeItem['item'] instanceof SerializableInterface
		) {
			$treeArrayItem = $this->convertObjectLeafToArray($objectTreeItem, $keysToRemove, $mapping);
			if (isset($objectTreeItem['children'])
				AND is_array($objectTreeItem['children'])
			) {
				$children = array();
				foreach ($objectTreeItem['children'] as $child) {
					$mappedChild = $this->convertObjectLeafToArray($child, $keysToRemove, $mapping);
					$children[] = $mappedChild;
				}
				$treeArrayItem['children'] = $children;
			}

			return $treeArrayItem;
		}

		return FALSE;
	}

	/**
	 * @param array $objectLeaf
	 * @param string $keysToRemove
	 * @return mixed
	 */
	protected function convertObjectLeafToArray($objectLeaf, $keysToRemove = NULL, $mapping = NULL) {
		$arrayItem = array();
		if (isset($objectLeaf['item']) AND
			$objectLeaf['item'] instanceof SerializableInterface
		) {
			$arrayItem = $objectLeaf['item']->toArray(10, $mapping);
			if ($keysToRemove) {
				$keys = explode(',', $keysToRemove);
				foreach ($keys as $key) {
					unset($arrayItem[$key]);
				}
			}
		}

		return $arrayItem;
	}
}
