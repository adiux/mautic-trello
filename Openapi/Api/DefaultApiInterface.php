<?php
/**
 * DefaultApiInterface
 * PHP version 5.
 *
 * @category Class
 *
 * @author   OpenAPI Generator team
 *
 * @see     https://github.com/openapitools/openapi-generator
 */

/**
 * Idea2 Trello API.
 *
 * Create card in Trello
 *
 * The version of the OpenAPI document: 0.1.1
 *
 * Generated by: https://github.com/openapitools/openapi-generator.git
 */

/**
 * NOTE: This class is auto generated by the openapi generator program.
 * https://github.com/openapitools/openapi-generator
 * Do not edit the class manually.
 */

namespace MauticPlugin\Idea2TrelloBundle\Openapi\Api;

use MauticPlugin\Idea2TrelloBundle\Openapi\Model\NewCard;

/**
 * DefaultApiInterface Interface Doc Comment.
 *
 * @category Interface
 *
 * @author   OpenAPI Generator team
 *
 * @see     https://github.com/openapitools/openapi-generator
 */
interface DefaultApiInterface
{
    /**
     * Sets authentication method basicAuth.
     *
     * @param string $value value of the basicAuth authentication method
     */
    public function setbasicAuth($value);

    /**
     * Operation addCard.
     *
     * @param MauticPlugin\Idea2TrelloBundle\Openapi\Model\NewCard $newCard         Card to be added (required)
     * @param int                                                  $responseCode    The HTTP response code to return
     * @param array                                                $responseHeaders Additional HTTP headers to return with the response ()
     *
     * @return MauticPlugin\Idea2TrelloBundle\Openapi\Model\InlineResponse200
     */
    public function addCard(NewCard $newCard, &$responseCode, array &$responseHeaders);
}
