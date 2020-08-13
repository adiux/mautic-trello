<?php

// plugins/MauticTrelloBundle/Event/ButtonSubscriber.php

namespace MauticPlugin\MauticTrelloBundle\Event;

use Mautic\CoreBundle\CoreEvents;
use Mautic\CoreBundle\Event\CustomButtonEvent;
use Mautic\CoreBundle\Templating\Helper\ButtonHelper;
use Mautic\LeadBundle\Entity\Lead;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Add a Trello button.
 */
class ButtonSubscriber implements EventSubscriberInterface
{
    protected $requestStack;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * init.
     */
    public function __construct(RouterInterface $router, TranslatorInterface $translator, RequestStack $requestStack)
    {
        $this->router = $router;
        $this->translator = $translator;
        $this->requestStack = $requestStack;
    }

    /**
     * Get Events.
     */
    public static function getSubscribedEvents()
    {
        return [
            CoreEvents::VIEW_INJECT_CUSTOM_BUTTONS => ['injectViewButtons', 0],
        ];
    }

    public function injectViewButtons(CustomButtonEvent $event)
    {
        $lead = $event->getItem();

        if ($lead instanceof Lead) {
            $request = $this->requestStack->getCurrentRequest();
            $returnRoute = $request->get('_route');

            $addToTrelloBtn = [
                'attr' => [
                    'data-toggle' => 'ajaxmodal',
                    'data-target' => '#MauticSharedModal',
                    'data-header' => $this->translator->trans(
                        'plugin.trello.add_card_to_trello'
                    ),
                    'href' => $this->router->generate(
                        'plugin_create_cards_show_new',
                        ['contactId' => $lead->getId(), 'returnRoute' => $returnRoute ]
                    ),
                ],
                'btnText' => $this->translator->trans(
                    'plugin.trello.add_card_to_trello'
                ),
                'iconClass' => 'fa fa-trello',
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
                )
            ;
        }
    }
}
