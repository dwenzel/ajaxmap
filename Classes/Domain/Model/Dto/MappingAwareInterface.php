<?php
declare(strict_types=1);
namespace DWenzel\Ajaxmap\Domain\Model\Dto;

/*
 * This file is part of the TYPO3 CMS extension "ajaxmap".
 *
 * Copyright (C) 2019 Elias Häußler <e.haeussler@familie-redlich.de>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

/**
 * MappingAwareInterface
 *
 * @author Elias Häußler <e.haeussler@familie-redlich.de>
 * @license GPL-2.0-or-later
 */
interface MappingAwareInterface
{
    /**
     * Check whether the given property can be mapped by the given mapping configuration.
     *
     * @param string $propertyName Property to check
     * @param array $mapping Mapping configuration
     * @return bool `true` if property can be mapped, `false` otherwise
     */
    public function canPropertyBeMapped(string $propertyName, array $mapping): bool;

    /**
     * Map given property by given mapping configuration.
     *
     * @param string $propertyName Property to map
     * @param array $mapping Mapping configuration
     * @return mixed The mapped property value
     */
    public function mapProperty(string $propertyName, array $mapping);
}
