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
	 * @return array
	 */
	abstract function toArray();
	/**
	 * Returns a JSON representation of the object
	 *
	 * @return string
	 */
	public function toJson() {
		return json_encode($this->toArray());
	}
}
