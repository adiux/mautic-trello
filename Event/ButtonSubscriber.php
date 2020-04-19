<?php
// plugins/Idea2TrelloBundle/Event/ButtonSubscriber.php

namespace MauticPlugin\Idea2TrelloBundle\Event;

use Mautic\CoreBundle\CoreEvents;
use Mautic\CoreBundle\Event\CustomButtonEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Mautic\CoreBundle\Templating\Helper\ButtonHelper;
use Mautic\LeadBundle\Entity\Lead;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Add a Trello button
 */
class ButtonSubscriber implements EventSubscriberInterface
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * init
     *
     * @param RouterInterface     $router
     * @param TranslatorInterface $translator
     */
    public function __construct(RouterInterface $router, TranslatorInterface $translator)
    {
        $this->router     = $router;
        $this->translator = $translator;
    }
    /**
     * Get Events
     *
     * @return void
     */
    public static function getSubscribedEvents()
    {
        return [
            CoreEvents::VIEW_INJECT_CUSTOM_BUTTONS => ['injectViewButtons', 0],
        ];
    }

    /**
     * @param CustomButtonEvent $event
     */
    public function injectViewButtons(CustomButtonEvent $event)
    {
        // // mautic.view_inject_custom_buttons
        // print_r(CoreEvents::VIEW_INJECT_CUSTOM_BUTTONS);

        // Injects a button into the toolbar area for any page with a high priority (displays closer to first)
        // $event->addButton(
        //     [
        //         'attr'      => [
        //             'class'       => 'btn btn-default btn-sm btn-nospin',
        //             'data-toggle' => 'ajaxmodal',
        //             'data-target' => '#MauticSharedModal',
        //             'href'        => $this->router->generate('plugin_create_cards', ['objectAction' => 'doSomething']),
        //             'data-header' => 'Extra Button',
        //         ],
        //         'tooltip'   => $this->translator->trans('mautic.world.dosomething.btn.tooltip'),
        //         'iconClass' => 'fa fa-star',
        //         'priority'  => 255,
        //     ],
        //     ButtonHelper::LOCATION_TOOLBAR_ACTIONS
        // );

        //
        if ($lead = $event->getItem()) {
            
            if ($lead instanceof Lead) {
                $addToTrelloBtn = [
                    'attr'      => [
                        'data-toggle' => 'ajaxmodal',
                        'data-target' => '#MauticSharedModal',
                        'data-header' => $this->translator->trans(
                            'plugin.idea2trello.add_card_to_trello'
                        ),
                        'href'        => $this->router->generate(
                            'plugin_create_cards',
                            ['contactId' => $lead->getId()]
                        ),
                    ],
                    'btnText'   => 'Add to Trello',
                    'iconClass' => 'fa fa-trello',
                    'primary'   => true,
                    'priority'  => 255,
                ];

                // Inject a button into the page actions for the specified route (in this case /s/contacts/view/{contactId})
                $event
                    ->addButton(
                        $addToTrelloBtn,
                        // Location of where to inject the button; this can be an array of multiple locations
                        ButtonHelper::LOCATION_PAGE_ACTIONS,
                        ['mautic_contact_action', ['objectAction' => 'view']]
                    )
                    // Inject a button into the list actions for each contact on the /s/contacts page
                    ->addButton(
                        $addToTrelloBtn,
                        ButtonHelper::LOCATION_LIST_ACTIONS,
                        'mautic_contact_index'
                    );
            }
        }
    }
}
