<?php

declare(strict_types=1);

namespace MauticPlugin\AivieTrelloBundle\EventListener;

use Mautic\CoreBundle\CoreEvents;
use Mautic\CoreBundle\Event\CustomButtonEvent;
use Mautic\CoreBundle\Twig\Helper\ButtonHelper;
use Mautic\LeadBundle\Entity\Lead;
use MauticPlugin\AivieTrelloBundle\Integration\Config;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Add a Trello button.
 */
class ButtonSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private RouterInterface $router,
        private TranslatorInterface $translator,
        private Config $config,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            CoreEvents::VIEW_INJECT_CUSTOM_BUTTONS => ['injectViewButtons', 0],
        ];
    }

    public function injectViewButtons(CustomButtonEvent $event): void
    {
        if (!str_starts_with($event->getRoute(), 'mautic_contact_')) {
            return;
        }

        if (!$this->config->isPublished() && !$this->config->isConfigured()) {
            return;
        }

        $returnRoute = $event->getRoute();

        $lead = $event->getItem();
        if ($lead instanceof Lead) {
            $addToTrelloBtn = [
                'attr' => [
                    'data-toggle' => 'ajaxmodal',
                    'data-target' => '#MauticSharedModal',
                    'data-header' => $this->translator->trans(
                        'plugin.trello.add_card_to_trello'
                    ),
                    'href' => $this->router->generate(
                        'plugin_create_cards_show_new',
                        [
                            'contactId'   => $lead->getId(),
                            'returnRoute' => $returnRoute,
                        ]
                    ),
                ],
                'btnText' => $this->translator->trans(
                    'plugin.trello.add_card_to_trello'
                ),
                'iconClass' => 'fa fa-trello',
            ];

            $event
                // Inject a button into /s/contacts/view/{contactId})
                ->addButton(
                    $addToTrelloBtn,
                    ButtonHelper::LOCATION_PAGE_ACTIONS,
                    'mautic_contact_action'
                )
                // Inject a button into the list actions for contacts on the /s/contacts page
                ->addButton(
                    $addToTrelloBtn,
                    ButtonHelper::LOCATION_LIST_ACTIONS,
                    'mautic_contact_index'
                );
        }
        // // is it a contact list
        // if (0 === strpos($event->getRoute(), 'mautic_contact_index')) {
        //     $event
        //         // Inject a button into the list actions for each contact on the /s/contacts page
        //         ->addButton(
        //             array(
        //                 'attr' => array(
        //                     'data-toggle' => 'ajaxmodal',
        //                     'data-target' => '#MauticSharedModal',
        //                     'data-header' => $this->translator->trans(
        //                         'plugin.trello.add_card_to_trello'
        //                     ),
        //                     'href' => $this->router->generate(
        //                         'plugin_create_cards_show_new',
        //                         array(
        //                         'contactId' => 0,
        //                         'returnRoute' => $returnRoute,
        //                         )
        //                     ),
        //                 ),
        //                 'btnText' => $this->translator->trans(
        //                     'plugin.trello.add_card_to_trello'
        //                 ),
        //                 'iconClass' => 'fa fa-trello',
        //             ),
        //             array(ButtonHelper::LOCATION_BULK_ACTIONS),
        //             'mautic_contact_index'
        //         );
        // }
    }
}
