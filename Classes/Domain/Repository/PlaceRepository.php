<?php

namespace DWenzel\Ajaxmap\Domain\Repository;
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

use DWenzel\Ajaxmap\Configuration\SettingsInterface as SI;
use DWenzel\Ajaxmap\Domain\Model\Dto\DemandInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException;
use TYPO3\CMS\Extbase\Persistence\Generic\Qom\ConstraintInterface;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

/**
 * Class PlaceRepository
 */
class PlaceRepository extends AbstractDemandedRepository
{

    protected $defaultOrderings = [
        'title' => QueryInterface::ORDER_ASCENDING
    ];

    /**
     * Returns an array of query constraints from a given demand object
     *
     * @param QueryInterface $query A query object
     * @param DemandInterface $demand A demand object
     * @return array<ConstraintInterface>
     * @throws InvalidQueryException
     */
    protected function createConstraintsFromDemand(QueryInterface $query, DemandInterface $demand)
    {
        $constraints = [];
        $categories = $demand->getCategories();
        $categoryConjunction = $demand->getCategoryConjunction();

        // Category constraints
        if ($categories && !empty($categoryConjunction)) {

            // @todo get subcategories ($demand->getIncludeSubCategories())
            $constraints[] = $this->createCategoryConstraint(
                $query,
                $categories,
                $categoryConjunction,
                false
            );
        }
        $constraintsConjunction = $demand->getConstraintsConjunction();
        // Location type constraints
        if ($demand->getLocationTypes()) {
            $locationTypes = GeneralUtility::intExplode(',', $demand->getLocationTypes());
            $locationTypeConstraints = array();
            foreach ($locationTypes as $locationType) {
                $locationTypeConstraints[] = $query->equals('locationType', $locationType);
            }

            if (count($locationTypeConstraints)) {
                switch ($constraintsConjunction) {
                    case SI::CONJUNCTION_OR:
                        $constraints[] = $query->logicalOr($locationTypeConstraints);
                        break;
                    case SI::CONJUNCTION_AND:
                    default:
                        $constraints[] = $query->logicalAnd($locationTypeConstraints);
                }
            }
        }

        // Search constraints
        if ($demand->getSearch()) {
            $searchConstraints = [];
            $search = $demand->getSearch();
            $subject = $search->getSubject();

            if (!empty($subject)) {
                // search text in specified search fields
                $searchFields = GeneralUtility::trimExplode(',', $search->getFields(), true);
                if (count($searchFields) === 0) {
                    throw new \UnexpectedValueException('No search fields given', 1382608407);
                }
                foreach ($searchFields as $field) {
                    $searchConstraints[] = $query->like($field, '%' . $subject . '%');
                }
            }


            if ((bool)$searchConstraints) {
                $constraints[] = $query->logicalOr($searchConstraints);
            }
        }

        return $constraints;
    }

    /**
     * Returns an array of orderings created from a given demand object.
     *
     * @param DemandInterface $demand
     * @return array<\TYPO3\CMS\Extbase\Persistence\Generic\Qom\Constraint>
     */
    protected function createOrderingsFromDemand(DemandInterface $demand)
    {
        $orderings = array();

        //@todo validate order (orderAllowed) use getOrderings instead or extend AbstractDemandedRepository
        if ($demand->getOrder()) {
            $orderList = GeneralUtility::trimExplode(',', $demand->getOrder(), true);

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

}

