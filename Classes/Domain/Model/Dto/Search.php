<?php

namespace DWenzel\Ajaxmap\Domain\Model\Dto;

use DWenzel\Ajaxmap\DomainObject\NullableInterface;

/***************************************************************
 *  Copyright notice
 *  (c) 2013 Dirk Wenzel <wenzel@webfox01.de>
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

/**
 * Search object for searching text in fields
 */
class Search implements LocationAwareInterface, NullableInterface
{
    use LocationAwareTrait;
    /**
     * Basic search word
     *
     * @var string
     */
    protected $subject = '';

    /**
     * Search fields
     *
     * @var string
     */
    protected $fields = '';

    /**
     * @var bool
     */
    protected $forceResult = false;

    /**
     * Get the subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set subject
     *
     * @param string $subject
     * @return void
     */
    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    /**
     * Get fields
     *
     * @return string A comma separated list of search fields
     */
    public function getFields():string
    {
        return $this->fields;
    }

    /**
     * Set fields
     *
     * @param string $fields A comma separated list of search fields
     * @return void
     */
    public function setFields(string $fields): void
    {
        $this->fields = $fields;
    }

    /**
     * @return bool
     */
    public function isForceResult(): bool
    {
        return $this->forceResult;
    }

    /**
     * @param bool $forceResult
     * @return self
     */
    public function setForceResult(bool $forceResult): self
    {
        $this->forceResult = $forceResult;
        return $this;
    }

    /**
     * Check whether the current object is empty.
     *
     * @param bool $strict `true` whether to strictly check if object is empty, `false` otherwise (default)
     * @return bool `true` if the object is empty, `false` otherwise
     */
    public function isEmpty(bool $strict = false): bool
    {
        if ($strict) {
            $result = empty($this->getRadius()) && empty($this->getBounds());
        } else {
            $result = true;
        }

        return $result
            && empty($this->getLocation())
            && empty($this->getSubject())
            && empty($this->getRegion());
    }
}

