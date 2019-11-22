<?php

namespace DWenzel\Ajaxmap\Middleware;

use DWenzel\Ajaxmap\Configuration\SettingsInterface as SI;
use DWenzel\Ajaxmap\Controller\AjaxController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Http\Dispatcher;
use TYPO3\CMS\Core\Http\NullResponse;
use TYPO3\CMS\Core\Http\Response;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Core\Bootstrap;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

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

/**
 * Class FrontendJsonApiHandler
 *
 * Middleware for request to the map api
 */
class FrontendJsonApiHandler implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $api = $request->getParsedBody()['api'] ?? $request->getQueryParams()['api'] ?? null;
        if ($api === null) {
            return $handler->handle($request);
        }
        ob_clean();
        /** @var Response $response */
        $response = GeneralUtility::makeInstance(Response::class);

        // for now we dispatch only to this single endpoint
        if ($api === SI::API_PARAMETER_MAP) {
            $requestConfiguration = AjaxController::class . '::' . 'processRequest';
            /** @var Dispatcher $dispatcher */
            $dispatcher = GeneralUtility::makeInstance(Dispatcher::class);
            $request = $request->withAttribute('target', $requestConfiguration);
            return $dispatcher->dispatch($request, $response) ?? new NullResponse();
        }

        return new NullResponse();
    }
}
