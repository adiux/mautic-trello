<?php
namespace MauticPlugin\Idea2TrelloBundle\Event;

use Mautic\ConfigBundle\ConfigEvents;
use Mautic\ConfigBundle\Event\ConfigBuilderEvent;
use Mautic\ConfigBundle\Event\ConfigEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use MauticPlugin\Idea2TrelloBundle\Form\ConfigType;
use Monolog\Logger;

class ConfigSubscriber implements EventSubscriberInterface
{
    /**
     * @var Logger
     */
    protected $logger;

    /**
     * Setup Trello Configuration Subscriber
     *
     * @param Logger $logger
     */
    public function __construct(Logger $logger)
    {
        $this->logger       = $logger;
    }

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
            ]
        );
    }

    /**
     * Prepare values before conig is saved to file
     *
     * @param ConfigEvent $event
     * @return void
     */
    public function onConfigSave(ConfigEvent $event)
    {
        /** @var array $values */
        $config = $event->getConfig('trello_config');

        // Manipulate the values
        // if (!empty($config['favorite_board'])) {
        //     $board = $config['favorite_board'];
        //     $config['favorite_board'] = $board->getId();
        //     // htmlspecialchars($values['trello_config']['favorite_board']->getId());
        // }
        $this->logger->warning('values', $config);
        // Set updated values
        $event->setConfig($config, 'trello_config');
    }
}
