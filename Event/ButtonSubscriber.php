<?php
// plugins/Idea2TrelloBundle/Event/ButtonSubscriber.php

namespace MauticPlugin\Idea2TrelloBundle\EventListener;

use Mautic\CoreBundle\CoreEvents;
use Mautic\CoreBundle\Event\CustomButtonEvent;
use Mautic\CoreBundle\EventListener\CommonSubscriber;
use Mautic\CoreBundle\Templating\Helper\ButtonHelper;
use Mautic\LeadBundle\Entity\Lead;

/**
 * Add a Trello button
 */
class ButtonSubscriber extends CommonSubscriber
{
        /**
     * Define available permissions.
     *
     * @param $params
     */
    public function __construct($params)
    {
        parent::__construct($params);

        $this->permissions = [
            // Custom level
            'worlds' => [
                // Custom permissions
                'use_telescope' => 1,
                'send_probe'    => 2,
                'visit'         => 4,
                // Full will almost always be included and should be significantly higher than the
                // others in case new permissions need to be added later
                'full'          => 1024,
            ],
        ];

        // Add standard category permissions
        $this->addStandardPermissions('categories');
    }
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
        print '<pre>';
        print '<h1></h1>';
        print_r(CoreEvents::VIEW_INJECT_CUSTOM_BUTTONS);
        print '</pre>';
        exit;
        // Injects a button into the toolbar area for any page with a high priority (displays closer to first)
        $event->addButton(
            [
                'attr'      => [
                    'class'       => 'btn btn-default btn-sm btn-nospin',
                    'data-toggle' => 'ajaxmodal',
                    'data-target' => '#MauticSharedModal',
                    'href'        => $this->router->generate('mautic_world_action', ['objectAction' => 'doSomething']),
                    'data-header' => 'Extra Button',
                ],
                'tooltip'   => $this->translator->trans('mautic.world.dosomething.btn.tooltip'),
                'iconClass' => 'fa fa-star',
                'priority'  => 255,
            ],
            ButtonHelper::LOCATION_TOOLBAR_ACTIONS
        );

        //
        if ($lead = $event->getItem()) {
            if ($lead instanceof Lead) {
                $sendEmailButton = [
                    'attr'      => [
                        'data-toggle' => 'ajaxmodal',
                        'data-target' => '#MauticSharedModal',
                        'data-header' => $this->translator->trans(
                            'mautic.world.dosomething.header',
                            ['%email%' => $event->getItem()->getEmail()]
                        ),
                        'href'        => $this->router->generate(
                            'mautic_world_action',
                            ['objectId' => $event->getItem()->getId(), 'objectAction' => 'doSomething']
                        ),
                    ],
                    'btnText'   => 'Extra Button',
                    'iconClass' => 'fa fa-star',
                    'primary'   => true,
                    'priority'  => 255,
                ];

                // Inject a button into the page actions for the specified route (in this case /s/contacts/view/{contactId})
                $event
                    ->addButton(
                        $sendEmailButton,
                        // Location of where to inject the button; this can be an array of multiple locations
                        ButtonHelper::LOCATION_PAGE_ACTIONS,
                        ['mautic_contact_action', ['objectAction' => 'view']]
                    )
                    // Inject a button into the list actions for each contact on the /s/contacts page
                    ->addButton(
                        $sendEmailButton,
                        ButtonHelper::LOCATION_LIST_ACTIONS,
                        'mautic_contact_index'
                    );
            }
        }
    }
}
