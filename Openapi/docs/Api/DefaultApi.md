# MauticPlugin\Idea2TrelloBundle\Openapi\lib\DefaultApi

All URIs are relative to *http://localhost/api/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**addCard**](DefaultApi.md#addCard) | **POST** /card | 
[**boardsBoardIdListsGet**](DefaultApi.md#boardsBoardIdListsGet) | **GET** /boards/{boardId}/lists | 



## addCard

> \MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\InlineResponse200 addCard($newCard)



Creates a new Trello card

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new MauticPlugin\Idea2TrelloBundle\Openapi\lib\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$newCard = new \MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\NewCard(); // \MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\NewCard | Card to be added

try {
    $result = $apiInstance->addCard($newCard);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->addCard: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **newCard** | [**\MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\NewCard**](../Model/NewCard.md)| Card to be added |

### Return type

[**\MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\InlineResponse200**](../Model/InlineResponse200.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: application/json
- **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints)
[[Back to Model list]](../../README.md#documentation-for-models)
[[Back to README]](../../README.md)


## boardsBoardIdListsGet

> \MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\TrelloList[] boardsBoardIdListsGet($boardId, $cards, $filter, $fields)



Get all lists on a board

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new MauticPlugin\Idea2TrelloBundle\Openapi\lib\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$boardId = 'boardId_example'; // string | 
$cards = 'cards_example'; // string | 
$filter = 'filter_example'; // string | 
$fields = id,name,pos; // string | 

try {
    $result = $apiInstance->boardsBoardIdListsGet($boardId, $cards, $filter, $fields);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->boardsBoardIdListsGet: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **boardId** | **string**|  |
 **cards** | **string**|  | [optional]
 **filter** | **string**|  | [optional]
 **fields** | **string**|  | [optional]

### Return type

[**\MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\TrelloList[]**](../Model/TrelloList.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints)
[[Back to Model list]](../../README.md#documentation-for-models)
[[Back to README]](../../README.md)

