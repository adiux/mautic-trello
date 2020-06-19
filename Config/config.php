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
    'description' => 'Add Mautic Contacts to Trello',
    'version' => '1.0.0',
    'routes' => [
        'main' => [
            'plugin_create_cards_show_new' => [
                'path' => '/trello/card/show-new/{contactId}',
                'controller' => 'Idea2TrelloBundle:Card:showNewCard',
            ],
            'plugin_trello_card_add' => [
                'path' => '/trello/card',
                'method' => 'POST',
                'controller' => 'Idea2TrelloBundle:Card:add',
            ],
        ],
    ],
    'parameters' => [
        'favorite_board' => '',
    ],
    'services' => [
        'forms' => [
            'mautic.idea2trello.form.card' => [
                'class' => 'MauticPlugin\Idea2TrelloBundle\Form\NewCardType',
                'arguments' => [
                    'mautic.idea2trello.service.trello_api',
                    'monolog.logger.mautic',
                ],
            ],
            'mautic.idea2trello.form.config' => [
                'class' => 'MauticPlugin\Idea2TrelloBundle\Form\ConfigType',
                'arguments' => [
                    'mautic.lead.model.field',
                    'mautic.idea2trello.service.trello_api',
                    ],
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
                'arguments' => [
                    'monolog.logger.mautic',
                ],
            ],
        ],
        'others' => [
            'mautic.idea2trello.service.trello_api' => [
                'class' => \MauticPlugin\Idea2TrelloBundle\Service\TrelloApiService::class,
                'arguments' => [
                    'mautic.helper.integration',
                    'mautic.helper.core_parameters',
                    'monolog.logger.mautic',
                ],
            ],
        ],
        'integrations' => [
            'mautic.integration.trello' => [
                'class' => \MauticPlugin\Idea2TrelloBundle\Integration\TrelloIntegration::class,
                'arguments' => [
                    'event_dispatcher',
                    'mautic.helper.cache_storage',
                    'doctrine.orm.entity_manager',
                    'session',
                    'request_stack',
                    'router',
                    'translator',
                    'logger',
                    'mautic.helper.encryption',
                    'mautic.lead.model.lead',
                    'mautic.lead.model.company',
                    'mautic.helper.paths',
                    'mautic.core.model.notification',
                    'mautic.lead.model.field',
                    'mautic.plugin.model.integration_entity',
                    'mautic.lead.model.dnc',
                ],
            ],
        ],
    ],
];
