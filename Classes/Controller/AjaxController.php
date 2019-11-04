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

use DWenzel\Ajaxmap\Data\ProviderFactory;
use DWenzel\Ajaxmap\Traits\ObjectManagerTrait;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

/**
 * Class AjaxController
 */
class AjaxController
{
    use ObjectManagerTrait;

    /**
     * @var array
     */
    protected $responseArray = [
        'hasErrors' => false,
        'message' => ''
    ];


    public function __construct()
    {
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
    }

    public function processRequest(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $this->initializeLanguage();

        $queryParams = $request->getQueryParams();
        $action = isset($queryParams['action']) ? $queryParams['action'] : '';

        $providerFactory = $this->objectManager->get(ProviderFactory::class);
        $dataProvider = $providerFactory->get($action);

        $this->responseArray = $dataProvider->get($queryParams);
        $this->prepareResponse($response);
        return $response;
    }

    /**
     * @return void
     */
    protected function initializeLanguage(): void
    {
        if (!isset($GLOBALS['LANG']) || !\is_object($GLOBALS['LANG'])) {
            $GLOBALS['LANG'] = GeneralUtility::makeInstance(LanguageService::class);
            $GLOBALS['LANG']->init('default');
        }
    }

    /**
     * @param ResponseInterface $response
     * @return void
     */
    protected function prepareResponse(ResponseInterface &$response): void
    {
        $response = $response->withHeader('Content-Type', 'application/json; charset=utf-8');
        $response->getBody()->write(\json_encode($this->responseArray));
    }

}
