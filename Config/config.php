<?php
/**
 * @copyright   2020 Idea2 Collective GmbH. All rights reserved.
 *
 * @author      Idea2
 *
 * @see        https://www.idea2.ch
 * @see        https://developer.mautic.org/#services
 */
return [
    'name' => 'Mautic Trello',
    'description' => 'Add Mautic Contacts to Trello.',
    'version' => '0.1.0',
    'routes' => [
        'main' => [
            'plugin_helloworld_world' => [
                'path' => '/hello/{world}',
                'controller' => 'Idea2TrelloBundle:Default:world',
                'defaults' => [
                    'world' => 'earth',
                ],
                'requirements' => [
                    'world' => 'earth|mars',
                ],
            ],
            'plugin_create_cards' => [
                'path' => '/trello/card/add',
                'controller' => 'Idea2TrelloBundle:Card:add',
            ],
            'plugin_trello_card_add' => [
                'path' => '/api/v1/trello/card',
                'method' => 'POST',
                'controller' => 'Idea2TrelloBundle:ApiCard:add',
            ],
        ],
        'api' => [
            'plugin_api_trello_card_add' => [
                'path' => '/v1/trello/card',
                'method' => 'POST',
                'controller' => 'Idea2TrelloBundle:ApiCard:add',
            ],
        ],
    ],
    'services' => [
        'forms' => [
            'mautic.idea2trello.form.card' => [
                'class'     => 'MauticPlugin\Idea2TrelloBundle\Form\NewCardType',
            ],
            'mautic.idea2trello.form.config' => [
                'class'     => 'MauticPlugin\Idea2TrelloBundle\Form\ConfigType',
                'arguments' => 'mautic.lead.model.field',
            ],
        ],

        'events' => [
            'mautic.channel.button.subscriber.trello' => [
                'class' => \MauticPlugin\Idea2TrelloBundle\Event\ButtonSubscriber::class,
                'arguments' => [
                    'router',
                    'translator',
                ],
            ],
            'mautic.idea2trello.event.config' => [
                'class' => \MauticPlugin\Idea2TrelloBundle\Event\ConfigSubscriber::class,
            ],
        ],
        'others' => [
            'mautic.idea2trello.service.trello_api' => [
                'class' => \MauticPlugin\Idea2TrelloBundle\Service\TrelloApiService::class,
            ],
        ],
    ],
    'parameters' => [
        'favorite_board' => '',
    ],
];
