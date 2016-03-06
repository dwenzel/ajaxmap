<?php
namespace Webfox\Ajaxmap\Domain\Model;

/**
 * Class ToJsonTrait
 *
 * @package Webfox\Ajaxmap\Domain\Model
 */
trait ToJsonTrait {
	/**
	 * Returns an array representation of the object
	 *
	 * @param integer $treeDepth maximum tree depth
	 * @param array $mapping An array with keys for each model
	 * which should be mapped.
	 * @return array
	 */
	abstract public function toArray($treeDepth = 100, $mapping = NULL);
	/**
	 * Returns a JSON representation of the object
	 *
	 * @return string
	 */
	public function toJson() {
		return json_encode($this->toArray());
	}
}
