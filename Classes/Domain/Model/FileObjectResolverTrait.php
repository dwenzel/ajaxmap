<?php
declare(strict_types=1);
namespace DWenzel\Ajaxmap\Domain\Model;

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

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\NormalizedParams;
use TYPO3\CMS\Core\Resource\File as CoreFile;
use TYPO3\CMS\Core\Resource\FileReference as CoreFileReference;
use TYPO3\CMS\Extbase\Domain\Model\File as ExtbaseFile;
use TYPO3\CMS\Extbase\Domain\Model\FileReference as ExtbaseFileReference;
use TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy;

/**
 * FileObjectResolverTrait
 *
 * @author Elias Häußler <e.haeussler@familie-redlich.de>
 * @license GPL-2.0-or-later
 */
trait FileObjectResolverTrait
{
    /**
     * @var array Valid file object class names
     */
    protected $_validFileObjectClassNames = [
        LazyLoadingProxy::class,
        ExtbaseFileReference::class,
        CoreFileReference::class,
        ExtbaseFile::class,
        CoreFile::class,
    ];

    /**
     * Check whether a given object can be resolved as file object.
     *
     * @param $object
     * @return bool
     */
    protected function canBeResolvedAsFileObject($object): bool
    {
        if (!is_object($object)) {
            return false;
        }

        foreach ($this->_validFileObjectClassNames as $className) {
            if (!is_a($object, $className)) {
                continue;
            }

            if (!$object instanceof LazyLoadingProxy) {
                return true;
            }

            // Compare lazy parent class name against valid file object class names
            list($lazyParentClass) = explode(':', $object->_getTypeAndUidString(), 2);
            if ($this->canBeResolvedAsFileObject($lazyParentClass)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Resolve valid file object to its public URL for serialization.
     *
     * @param mixed $fileObject
     * @param bool $absoluteUrl
     * @return string|null
     */
    protected function resolveFileObject($fileObject, bool $absoluteUrl = true): ?string
    {
        if (!$this->canBeResolvedAsFileObject($fileObject)) {
            return null;
        }

        if ($fileObject instanceof LazyLoadingProxy) {
            $fileObject->_loadRealInstance();
        }
        if ($fileObject instanceof ExtbaseFileReference) {
            $fileObject = $fileObject->getOriginalResource()->getOriginalFile();
        } else if ($fileObject instanceof CoreFileReference) {
            $fileObject->getOriginalFile();
        } else if ($fileObject instanceof ExtbaseFile) {
            $fileObject->getOriginalResource();
        } else {
            return null;
        }

        // Get public URL
        $publicUrl = $fileObject->getPublicUrl();

        // Use absolute URLs if defined
        if ($absoluteUrl && ($request = $this->getRequest())) {
            /** @var NormalizedParams $normalizedParams */
            $normalizedParams = $request->getAttribute('normalizedParams');
            $host = $normalizedParams->getRequestHost();
            $publicUrl = $host . '/' . ltrim($publicUrl, '/');
        }

        return $publicUrl;
    }

    /**
     * @return ServerRequestInterface
     */
    protected function getRequest(): ?ServerRequestInterface
    {
        return $GLOBALS['TYPO3_REQUEST'] ?? null;
    }
}
