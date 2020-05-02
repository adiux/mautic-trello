<?php

declare(strict_types=1);
/**
 * @copyright   2020 Mautic Contributors. All rights reserved
 *
 * @author      Mautic
 *
 * @see        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\Idea2TrelloBundle\Service;

use Exception;
use GuzzleHttp\Client as HttpClient;
use Mautic\CoreBundle\Helper\CoreParametersHelper;
use Mautic\PluginBundle\Helper\IntegrationHelper;
use MauticPlugin\Idea2TrelloBundle\Integration\TrelloIntegration;
use MauticPlugin\Idea2TrelloBundle\Openapi\lib\Api\DefaultApi;
use MauticPlugin\Idea2TrelloBundle\Openapi\lib\Configuration;
use Monolog\Logger;

/**
 * Provide the auto generated Trello API to the Idea2TrelloBundle.
 */
class TrelloApiService
{
    /**
     * @var bool|TrelloIntegration
     */
    protected $integration;

    /**
     * @var CoreParametersHelper
     */
    protected $coreParametersHelper;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * Setup Service.
     */
    public function __construct(IntegrationHelper $integrationHelper, CoreParametersHelper $coreParametersHelper, Logger $logger)
    {
        $this->integration = $integrationHelper->getIntegrationObject('Trello');
        $this->coreParametersHelper = $coreParametersHelper;
        $this->logger = $logger;
    }

    /**
     * Return the Api for the Orders.
     *
     * @return \Openapi\lib\Api\DefaultApi $api
     */
    public function getApi()
    {
        // setup auth
        $auth = $this->getAuthParams();
        $config = Configuration::getDefaultConfiguration()->setApiKey('key', $auth['key']);
        $config = Configuration::getDefaultConfiguration()->setApiKey('token', $auth['token']);

        return new DefaultApi(
            new HttpClient(),
            $config
        );
    }

    /**
     * Get the users favourite board from Settings.
     *
     * @return void
     */
    public function getFavouriteBoard()
    {
        return $this->coreParametersHelper->get('favorite_board', '');
    }

    /**
     * Get the user specific auth params of the Trello API to add to the post part.
     *
     * @return void
     */
    public function getAuthParams()
    {
        if (!$this->integration || !$this->integration->getIntegrationSettings()->getIsPublished()) {
            throw new Exception('Trello Plugin not published, or no integration provided');
        }
        $settings = $this->integration->getIntegrationSettings()->getFeatureSettings();

        return [
            'key' => $settings['appkey'],
            'token' => $settings['apitoken'],
        ];
    }
}
