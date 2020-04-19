<?php
/**
 * @copyright   2020 Idea2 Collective GmbH. All rights reserved.
 *
 * @author      Idea2
 *
 * @see        https://www.idea2.ch
 * @see        http://m.localhost/s/hello/mars
 */
return [
    'name'          => 'Mautic Trello',
    'description'   => 'Add Mautic Contacts to Trello.',
    'version'       => '0.1.0',
    'routes'        => [
        'main' => [
            'plugin_helloworld_world' => [
                'path'        => '/hello/{world}',
                'controller'  => 'Idea2TrelloBundle:Default:world',
                'defaults'    => [
                    'world' => 'earth',
                ],
                'requirements' => [
                    'world' => 'earth|mars',
                ],
            ],
            'plugin_create_cards' => [
                'path'       => '',
                'controller' => 'Idea2TrelloBundle:CreateCard',
            ],
        ],
        'api' => [
            'plugin_api_trello_card_add' => [
                'path'            => '/trello/card',
                'method'     => 'POST',
                'controller'      => 'Idea2TrelloBundle:Card:addCard',
            ],
        ],
      ],
      'services' => [
        'events' => [
            'mautic.channel.button.subscriber.trello' => [
                'class'     => \MauticPlugin\Idea2TrelloBundle\Event\ButtonSubscriber::class,
                'arguments' => [
                    'router',
                    'translator',
                ],
            ],
        ],
    ],
];
