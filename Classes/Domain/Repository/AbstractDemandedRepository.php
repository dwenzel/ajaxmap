<?php
namespace Webfox\Ajaxmap\Domain\Repository;

	/***************************************************************
	 *  Copyright notice
	 *  (c) 2010 Georg Ringer
	 *  (c) 2014 Dirk Wenzel <wenzel@webfox01.de>, Agentur Webfox
	 *  All rights reserved
	 *  This script is part of the TYPO3 project. The TYPO3 project is
	 *  free software; you can redistribute it and/or modify
	 *  it under the terms of the GNU General Public License as published by
	 *  the Free Software Foundation; either version 2 of the License, or
	 *  (at your option) any later version.
	 *  The GNU General Public License can be found at
	 *  http://www.gnu.org/copyleft/gpl.html.
	 *  This script is distributed in the hope that it will be useful,
	 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
	 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	 *  GNU General Public License for more details.
	 *  This copyright notice MUST APPEAR in all copies of the script!
	 ***************************************************************/

use TYPO3\CMS\Extbase\DomainObject\DomainObjectInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Webfox\Ajaxmap\Domain\Model\Dto\DemandInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy;
use Webfox\Ajaxmap\Service\ChildrenService;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

/**
 * Abstract demanded repository
 * Implementation based on Georg Ringer's news Extension.
 *
 * @package placements
 * @author Dirk Wenzel <wenzel@webfox01.de>
 */
abstract class AbstractDemandedRepository
	extends Repository {

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\Generic\Storage\Typo3DbBackend
	 * @inject
	 */
	protected $storageBackend;

	/**
	 * Returns an array of constraints created from a given demand object.
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
	 * @param \Webfox\Ajaxmap\Domain\Model\Dto\DemandInterface $demand
	 * @return array<\TYPO3\CMS\Extbase\Persistence\Generic\Qom\Constraint>
	 * @abstract
	 */
	abstract protected function createConstraintsFromDemand(QueryInterface $query, DemandInterface $demand);

	/**
	 * Returns an array of orderings created from a given demand object.
	 *
	 * @param \Webfox\Ajaxmap\Domain\Model\Dto\DemandInterface $demand
	 * @return \array<\TYPO3\CMS\Extbase\Persistence\Generic\Qom\Constraint>
	 */
	protected function createOrderingsFromDemand(DemandInterface $demand) {
		$orderings = array();

		if ($demand->getOrderings()) {
			$orderList = GeneralUtility::trimExplode(',', $demand->getOrderings(), TRUE);

			if (!empty($orderList)) {
				// go through every order statement
				foreach ($orderList as $orderItem) {
					list($orderField, $ascDesc) = GeneralUtility::trimExplode('|', $orderItem, TRUE);
					// count == 1 means that no direction is given
					if ($ascDesc) {
						$orderings[$orderField] = ((strtolower($ascDesc) == 'desc') ?
							QueryInterface::ORDER_DESCENDING :
							QueryInterface::ORDER_ASCENDING);
					} else {
						$orderings[$orderField] = QueryInterface::ORDER_ASCENDING;
					}
				}
			}
		}

		return $orderings;
	}

	/**
	 * Returns the objects of this repository matching the demand.
	 *
	 * @param \Webfox\Ajaxmap\Domain\Model\Dto\DemandInterface $demand
	 * @param boolean $respectEnableFields
	 * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface
	 */
	public function findDemanded(DemandInterface $demand, $respectEnableFields = TRUE) {
		$query = $this->generateQuery($demand, $respectEnableFields);
		$objects = $query->execute();
		if ($objects->count() AND
			$demand->getRadius() AND
			$demand->getGeoLocation()
		) {
			$objects = $this->filterByRadius($objects,
				$demand->getGeoLocation(),
				$demand->getRadius() / 1000
			);
		}

		return $objects;
	}

	/**
	 * Returns a query result filtered by radius around a given location
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult $queryResult A query result containing objects
	 * @param \array $geoLocation An array describing a geolocation by lat and lng
	 * @param \integer $distance Distance in meter
	 * @return \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult $queryResult A query result containing objects
	 */
	public function filterByRadius($queryResult, $geoLocation, $distance) {
		$objectUids = array();
		foreach ($queryResult as $object) {
			$currDist = \Webfox\Ajaxmap\Utility\Geocoder::distance(
				$geoLocation['lat'],
				$geoLocation['lng'],
				$object->getLatitude(),
				$object->getLongitude()
			);
			if ($currDist <= $distance) {
				$objectUids[] = $object->getUid();
			}
		}
		$orderings = $queryResult->getQuery()->getOrderings();
		$sortField = array_shift(array_keys($orderings));
		$sortOrder = array_shift(array_values($orderings));
		$objects = self::findMultipleByUid(
			implode(',', $objectUids), $sortField, $sortOrder
		);

		return $objects;
	}

	/**
	 * Returns the database query to get the matching result
	 *
	 * @param \Webfox\Ajaxmap\Domain\Model\Dto\DemandInterface $demand
	 * @param boolean $respectEnableFields
	 * @return string
	 */
	public function findDemandedRaw(DemandInterface $demand, $respectEnableFields = TRUE) {
		$query = $this->generateQuery($demand, $respectEnableFields);
		$queryParser = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Storage\\Typo3DbQueryParser');
		list($hash, $parameters) = $queryParser->preparseQuery($query);
		$statementParts = $queryParser->parseQuery($query);

		// Limit and offset are not cached to allow caching of pagebrowser queries.
		$statementParts['limit'] = ((int) $query->getLimit() ?: NULL);
		$statementParts['offset'] = ((int) $query->getOffset() ?: NULL);

		$tableNameForEscape = (reset($statementParts['tables']) ?: 'foo');
		foreach ($parameters as $parameterPlaceholder => $parameter) {
			if ($parameter instanceof LazyLoadingProxy) {
				$parameter = $parameter->_loadRealInstance();
			}

			if ($parameter instanceof \DateTime) {
				$parameter = $parameter->format('U');
			} elseif ($parameter instanceof DomainObjectInterface) {
				$parameter = (int) $parameter->getUid();
			} elseif (is_array($parameter)) {
				$subParameters = array();
				foreach ($parameter as $subParameter) {
					$subParameters[] = $GLOBALS['TYPO3_DB']->fullQuoteStr($subParameter, $tableNameForEscape);
				}
				$parameter = implode(',', $subParameters);
			} elseif ($parameter === NULL) {
				$parameter = 'NULL';
			} elseif (is_bool($parameter)) {
				return ($parameter === TRUE ? 1 : 0);
			} else {
				$parameter = $GLOBALS['TYPO3_DB']->fullQuoteStr((string) $parameter, $tableNameForEscape);
			}

			$statementParts['where'] = str_replace($parameterPlaceholder, $parameter, $statementParts['where']);
		}

		$statementParts = array(
			'selectFields' => implode(' ', $statementParts['keywords']) . ' ' . implode(',', $statementParts['fields']),
			'fromTable' => implode(' ', $statementParts['tables']) . ' ' . implode(' ', $statementParts['unions']),
			'whereClause' => (!empty($statementParts['where']) ? implode('', $statementParts['where']) : '1')
				. (!empty($statementParts['additionalWhereClause'])
					? ' AND ' . implode(' AND ', $statementParts['additionalWhereClause'])
					: ''
				),
			'orderBy' => (!empty($statementParts['orderings']) ? implode(', ', $statementParts['orderings']) : ''),
			'limit' => ($statementParts['offset'] ? $statementParts['offset'] . ', ' : '')
				. ($statementParts['limit'] ? $statementParts['limit'] : '')
		);

		$sql = $GLOBALS['TYPO3_DB']->SELECTquery(
			$statementParts['selectFields'],
			$statementParts['fromTable'],
			$statementParts['whereClause'],
			'',
			$statementParts['orderBy'],
			$statementParts['limit']
		);

		return $sql;
	}

	/**
	 * Return the current tablename
	 *
	 * @return string
	 */
	protected function getTableName() {
		/** @var DataMapper $dataMapper */
		$dataMapper = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Mapper\\DataMapper');
		return $dataMapper->convertClassNameToTableName($this->objectType);
	}

	/**
	 * Returns multiple records by uid sorted by a given field and order.
	 *
	 * @param \string $recordList A comma separated list of uids
	 * @param \string $sortField Field to sort by
	 * @param string|QueryInterface $sortOrder
	 * @param bool $respectStoragePage
	 * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface
	 */
	public function findMultipleByUid($recordList, $sortField = 'uid', $sortOrder = QueryInterface::ORDER_ASCENDING, $respectStoragePage = TRUE) {
		$uids = GeneralUtility::intExplode(',', $recordList, TRUE);
		$query = $this->createQuery();
		if (!$respectStoragePage) {
			$query->getQuerySettings()->setRespectStoragePage(FALSE);
		}
		$query->matching($query->in('uid', $uids));
		$query->setOrderings(array($sortField => $sortOrder));

		return $query->execute();
	}

	protected function generateQuery(\Webfox\Ajaxmap\Domain\Model\Dto\DemandInterface $demand, $respectEnableFields = TRUE) {
	/**
	 * Finds children for a given list of uid.
	 * The repository object must implement the TreeItemInterface.
	 *
	 * @param string $rootIdList Comma separated list of ids. By default this objects will be returned too.
	 * @param bool $respectStoragePage
	 * @param bool $removeGivenIdListFromResult
	 * @return QueryResultInterface | NULL
	 */
	public function findChildren($rootIdList, $respectStoragePage = TRUE, $removeGivenIdListFromResult = FALSE) {
		$objectClass = new \ReflectionClass($this->objectType);
		if ($objectClass->implementsInterface('Webfox\\Ajaxmap\\Domain\\Model\\TreeItemInterface')) {
			$idList = ChildrenService::getChildren(
				$this->getTableName(),
				$rootIdList,
				0,
				'',
				$removeGivenIdListFromResult
			);

			return $this->findMultipleByUid(
				$idList,
				'uid',
				QueryInterface::ORDER_ASCENDING,
				$respectStoragePage
			);
		}
		return NULL;
	}

		$query = $this->createQuery();
		$constraints = $this->createConstraintsFromDemand($query, $demand);

		/**
		 * We have to get the storage pages here and set the constraint by pid
		 * in order to avoid records from wrong storage pages from being displayed. 
		 * For some reasons the persistence manager does not respect the correct
		 * storage page settings in our ajaxListAction from PositionController (but it
		 * does for the plugin settings).
		 */
		$constraints[] = $query->in('pid', $query->getQuerySettings()->getStoragePageIds());

		if ($respectEnableFields === FALSE) {
			$query->getQuerySettings()->setRespectEnableFields(FALSE);
		} else {
			/**
			 * @todo  we set deleted and hidden to 0 here 
			 * because otherwise our ajax action
			 * will return those records too! 
			 * (Seems the enable fields are not
			 * respected properly.)
			 */
			$constraints[] = $query->equals('deleted', 0);
			$constraints[] = $query->equals('hidden', 0);
		}

		if (!empty($constraints)) {
			$query->matching(
				$query->logicalAnd($constraints)
			);
		}

		if ($orderings = $this->createOrderingsFromDemand($demand)) {
			$query->setOrderings($orderings);
		}

		if ($demand->getLimit() != NULL) {
			$query->setLimit((int) $demand->getLimit());
		}

		if ($demand->getOffset() != NULL) {
			$query->setOffset((int) $demand->getOffset());
		}

		return $query;
	}

	/**
	 * Returns the total number objects of this repository matching the demand.
	 *
	 * @param \Webfox\Ajaxmap\Domain\Model\Dto\DemandInterface $demand
	 * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface
	 */
	public function countDemanded(\Webfox\Ajaxmap\Domain\Model\Dto\DemandInterface $demand) {
		$query = $this->createQuery();

		if ($constraints = $this->createConstraintsFromDemand($query, $demand)) {
			$query->matching(
				$query->logicalAnd($constraints)
			);
		}

		$result = $query->execute();
		return $result->count();
	}

	/**
	 * Copy of the one from Typo3DbBackend
	 * Replace query placeholders in a query part by the given
	 * parameters.
	 *
	 * @param string $sqlString The query part with placeholders
	 * @param array $parameters The parameters
	 * @param string $tableName
	 *
	 * @throws \TYPO3\CMS\Extbase\Persistence\Generic\Exception
	 * @return void
	 */
	protected function replacePlaceholders(&$sqlString, array $parameters, $tableName = 'foo') {
		if (substr_count($sqlString, '?') !== count($parameters)) {
			throw new \TYPO3\CMS\Extbase\Persistence\Generic\Exception('The number of question marks to replace must be equal to the number of parameters.', 1242816074);
		}
		$offset = 0;
		foreach ($parameters as $parameter) {
			$markPosition = strpos($sqlString, '?', $offset);
			if ($markPosition !== FALSE) {
				if ($parameter === NULL) {
					$parameter = 'NULL';
				} elseif (is_array($parameter) || $parameter instanceof \ArrayAccess || $parameter instanceof \Traversable) {
					$items = array();
					foreach ($parameter as $item) {
						$items[] = $GLOBALS['TYPO3_DB']->fullQuoteStr($item, $tableName);
					}
					$parameter = '(' . implode(',', $items) . ')';
				} else {
					$parameter = $GLOBALS['TYPO3_DB']->fullQuoteStr($parameter, $tableName);
				}
				$sqlString = substr($sqlString, 0, $markPosition) . $parameter . substr($sqlString, ($markPosition + 1));
			}
			$offset = $markPosition + strlen($parameter);
		}
	}
}
?>
