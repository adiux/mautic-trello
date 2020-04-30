<?php

namespace MauticPlugin\Idea2TrelloBundle\Service;

use GuzzleHttp\Client as HttpClient;
use MauticPlugin\Idea2TrelloBundle\Openapi\lib\Api\DefaultApi;
use MauticPlugin\Idea2TrelloBundle\Openapi\lib\Configuration;

class TrelloApiService
{
    /**
     * Return the Api for the Orders.
     *
     * @return \Openapi\lib\Api\DefaultApi $api
     */
    public function getApi()
    {
        $config = Configuration::getDefaultConfiguration()
                    ->setHost('https://api.trello.com/1');

        $api = new DefaultApi(
            new HttpClient(),
            $config,
            null,
            2
        );

        return $api;
    }

    /**
     * Get the user specific auth params of the Trello API to add to the post part.
     *
     * @return void
     */
    public function getAuthParams()
    {
        return [
        'key' => '9ef17425c93fae626ad969e282ddb409',
        'token' => 'eff37dda8691f4f9a96de5d4bf6283e42ebc3870a6fce6c181ebf94ce74303a6', ];
    }
}
