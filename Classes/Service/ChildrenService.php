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
use TYPO3\CMS\Core\Cache\Exception\NoSuchCacheException;
use TYPO3\CMS\Core\TimeTracker\TimeTracker;
use Doctrine\DBAL\Connection;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use DWenzel\Ajaxmap\Configuration\SettingsInterface as SI;

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
class ChildrenService
{
    /** @var FrontendInterface */
    protected $cache;

    /**
     * ChildrenService constructor.
     * @throws NoSuchCacheException
     */
    public function __construct()
    {
        $this->cache = GeneralUtility::makeInstance(CacheManager::class)
            ->getCache(SI::CACHE_CHILDREN);
    }

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
    public function getChildren($tableName, $idList, $counter = 0, $additionalWhere = '', $removeGivenIdListFromResult = false): string
    {
        $cacheIdentifier = sha1($tableName . $idList . $additionalWhere . (int)$removeGivenIdListFromResult);

        $entry = $this->cache->get($cacheIdentifier);
        if (!$entry ) {
            $entry = $this->getChildrenRecursive($tableName, $idList, $counter, $additionalWhere);
            if ($removeGivenIdListFromResult) {
                $entry = $this->removeValuesFromString($entry, $idList);
            }
            $this->cache->set($cacheIdentifier, $entry);
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
    public function removeValuesFromString($result, $toBeRemoved): string
    {
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
    private function getChildrenRecursive($tableName, $idList, $counter = 0, $additionalWhere = ''): string
    {
        /** @var QueryBuilder $queryBuilder */
        $result = [];

        // add id list to the output too
        if ($counter === 0) {
            $result[] = $idList;
        }
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable($tableName);

        $idParameter = $queryBuilder->createNamedParameter(
            explode(',', $idList),
            Connection::PARAM_INT_ARRAY
        );
        $res = $queryBuilder->select('uid')
            ->from($tableName)
            ->where(
                $queryBuilder->expr()->in('parent', $idParameter)
            )
            ->executeQuery();

        while ($row = $res->fetch()) {
            $counter++;
            if ($counter > 10000) {
                GeneralUtility::makeInstance(TimeTracker::class)->setTSlogMessage('EXT:ajaxmap: one or more recursive objects where found');
                return implode(',', $result);
            }
            $children = $this->getChildrenRecursive($tableName, $row['uid'], $counter, $additionalWhere);
            $result[] = $row['uid'] . ($children ? ',' . $children : '');
        }
        $result = implode(',', $result);
        return $result;
    }

}
