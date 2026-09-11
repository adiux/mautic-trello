<?php

declare(strict_types=1);

use MauticPlugin\AivieTrelloBundle\Integration\AivieTrelloIntegration;
use MauticPlugin\AivieTrelloBundle\Integration\Support\ConfigSupport;

return [
    'name'        => 'Trello',
    'description' => 'Create Trello cards from Aivie or Mautic contacts',
    'version'     => '7.0.24',
    'author'      => 'Aivie',
    'routes'      => [
        'main' => [
            'plugin_create_cards_show_new' => [
                'path'       => '/trello/card/show-new/{contactId}',
                'controller' => 'MauticPlugin\AivieTrelloBundle\Controller\CardController::showNewCardAction',
            ],
            'plugin_trello_card_add' => [
                'path'        => '/trello/card',
                'method'      => 'POST',
                'controller'  => 'MauticPlugin\AivieTrelloBundle\Controller\CardController::addAction',
                'returnRoute' => '',
            ],
        ],
        'api' => [
            'plugin_trello_card_add_checklist_item_to_card' => [
                'path'        => '/trello/card/checklist/item',
                'method'      => 'POST',
                'controller'  => 'MauticPlugin\AivieTrelloBundle\Controller\Api\CardApiController::addChecklistItemToCardAction',
                'returnRoute' => '',
            ],
        ],
    ],
    'parameters' => [
        'favorite_board' => '',
    ],
    'services' => [
        'integrations' => [
            // Basic definitions with name, display name and icon
            'mautic.integration.aivietrello'               => [
                'class' => AivieTrelloIntegration::class,
                'tags'  => [
                    'mautic.integration',
                    'mautic.basic_integration',
                ],
            ],
            // Provides the form types to use for the configuration UI
            'trello.integration.configuration' => [
                'class'     => ConfigSupport::class,
                'tags'      => [
                    'mautic.config_integration',
                ],
            ],
        ],
    ],
];
