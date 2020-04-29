# MauticPlugin\Idea2TrelloBundle\Openapi\lib\DefaultApi

All URIs are relative to *http://localhost/api/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**addCard**](DefaultApi.md#addCard) | **POST** /trello/card | 



## addCard

> \MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\InlineResponse200 addCard($new_card)



Creates a new Trello card

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure HTTP basic authorization: basicAuth
$config = MauticPlugin\Idea2TrelloBundle\Openapi\lib\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new MauticPlugin\Idea2TrelloBundle\Openapi\lib\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$new_card = new \MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\NewCard(); // \MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\NewCard | Card to be added

try {
    $result = $apiInstance->addCard($new_card);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->addCard: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **new_card** | [**\MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\NewCard**](../Model/NewCard.md)| Card to be added |

### Return type

[**\MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\InlineResponse200**](../Model/InlineResponse200.md)

### Authorization

[basicAuth](../../README.md#basicAuth)

### HTTP request headers

- **Content-Type**: application/json
- **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints)
[[Back to Model list]](../../README.md#documentation-for-models)
[[Back to README]](../../README.md)

