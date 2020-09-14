<?php
/**
 * DefaultApi
 * PHP version 5.
 *
 * @category Class
 *
 * @author   OpenAPI Generator team
 *
 * @see     https://openapi-generator.tech
 */

/**
 * Mautic Trello API.
 *
 * Create or update a card via the Trello API
 *
 * The version of the OpenAPI document: 0.1.1
 *
 * Generated by: https://openapi-generator.tech
 * OpenAPI Generator version: 4.1.2
 */

/**
 * NOTE: This class is auto generated by OpenAPI Generator (https://openapi-generator.tech).
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace MauticPlugin\Idea2TrelloBundle\Openapi\lib\Api;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\MultipartStream;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use MauticPlugin\Idea2TrelloBundle\Openapi\lib\ApiException;
use MauticPlugin\Idea2TrelloBundle\Openapi\lib\Configuration;
use MauticPlugin\Idea2TrelloBundle\Openapi\lib\HeaderSelector;
use MauticPlugin\Idea2TrelloBundle\Openapi\lib\ObjectSerializer;

/**
 * DefaultApi Class Doc Comment.
 *
 * @category Class
 *
 * @author   OpenAPI Generator team
 *
 * @see     https://openapi-generator.tech
 */
class DefaultApi
{
    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var Configuration
     */
    protected $config;

    /**
     * @var HeaderSelector
     */
    protected $headerSelector;

    /**
     * @var int Host index
     */
    protected $hostIndex;

    /**
     * @param ClientInterface $client
     * @param Configuration   $config
     * @param HeaderSelector  $selector
     * @param int             $host_index (Optional) host index to select the list of hosts if defined in the OpenAPI spec
     */
    public function __construct(
        ClientInterface $client = null,
        Configuration $config = null,
        HeaderSelector $selector = null,
        $host_index = 0
    ) {
        $this->client         = $client ?: new Client();
        $this->config         = $config ?: new Configuration();
        $this->headerSelector = $selector ?: new HeaderSelector();
        $this->hostIndex      = $host_index;
    }

    /**
     * Set the host index.
     *
     * @param  int Host index (required)
     */
    public function setHostIndex($host_index)
    {
        $this->hostIndex = $host_index;
    }

    /**
     * Get the host index.
     *
     * @return Host index
     */
    public function getHostIndex()
    {
        return $this->hostIndex;
    }

    /**
     * @return Configuration
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Operation addCard.
     *
     * @param \MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\NewCard $newCard Card to be added (required)
     *
     * @throws \MauticPlugin\Idea2TrelloBundle\Openapi\lib\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     *
     * @return \MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\Card|\MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\CardError|\MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\CardError
     */
    public function addCard($newCard)
    {
        list($response) = $this->addCardWithHttpInfo($newCard);

        return $response;
    }

    /**
     * Operation addCardWithHttpInfo.
     *
     * @param \MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\NewCard $newCard Card to be added (required)
     *
     * @throws \MauticPlugin\Idea2TrelloBundle\Openapi\lib\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     *
     * @return array of \MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\Card|\MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\CardError|\MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\CardError, HTTP status code, HTTP response headers (array of strings)
     */
    public function addCardWithHttpInfo($newCard)
    {
        $request = $this->addCardRequest($newCard);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException("[{$e->getCode()}] {$e->getMessage()}", $e->getCode(), $e->getResponse() ? $e->getResponse()->getHeaders() : null, $e->getResponse() ? $e->getResponse()->getBody()->getContents() : null);
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(sprintf('[%d] Error connecting to the API (%s)', $statusCode, $request->getUri()), $statusCode, $response->getHeaders(), $response->getBody());
            }

            $responseBody = $response->getBody();
            switch ($statusCode) {
                case 200:
                    if ('\MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\Card' === '\SplFileObject') {
                        $content = $responseBody; //stream goes to serializer
                    } else {
                        $content = $responseBody->getContents();
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\Card', []),
                        $response->getStatusCode(),
                        $response->getHeaders(),
                    ];
                case 400:
                    if ('\MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\CardError' === '\SplFileObject') {
                        $content = $responseBody; //stream goes to serializer
                    } else {
                        $content = $responseBody->getContents();
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\CardError', []),
                        $response->getStatusCode(),
                        $response->getHeaders(),
                    ];
                case 404:
                    if ('\MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\CardError' === '\SplFileObject') {
                        $content = $responseBody; //stream goes to serializer
                    } else {
                        $content = $responseBody->getContents();
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\CardError', []),
                        $response->getStatusCode(),
                        $response->getHeaders(),
                    ];
            }

            $returnType   = '\MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\Card';
            $responseBody = $response->getBody();
            if ('\SplFileObject' === $returnType) {
                $content = $responseBody; //stream goes to serializer
            } else {
                $content = $responseBody->getContents();
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders(),
            ];
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\Card',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\CardError',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\CardError',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation addCardAsync.
     *
     * @param \MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\NewCard $newCard Card to be added (required)
     *
     * @throws \InvalidArgumentException
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function addCardAsync($newCard)
    {
        return $this->addCardAsyncWithHttpInfo($newCard)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation addCardAsyncWithHttpInfo.
     *
     * @param \MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\NewCard $newCard Card to be added (required)
     *
     * @throws \InvalidArgumentException
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function addCardAsyncWithHttpInfo($newCard)
    {
        $returnType = '\MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\Card';
        $request    = $this->addCardRequest($newCard);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    $responseBody = $response->getBody();
                    if ('\SplFileObject' === $returnType) {
                        $content = $responseBody; //stream goes to serializer
                    } else {
                        $content = $responseBody->getContents();
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders(),
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(sprintf('[%d] Error connecting to the API (%s)', $statusCode, $exception->getRequest()->getUri()), $statusCode, $response->getHeaders(), $response->getBody());
                }
            );
    }

    /**
     * Create request for operation 'addCard'.
     *
     * @param \MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\NewCard $newCard Card to be added (required)
     *
     * @throws \InvalidArgumentException
     *
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function addCardRequest($newCard)
    {
        // verify the required parameter 'newCard' is set
        if (null === $newCard || (is_array($newCard) && 0 === count($newCard))) {
            throw new \InvalidArgumentException('Missing the required parameter $newCard when calling addCard');
        }

        $resourcePath = '/card';
        $formParams   = [];
        $queryParams  = [];
        $headerParams = [];
        $httpBody     = '';
        $multipart    = false;

        // body params
        $_tempBody = null;
        if (isset($newCard)) {
            $_tempBody = $newCard;
        }

        if ($multipart) {
            $headers = $this->headerSelector->selectHeadersForMultipart(
                ['application/json']
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                ['application/json'],
                ['application/json']
            );
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            // $_tempBody is the method argument, if present
            if ('application/json' === $headers['Content-Type']) {
                $httpBody = \GuzzleHttp\json_encode(ObjectSerializer::sanitizeForSerialization($_tempBody));
            } else {
                $httpBody = $_tempBody;
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $multipartContents[] = [
                        'name'     => $formParamName,
                        'contents' => $formParamValue,
                    ];
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);
            } elseif ('application/json' === $headers['Content-Type']) {
                $httpBody = \GuzzleHttp\json_encode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = \GuzzleHttp\Psr7\build_query($formParams);
            }
        }

        // this endpoint requires API key authentication
        $apiKey = $this->config->getApiKeyWithPrefix('token');
        if (null !== $apiKey) {
            $queryParams['token'] = $apiKey;
        }
        // this endpoint requires API key authentication
        $apiKey = $this->config->getApiKeyWithPrefix('key');
        if (null !== $apiKey) {
            $queryParams['key'] = $apiKey;
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $query = \GuzzleHttp\Psr7\build_query($queryParams);

        return new Request(
            'POST',
            $this->config->getHost().$resourcePath.($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation getBoards.
     *
     * @param string $fields fields (optional)
     * @param string $filter filter (optional)
     *
     * @throws \MauticPlugin\Idea2TrelloBundle\Openapi\lib\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     *
     * @return \MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\TrelloBoard[]
     */
    public function getBoards($fields = null, $filter = null)
    {
        list($response) = $this->getBoardsWithHttpInfo($fields, $filter);

        return $response;
    }

    /**
     * Operation getBoardsWithHttpInfo.
     *
     * @param string $fields (optional)
     * @param string $filter (optional)
     *
     * @throws \MauticPlugin\Idea2TrelloBundle\Openapi\lib\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     *
     * @return array of \MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\TrelloBoard[], HTTP status code, HTTP response headers (array of strings)
     */
    public function getBoardsWithHttpInfo($fields = null, $filter = null)
    {
        $request = $this->getBoardsRequest($fields, $filter);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException("[{$e->getCode()}] {$e->getMessage()}", $e->getCode(), $e->getResponse() ? $e->getResponse()->getHeaders() : null, $e->getResponse() ? $e->getResponse()->getBody()->getContents() : null);
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(sprintf('[%d] Error connecting to the API (%s)', $statusCode, $request->getUri()), $statusCode, $response->getHeaders(), $response->getBody());
            }

            $responseBody = $response->getBody();
            switch ($statusCode) {
                case 200:
                    if ('\MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\TrelloBoard[]' === '\SplFileObject') {
                        $content = $responseBody; //stream goes to serializer
                    } else {
                        $content = $responseBody->getContents();
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\TrelloBoard[]', []),
                        $response->getStatusCode(),
                        $response->getHeaders(),
                    ];
            }

            $returnType   = '\MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\TrelloBoard[]';
            $responseBody = $response->getBody();
            if ('\SplFileObject' === $returnType) {
                $content = $responseBody; //stream goes to serializer
            } else {
                $content = $responseBody->getContents();
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders(),
            ];
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\TrelloBoard[]',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation getBoardsAsync.
     *
     * @param string $fields (optional)
     * @param string $filter (optional)
     *
     * @throws \InvalidArgumentException
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function getBoardsAsync($fields = null, $filter = null)
    {
        return $this->getBoardsAsyncWithHttpInfo($fields, $filter)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation getBoardsAsyncWithHttpInfo.
     *
     * @param string $fields (optional)
     * @param string $filter (optional)
     *
     * @throws \InvalidArgumentException
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function getBoardsAsyncWithHttpInfo($fields = null, $filter = null)
    {
        $returnType = '\MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\TrelloBoard[]';
        $request    = $this->getBoardsRequest($fields, $filter);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    $responseBody = $response->getBody();
                    if ('\SplFileObject' === $returnType) {
                        $content = $responseBody; //stream goes to serializer
                    } else {
                        $content = $responseBody->getContents();
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders(),
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(sprintf('[%d] Error connecting to the API (%s)', $statusCode, $exception->getRequest()->getUri()), $statusCode, $response->getHeaders(), $response->getBody());
                }
            );
    }

    /**
     * Create request for operation 'getBoards'.
     *
     * @param string $fields (optional)
     * @param string $filter (optional)
     *
     * @throws \InvalidArgumentException
     *
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function getBoardsRequest($fields = null, $filter = null)
    {
        $resourcePath = '/members/me/boards';
        $formParams   = [];
        $queryParams  = [];
        $headerParams = [];
        $httpBody     = '';
        $multipart    = false;

        // query params
        if (null !== $fields) {
            $queryParams['fields'] = ObjectSerializer::toQueryValue($fields);
        }
        // query params
        if (null !== $filter) {
            $queryParams['filter'] = ObjectSerializer::toQueryValue($filter);
        }

        // body params
        $_tempBody = null;

        if ($multipart) {
            $headers = $this->headerSelector->selectHeadersForMultipart(
                ['application/json']
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                ['application/json'],
                []
            );
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            // $_tempBody is the method argument, if present
            if ('application/json' === $headers['Content-Type']) {
                $httpBody = \GuzzleHttp\json_encode(ObjectSerializer::sanitizeForSerialization($_tempBody));
            } else {
                $httpBody = $_tempBody;
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $multipartContents[] = [
                        'name'     => $formParamName,
                        'contents' => $formParamValue,
                    ];
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);
            } elseif ('application/json' === $headers['Content-Type']) {
                $httpBody = \GuzzleHttp\json_encode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = \GuzzleHttp\Psr7\build_query($formParams);
            }
        }

        // this endpoint requires API key authentication
        $apiKey = $this->config->getApiKeyWithPrefix('token');
        if (null !== $apiKey) {
            $queryParams['token'] = $apiKey;
        }
        // this endpoint requires API key authentication
        $apiKey = $this->config->getApiKeyWithPrefix('key');
        if (null !== $apiKey) {
            $queryParams['key'] = $apiKey;
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $query = \GuzzleHttp\Psr7\build_query($queryParams);

        return new Request(
            'GET',
            $this->config->getHost().$resourcePath.($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation getLists.
     *
     * @param string $boardId boardId (required)
     * @param string $cards   cards (optional)
     * @param string $filter  filter (optional)
     * @param string $fields  fields (optional)
     *
     * @throws \MauticPlugin\Idea2TrelloBundle\Openapi\lib\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     *
     * @return \MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\TrelloList[]
     */
    public function getLists($boardId, $cards = null, $filter = null, $fields = null)
    {
        list($response) = $this->getListsWithHttpInfo($boardId, $cards, $filter, $fields);

        return $response;
    }

    /**
     * Operation getListsWithHttpInfo.
     *
     * @param string $boardId (required)
     * @param string $cards   (optional)
     * @param string $filter  (optional)
     * @param string $fields  (optional)
     *
     * @throws \MauticPlugin\Idea2TrelloBundle\Openapi\lib\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     *
     * @return array of \MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\TrelloList[], HTTP status code, HTTP response headers (array of strings)
     */
    public function getListsWithHttpInfo($boardId, $cards = null, $filter = null, $fields = null)
    {
        $request = $this->getListsRequest($boardId, $cards, $filter, $fields);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException("[{$e->getCode()}] {$e->getMessage()}", $e->getCode(), $e->getResponse() ? $e->getResponse()->getHeaders() : null, $e->getResponse() ? $e->getResponse()->getBody()->getContents() : null);
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(sprintf('[%d] Error connecting to the API (%s)', $statusCode, $request->getUri()), $statusCode, $response->getHeaders(), $response->getBody());
            }

            $responseBody = $response->getBody();
            switch ($statusCode) {
                case 200:
                    if ('\MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\TrelloList[]' === '\SplFileObject') {
                        $content = $responseBody; //stream goes to serializer
                    } else {
                        $content = $responseBody->getContents();
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\TrelloList[]', []),
                        $response->getStatusCode(),
                        $response->getHeaders(),
                    ];
            }

            $returnType   = '\MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\TrelloList[]';
            $responseBody = $response->getBody();
            if ('\SplFileObject' === $returnType) {
                $content = $responseBody; //stream goes to serializer
            } else {
                $content = $responseBody->getContents();
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders(),
            ];
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\TrelloList[]',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation getListsAsync.
     *
     * @param string $boardId (required)
     * @param string $cards   (optional)
     * @param string $filter  (optional)
     * @param string $fields  (optional)
     *
     * @throws \InvalidArgumentException
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function getListsAsync($boardId, $cards = null, $filter = null, $fields = null)
    {
        return $this->getListsAsyncWithHttpInfo($boardId, $cards, $filter, $fields)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation getListsAsyncWithHttpInfo.
     *
     * @param string $boardId (required)
     * @param string $cards   (optional)
     * @param string $filter  (optional)
     * @param string $fields  (optional)
     *
     * @throws \InvalidArgumentException
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function getListsAsyncWithHttpInfo($boardId, $cards = null, $filter = null, $fields = null)
    {
        $returnType = '\MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\TrelloList[]';
        $request    = $this->getListsRequest($boardId, $cards, $filter, $fields);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    $responseBody = $response->getBody();
                    if ('\SplFileObject' === $returnType) {
                        $content = $responseBody; //stream goes to serializer
                    } else {
                        $content = $responseBody->getContents();
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders(),
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(sprintf('[%d] Error connecting to the API (%s)', $statusCode, $exception->getRequest()->getUri()), $statusCode, $response->getHeaders(), $response->getBody());
                }
            );
    }

    /**
     * Create request for operation 'getLists'.
     *
     * @param string $boardId (required)
     * @param string $cards   (optional)
     * @param string $filter  (optional)
     * @param string $fields  (optional)
     *
     * @throws \InvalidArgumentException
     *
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function getListsRequest($boardId, $cards = null, $filter = null, $fields = null)
    {
        // verify the required parameter 'boardId' is set
        if (null === $boardId || (is_array($boardId) && 0 === count($boardId))) {
            throw new \InvalidArgumentException('Missing the required parameter $boardId when calling getLists');
        }

        $resourcePath = '/boards/{boardId}/lists';
        $formParams   = [];
        $queryParams  = [];
        $headerParams = [];
        $httpBody     = '';
        $multipart    = false;

        // query params
        if (null !== $cards) {
            $queryParams['cards'] = ObjectSerializer::toQueryValue($cards);
        }
        // query params
        if (null !== $filter) {
            $queryParams['filter'] = ObjectSerializer::toQueryValue($filter);
        }
        // query params
        if (null !== $fields) {
            $queryParams['fields'] = ObjectSerializer::toQueryValue($fields);
        }

        // path params
        if (null !== $boardId) {
            $resourcePath = str_replace(
                '{'.'boardId'.'}',
                ObjectSerializer::toPathValue($boardId),
                $resourcePath
            );
        }

        // body params
        $_tempBody = null;

        if ($multipart) {
            $headers = $this->headerSelector->selectHeadersForMultipart(
                ['application/json']
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                ['application/json'],
                []
            );
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            // $_tempBody is the method argument, if present
            if ('application/json' === $headers['Content-Type']) {
                $httpBody = \GuzzleHttp\json_encode(ObjectSerializer::sanitizeForSerialization($_tempBody));
            } else {
                $httpBody = $_tempBody;
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $multipartContents[] = [
                        'name'     => $formParamName,
                        'contents' => $formParamValue,
                    ];
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);
            } elseif ('application/json' === $headers['Content-Type']) {
                $httpBody = \GuzzleHttp\json_encode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = \GuzzleHttp\Psr7\build_query($formParams);
            }
        }

        // this endpoint requires API key authentication
        $apiKey = $this->config->getApiKeyWithPrefix('token');
        if (null !== $apiKey) {
            $queryParams['token'] = $apiKey;
        }
        // this endpoint requires API key authentication
        $apiKey = $this->config->getApiKeyWithPrefix('key');
        if (null !== $apiKey) {
            $queryParams['key'] = $apiKey;
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $query = \GuzzleHttp\Psr7\build_query($queryParams);

        return new Request(
            'GET',
            $this->config->getHost().$resourcePath.($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Create http client option.
     *
     * @throws \RuntimeException on file opening failure
     *
     * @return array of http client options
     */
    protected function createHttpClientOption()
    {
        $options = [];
        if ($this->config->getDebug()) {
            $options[RequestOptions::DEBUG] = fopen($this->config->getDebugFile(), 'a');
            if (!$options[RequestOptions::DEBUG]) {
                throw new \RuntimeException('Failed to open the debug file: '.$this->config->getDebugFile());
            }
        }

        return $options;
    }
}
