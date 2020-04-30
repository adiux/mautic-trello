<?php
namespace MauticPlugin\Idea2TrelloBundle\Event;

use Mautic\ConfigBundle\ConfigEvents;
use Mautic\ConfigBundle\Event\ConfigBuilderEvent;
use Mautic\ConfigBundle\Event\ConfigEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use MauticPlugin\Idea2TrelloBundle\Form\ConfigType;

class ConfigSubscriber implements EventSubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            ConfigEvents::CONFIG_ON_GENERATE => ['onConfigGenerate', 0],
            ConfigEvents::CONFIG_PRE_SAVE    => ['onConfigSave', 0],
        ];
    }

    public function onConfigGenerate(ConfigBuilderEvent $event)
    {
        $event->addForm(
            [
                'formAlias'  => 'trello_config', // same as in the View filename
                'formTheme'  => 'Idea2TrelloBundle:FormTheme\Config',
                'formType'   => ConfigType::class,
                'parameters' => $event->getParametersFromConfig('Idea2TrelloBundle'),
                // 'parameters' => $event->getParametersFromConfig('MauticSocialBundle'),
            ]
        );
    }

    public function onConfigSave(ConfigEvent $event)
    {
        /** @var array $values */
        $values = $event->getConfig();

        // Manipulate the values
        if (!empty($values['trello_config']['favorite_board'])) {
            $values['trello_config']['favorite_board'] = htmlspecialchars($values['trello_config']['favorite_board']);
        }

        // Set updated values
        $event->setConfig($values);
    }
}
