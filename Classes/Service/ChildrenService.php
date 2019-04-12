<?php
namespace DWenzel\Ajaxmap\Service;
 /**
  * This file is part of the TYPO3 CMS project.
  *
  * It is free software; you can redistribute it and/or modify it under
  * the terms of the GNU General Public License, either version 2
  * of the License, or any later version.
  *
  * For the full copyright and license information, please read the
  * LICENSE.txt file that was distributed with this source code.
  *
  * The TYPO3 project - inspiring people to share!
  */

use TYPO3\CMS\Dbal\Database\DatabaseConnection;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * Class ChildrenService
 *
 * Gets the children of an object (recursive) The object must implement
 * the TreeItemInterface
 * (i.e. has a field uid and a field parent which contains a uid of an object)
 *
 * @author Georg Ringer (tx_news)
 * @author Dirk Wenzel
 *
 * @package DWenzel\Ajaxmap\Service
 */
class ChildrenService {
	/**
	 * Get children by calling recursive function
	 *
	 * @param string $tableName
	 * @param string $idList list of category ids to start
	 * @param integer $counter
	 * @param string $additionalWhere additional where clause
	 * @param boolean $removeGivenIdListFromResult remove the given id list from result
	 * @return string comma separated list of category ids
	 */
	public static function getChildren($tableName, $idList, $counter = 0, $additionalWhere = '', $removeGivenIdListFromResult = false) {
		// @todo implement caching (see tx_news)
		$entry = self::getChildrenRecursive($tableName, $idList, $counter, $additionalWhere);
		if ($removeGivenIdListFromResult) {
			$entry = self::removeValuesFromString($entry, $idList);
		}
		return $entry;
	}

	/**
	 * Remove values of a comma separated list from another comma separated list
	 *
	 * @param string $result string comma separated list
	 * @param $toBeRemoved string comma separated list
	 * @return string
	 */
	public static function removeValuesFromString($result, $toBeRemoved) {
		$resultAsArray = GeneralUtility::trimExplode(',', $result, true);
		$idListAsArray = GeneralUtility::trimExplode(',', $toBeRemoved, true);
		$result = implode(',', array_diff($resultAsArray, $idListAsArray));
		return $result;
	}

	/**
	 * Get children
	 *
	 * @param string $tableName
	 * @param string $idList list of category ids to start
	 * @param integer $counter
	 * @param string $additionalWhere additional where clause
	 * @return string comma separated list of category ids
	 */
	private static function getChildrenRecursive($tableName, $idList, $counter = 0, $additionalWhere = '') {
		/** @var DatabaseConnection $dataBase */
		$dataBase = $GLOBALS['TYPO3_DB'];

		$result = array();
		// add id list to the output too
		if ($counter === 0) {
			$result[] = $dataBase->cleanIntList($idList);
		}
		$res = $dataBase->exec_SELECTquery(
			'uid',
			$tableName,
			$tableName . '.parent IN (' . $dataBase->cleanIntList($idList) . ')
				AND deleted=0 ' . $additionalWhere);
		while (($row = $dataBase->sql_fetch_assoc($res))) {
			$counter++;
			if ($counter > 10000) {
				$GLOBALS['TT']->setTSlogMessage('EXT:ajaxmap: one or more recursive objects where found');
				return implode(',', $result);
			}
			$children = self::getChildrenRecursive($tableName, $row['uid'], $counter, $additionalWhere);
			$result[] = $row['uid'] . ($children ? ',' . $children : '');
		}
		$dataBase->sql_free_result($res);
		$result = implode(',', $result);
		return $result;
	}

}