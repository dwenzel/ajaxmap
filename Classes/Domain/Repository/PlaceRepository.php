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
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
/**
 *
 *
 * @package ajaxmap
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class PlaceRepository extends AbstractDemandedRepository {
    /**
    *@param string $where
    */
    public function findRawSelectWhere($select, $where){
    	$statement = 'SELECT ' .$select .' from tx_ajaxmap_domain_model_place WHERE ' . $where;
    	$query = $this->createQuery();
		$query->getQuerySettings()->setReturnRawQueryResult(true);
		$query->statement($statement);
		return $query->execute();
    }

	public function findCategoriesForPlace($placeId){
		$statement = 'SELECT categories.uid, categories.title '
			.' FROM tx_ajaxmap_domain_model_place AS places '
			.'LEFT JOIN tx_ajaxmap_place_category_mm AS mm '
			.'ON (places.uid = mm.uid_local) '
			.'LEFT JOIN sys_category AS categories '
			.'ON (mm.uid_foreign = categories.uid) '
			.'WHERE places.categories AND categories.uid AND places.uid=' .$placeId;
		$query = $this->createQuery();
		$query->getQuerySettings()->setReturnRawQueryResult(true);
		$query->statement($statement);
		return $query->execute();
	}

	/**
	 * @param integer $placeId
	 * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
	 */
    public function findPlaceGroupsForPlace($placeId){
        $statement = 'SELECT placeGroups.uid, placeGroups.title '
        .' FROM tx_ajaxmap_domain_model_place AS places '
        .'LEFT JOIN tx_ajaxmap_place_placegroup_mm AS mm '
        .'ON (places.uid = mm.uid_local) '
        .'LEFT JOIN tx_ajaxmap_domain_model_placegroup AS placeGroups '
        .'ON (mm.uid_foreign = placeGroups.uid) '
        .'WHERE places.place_groups AND placeGroups.uid AND places.uid=' .$placeId;
        $query = $this->createQuery();
        $query->getQuerySettings()->setReturnRawQueryResult(true);
        $query->statement($statement);
        return $query->execute();
    }

	/**
	 * @param integer $placeId
	 * @return array | NULL
	 */
	public function findAddressForPlace($placeId){
        $statement = 'SELECT * 
             FROM tt_address AS address '
        .'LEFT JOIN tx_ajaxmap_domain_model_place AS place '
        .'ON (place.address= address.uid) '
        . 'WHERE place.uid='.$placeId;
        $query = $this->createQuery();
        $query->getQuerySettings()->setReturnRawQueryResult(true);
        $query->statement($statement);
        if ($result = $query->execute()) {
			return $result[0];
		}
		return NULL;
    }

	/**
	 * Returns an array of query constraints from a given demand object
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query A query object
	 * @param \DWenzel\Ajaxmap\Domain\Model\Dto\DemandInterface $demand A demand object
	 * @return \array<\TYPO3\CMS\Extbase\Persistence\Generic\Qom\Constraint>
	 */
	protected function createConstraintsFromDemand (\TYPO3\CMS\Extbase\Persistence\QueryInterface $query, \DWenzel\Ajaxmap\Domain\Model\Dto\DemandInterface $demand) {
		$constraints = array();
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
					case 'or':
						$constraints[] = $query->logicalOr($locationTypeConstraints);
						break;
					case 'and':
					default:
						$constraints[] = $query->logicalAnd($locationTypeConstraints);
				}
			}
		}



		// Search constraints
		if ($demand->getSearch()) {
			$searchConstraints = array();
			$locationConstraints = array();
			$search = $demand->getSearch();
			$subject = $search->getSubject();

			if(!empty($subject)) {
				// search text in specified search fields
				$searchFields = GeneralUtility::trimExplode(',', $search->getFields(), true);
				if (count($searchFields) === 0) {
					throw new \UnexpectedValueException('No search fields given', 1382608407);
				}
				foreach($searchFields as $field) {
					$searchConstraints[] = $query->like($field, '%' . $subject . '%');
				}
			}

			// search by bounding box
			$bounds = $search->getBounds();
			$location = $search->getLocation();
			$radius = $search->getRadius();

			if(!empty($location)
					AND !empty($radius)
					AND empty($bounds)) {
					$geoCoder = new \DWenzel\Ajaxmap\Utility\Geocoder;
					$geoLocation = $geoCoder::getLocation($location);
					if ($geoLocation) {
						$bounds = $geoCoder::getBoundsByRadius($geoLocation['lat'], $geoLocation['lng'], $radius/1000);
					}
			}
			if($bounds AND
					!empty($bounds['N']) AND
					!empty($bounds['S']) AND
					!empty($bounds['W']) AND
					!empty($bounds['E'])) {
						$locationConstraints[] = $query->greaterThan('latitude', $bounds['S']['lat']);
						$locationConstraints[] = $query->lessThan('latitude', $bounds['N']['lat']);
						$locationConstraints[] = $query->greaterThan('longitude', $bounds['W']['lng']);
						$locationConstraints[] = $query->lessThan('longitude', $bounds['E']['lng']);
			}

			if(count($searchConstraints)) {
				$constraints[] = $query->logicalOr($searchConstraints);
			}
			if(count($locationConstraints)) {
				$constraints[] = $query->logicalAnd($locationConstraints);
			}
		}

		return $constraints;
	}

	/**
	 * Returns an array of orderings created from a given demand object.
	 *
	 * @param \DWenzel\Ajaxmap\Domain\Model\Dto\DemandInterface $demand
	 * @return \array<\TYPO3\CMS\Extbase\Persistence\Generic\Qom\Constraint>
	 */
	protected function createOrderingsFromDemand(\DWenzel\Ajaxmap\Domain\Model\Dto\DemandInterface $demand) {
		$orderings = array();

		//@todo validate order (orderAllowed) use getOrderings instead or extend AbstractDemandedRepository
		if ($demand->getOrder()) {
			$orderList = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $demand->getOrder(), true);

			if (!empty($orderList)) {
				// go through every order statement
				foreach ($orderList as $orderItem) {
					list($orderField, $ascDesc) = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode('|', $orderItem, true);
					// count == 1 means that no direction is given
					if ($ascDesc) {
						$orderings[$orderField] = ((strtolower($ascDesc) == 'desc') ?
							\TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING :
							\TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING);
					} else {
						$orderings[$orderField] = \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING;
					}
				}
			}
		}

		return $orderings;
	}

}

