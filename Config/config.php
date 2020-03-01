<?php
return array(
    'name'          => 'Hello World',
    'description'   => 'This is an example config file for a simple Hello World addon.',
    'version'       => '0.1.0',
    'routes'   => array(
        'main' => array(
            'plugin_helloworld_world' => array(
                'path'       => '/hello/{world}',
                'controller' => 'Idea2TrelloBundle:Default:world',
                'defaults'    => array(
                    'world' => 'earth'
                ),
                'requirements' => array(
                    'world' => 'earth|mars'
                )
            ),
        ),
      ),
);
