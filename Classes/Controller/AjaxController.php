<?php

namespace DWenzel\Ajaxmap\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2019 Dirk Wenzel
 *  All rights reserved
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the text file GPL.txt and important notices to the license
 * from the author is found in LICENSE.txt distributed with these scripts.
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use DWenzel\Ajaxmap\Configuration\SettingsInterface as SI;
use DWenzel\Ajaxmap\Data\ProviderFactory;
use DWenzel\Ajaxmap\Traits\ObjectManagerTrait;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Cache\Exception\NoSuchCacheException;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Core\Bootstrap;
use TYPO3\CMS\Extbase\Object\ObjectManager;

/**
 * Class AjaxController
 */
class AjaxController
{
    use ObjectManagerTrait;

    const PLUGIN_CONFIGURATION = [
        'extensionName' => SI::EXTENSION_NAME,
        'pluginName' => 'Map',
        'vendorName' => SI::VENDOR_NAME,
        'controller' => 'Map',
        'action' => 'show'
    ];

    const VALID_PARAMETERS = [
        SI::API_PARAMETER_ACTION,
        SI::API_PARAMETER_MAP_ID,
        SI::API_PARAMETER_NO_CACHE,
        SI::ID
    ];

    /**
     * @var array
     */
    protected $responseArray = [
        'hasErrors' => false,
        'message' => ''
    ];


    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws NoSuchCacheException
     */
    public function processRequest(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $this->initializeLanguage();
        $this->initializeFramework();

        $queryParams = $this->purgeParameters($request);

        array_multisort($queryParams);
        $cacheIdentifier = md5(json_encode($queryParams));

        /** @var FrontendInterface $dataCache */
        $dataCache = GeneralUtility::makeInstance(CacheManager::class)->getCache(SI::CACHE_AJAX_DATA);

        if (($data = $dataCache->get($cacheIdentifier)) === false) {
            $action = isset($queryParams[SI::API_PARAMETER_ACTION]) ? $queryParams[SI::API_PARAMETER_ACTION] : '';

            $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
            $providerFactory = $objectManager->get(ProviderFactory::class);
            $dataProvider = $providerFactory->get($action);

            $data = $dataProvider->get($queryParams);
            $dataCache->set($cacheIdentifier, $data);
        }
        $this->responseArray = $data;

        $this->prepareResponse($response);
        return $response;
    }

    /**
     * @return void
     */
    protected function initializeLanguage(): void
    {
        if (!isset($GLOBALS['LANG']) || !is_object($GLOBALS['LANG'])) {
            $GLOBALS['LANG'] = GeneralUtility::makeInstance(LanguageService::class);
            $GLOBALS['LANG']->init('default');
        }
    }

    protected function initializeFramework(): void
    {
        /** @var Bootstrap $bootstrap */
        $bootstrap = GeneralUtility::makeInstance(Bootstrap::class);
        /**
         * initialize framework with default plugin configuration
         * this ensures proper configuration even though we do not use
         * this plugin
         */
        $bootstrap->initialize(static::PLUGIN_CONFIGURATION);
    }

    protected function purgeParameters(ServerRequestInterface $request): array
    {
        $apiParams = [];
        $queryParams = $request->getQueryParams();
        foreach ($queryParams as $key => $param) {
            if (in_array($key, static::VALID_PARAMETERS)) {
                $apiParams[$key] = $param;
            }
        }

        return $apiParams;
    }

    /**
     * @param ResponseInterface $response
     * @return void
     */
    protected function prepareResponse(ResponseInterface &$response): void
    {
        $response = $response->withHeader('Content-Type', 'application/json; charset=utf-8');
        $response->getBody()->write(json_encode($this->responseArray));
    }
}
