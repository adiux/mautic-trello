<?php
declare(strict_types = 1);

namespace MauticPlugin\Idea2TrelloBundle\Service;

use GuzzleHttp\Client as HttpClient;
use Mautic\PluginBundle\Helper\IntegrationHelper;
use Mautic\CoreBundle\Helper\CoreParametersHelper;

use MauticPlugin\Idea2TrelloBundle\Openapi\lib\Api\DefaultApi;
use MauticPlugin\Idea2TrelloBundle\Integration\TrelloIntegration;
use MauticPlugin\Idea2TrelloBundle\Openapi\lib\Configuration;

use Monolog\Logger;

class TrelloApiService
{
    /**
     * @var bool|TrelloIntegration
     */
    protected $integration;

    /**
     *
     * @var CoreParametersHelper
     */
    protected $coreParametersHelper;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * Setup Service
     *
     * @param IntegrationHelper $integrationHelper
     * @param Logger            $logger
     */
    public function __construct(IntegrationHelper $integrationHelper, CoreParametersHelper $coreParametersHelper, Logger $logger)
    {
        $this->integration  = $integrationHelper->getIntegrationObject('Trello');
        $this->coreParametersHelper = $coreParametersHelper;
        $this->logger       = $logger;
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

        // $config = Configuration::getDefaultConfiguration()
        //             ->setHost('https://api.trello.com/1');

        // $api = new DefaultApi(
        //     new HttpClient(),
        //     $config,
        //     null,
        //     2
        // );

        // return $api;
    }

    /**
     * Get the users favourite board from Settings
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
        // $keys = $this->getKeys();
        // print '<pre>';
        // print '<h1>keys</h1>';
        // print_r( $keys );
        // print '</pre>'; exit;
        return [
        'key' => '9ef17425c93fae626ad969e282ddb409',
        'token' => 'eff37dda8691f4f9a96de5d4bf6283e42ebc3870a6fce6c181ebf94ce74303a6', ];
    }

    protected function getKeys()
    {
        if (!$this->integration || !$this->integration->getIntegrationSettings()->getIsPublished()) {
            return false;
        }

        // get api_key from plugin settings
        return $this->integration->getDecryptedApiKeys();
    }
}
