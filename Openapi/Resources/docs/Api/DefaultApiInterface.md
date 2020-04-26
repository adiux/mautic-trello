# MauticPlugin\Idea2TrelloBundle\Openapi\Api\DefaultApiInterface

All URIs are relative to *http://localhost/api/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**addCard**](DefaultApiInterface.md#addCard) | **POST** /trello/card | 


## Service Declaration
```yaml
# src/Acme/MyBundle/Resources/services.yml
services:
    # ...
    acme.my_bundle.api.default:
        class: Acme\MyBundle\Api\DefaultApi
        tags:
            - { name: "open_api_server.api", api: "default" }
    # ...
```

## **addCard**
> MauticPlugin\Idea2TrelloBundle\Openapi\Model\InlineResponse200 addCard($newCard)



Creates a new Trello card

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/DefaultApiInterface.php

namespace Acme\MyBundle\Api;

use MauticPlugin\Idea2TrelloBundle\Openapi\Api\DefaultApiInterface;

class DefaultApi implements DefaultApiInterface
{

    // ...

    /**
     * Implementation of DefaultApiInterface#addCard
     */
    public function addCard(NewCard $newCard)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **newCard** | [**MauticPlugin\Idea2TrelloBundle\Openapi\Model\NewCard**](../Model/NewCard.md)| Card to be added |

### Return type

[**MauticPlugin\Idea2TrelloBundle\Openapi\Model\InlineResponse200**](../Model/InlineResponse200.md)

### Authorization

[basicAuth](../../README.md#basicAuth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

