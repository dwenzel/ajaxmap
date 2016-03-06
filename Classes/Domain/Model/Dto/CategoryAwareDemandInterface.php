<?php
namespace Webfox\Ajaxmap\Domain\Model\Dto;

/**
 * Interface CategoryAwareDemandInterface
 *
 * @package Webfox\Ajaxmap\Domain\Model\Dto
 */
interface CategoryAwareDemandInterface {
	/**
	 * @return string
	 */
	public function getCategories();

	/**
	 * @param string $categories
	 * @return void
	 */
	public function setCategories($categories);

	/**
	 * @return string
	 */
	public function getCategoryConjunction();

	/**
	 * @param string $conjunction
	 */
	public function setCategoryConjunction($conjunction);
}
