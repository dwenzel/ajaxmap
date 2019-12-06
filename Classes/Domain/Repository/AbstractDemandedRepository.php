<?php

namespace DWenzel\Ajaxmap\Domain\Repository;

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

use CPSIT\GeoLocationService\Domain\Model\GeoCodableInterface;
use CPSIT\GeoLocationService\Service\GeoCoder;
use DWenzel\Ajaxmap\Domain\Model\Dto\DemandInterface;
use DWenzel\Ajaxmap\Domain\Model\TreeItemInterface;
use DWenzel\Ajaxmap\Service\ChildrenService;
use ReflectionClass;
use ReflectionException;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException;
use TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper;
use TYPO3\CMS\Extbase\Persistence\Generic\Qom\Constraint;
use TYPO3\CMS\Extbase\Persistence\Generic\QueryResult;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Abstract demanded repository
 * Implementation based on Georg Ringer's news Extension.
 */
abstract class AbstractDemandedRepository
    extends Repository
{
    /**
     * @var ChildrenService
     */
    protected $childrenService;

    /**
     * @var GeoCoder
     */
    protected $geoCoder;

    /**
     * @param ChildrenService $childrenService
     */
    public function injectChildrenService(ChildrenService $childrenService)
    {
        $this->childrenService = $childrenService;
    }

    /**
     * @param GeoCoder $geoCoder
     */
    public function injectGeoCoder(GeoCoder $geoCoder)
    {
        $this->geoCoder = $geoCoder;
    }

    /**
     * Returns the objects of this repository matching the demand.
     *
     * @param DemandInterface $demand
     * @param boolean $respectEnableFields
     * @param array $enableFieldsToIgnore
     * @param bool $respectStoragePage
     * @return QueryResultInterface
     * @throws InvalidQueryException
     */
    public function findDemanded(DemandInterface $demand, $respectEnableFields = true, $enableFieldsToIgnore = NULL, $respectStoragePage = true)
    {
        $query = $this->generateQuery($demand, $respectEnableFields, $enableFieldsToIgnore, $respectStoragePage);
        $objects = $query->execute();
        if ($objects->count() &&
            $demand->getRadius() &&
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
     * Generates a query from a given demand
     *
     * @param DemandInterface $demand
     * @param bool $respectEnableFields
     * @param array $enableFieldsToIgnore
     * @param $respectStoragePage
     * @return QueryInterface
     */
    protected function generateQuery(
        DemandInterface $demand,
        $respectEnableFields = true,
        $enableFieldsToIgnore = null,
        $respectStoragePage
    )
    {
        $query = $this->createQuery();
        $constraints = $this->createConstraintsFromDemand($query, $demand);

        $query->getQuerySettings()->setRespectStoragePage($respectStoragePage);

        if ($respectEnableFields === false
            AND $enableFieldsToIgnore !== NULL) {
            $query->getQuerySettings()
                ->setIgnoreEnableFields(true)
                ->setEnableFieldsToBeIgnored($enableFieldsToIgnore);
        } else {
            /**
             * we set deleted and hidden to 0 here
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
            $query->setLimit((int)$demand->getLimit());
        }

        if ($demand->getOffset() != NULL) {
            $query->setOffset((int)$demand->getOffset());
        }

        return $query;
    }

    /**
     * Returns an array of constraints created from a given demand object.
     *
     * @param QueryInterface $query
     * @param DemandInterface $demand
     * @return array
     * @abstract
     */
    abstract protected function createConstraintsFromDemand(QueryInterface $query, DemandInterface $demand);

    /**
     * Returns an array of orderings created from a given demand object.
     *
     * @param DemandInterface $demand
     * @return array
     */
    protected function createOrderingsFromDemand(DemandInterface $demand)
    {
        $orderings = array();

        if ($demand->getOrderings()) {
            $orderList = GeneralUtility::trimExplode(',', $demand->getOrderings(), true);

            if (!empty($orderList)) {
                // go through every order statement
                foreach ($orderList as $orderItem) {
                    list($orderField, $ascDesc) = GeneralUtility::trimExplode('|', $orderItem, true);
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
     * Returns a query result filtered by radius around a given location
     *
     * @param QueryResult $queryResult A query result containing objects
     * @param array $geoLocation An array describing a geolocation by lat and lng
     * @param integer $distance Distance in meter
     * @return QueryResultInterface $queryResult A query result containing objects
     * @throws InvalidQueryException
     */
    public function filterByRadius($queryResult, $geoLocation, $distance)
    {
        $objectUids = [];
        foreach ($queryResult as $object) {
            $currDist = $this->calculateDistance($geoLocation, $object);
            if ($currDist <= $distance) {
                $objectUids[] = $object->getUid();
            }
        }
        if ((bool)$objectUids) {
            $orderings = $queryResult->getQuery()->getOrderings();
            $sortField = array_shift(array_keys($orderings));
            $sortOrder = array_shift(array_values($orderings));
            return $this->findMultipleByUid(
                implode(',', $objectUids), $sortField, $sortOrder, false
            );

        }

        // return empty QueryResult from empty query
        return $this->objectManager->get(QueryResultInterface::class, $this->createQuery());
    }

    /**
     * Returns multiple records by uid sorted by a given field and order.
     *
     * @param string $recordList A comma separated list of uids
     * @param string $sortField Field to sort by
     * @param string|QueryInterface $sortOrder
     * @param bool $respectStoragePage
     * @return QueryResultInterface
     * @throws InvalidQueryException
     */
    public function findMultipleByUid($recordList, $sortField = 'uid', $sortOrder = QueryInterface::ORDER_ASCENDING, $respectStoragePage = true)
    {
        $uids = GeneralUtility::intExplode(',', $recordList, true);
        $query = $this->createQuery();
        if (!$respectStoragePage) {
            $query->getQuerySettings()->setRespectStoragePage(false);
        }
        $query->matching($query->in('uid', $uids));
        $query->setOrderings(array($sortField => $sortOrder));

        return $query->execute();
    }

    /**
     * Finds children for a given list of uid.
     * The repository object must implement the TreeItemInterface.
     *
     * @param string $rootIdList Comma separated list of ids. By default this objects will be returned too.
     * @param bool $respectStoragePage
     * @param bool $removeGivenIdListFromResult
     * @return QueryResultInterface | NULL
     * @throws ReflectionException
     * @throws InvalidQueryException
     */
    public function findChildren($rootIdList, $respectStoragePage = true, $removeGivenIdListFromResult = false)
    {
        $objectClass = new ReflectionClass($this->objectType);
        if ($objectClass->implementsInterface(TreeItemInterface::class)) {
            $idList = $this->childrenService->getChildren(
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

    /**
     * Return the current tablename
     *
     * @return string
     */
    protected function getTableName()
    {
        /** @var DataMapper $dataMapper */
        $dataMapper = $this->objectManager->get(DataMapper::class);
        return $dataMapper->convertClassNameToTableName($this->objectType);
    }

    /**
     * Returns the total number objects of this repository matching the demand.
     *
     * @param DemandInterface $demand
     * @return int
     */
    public function countDemanded(DemandInterface $demand)
    {
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
     * @param array $geoLocation
     * @param GeoCodableInterface $object
     * @return float
     */
    public function calculateDistance(array $geoLocation, GeoCodableInterface $object): float
    {
        $distance = $this->geoCoder->distance(
            $geoLocation['lat'],
            $geoLocation['lng'],
            $object->getLatitude(),
            $object->getLongitude()
        );
        return $distance;
    }
}

