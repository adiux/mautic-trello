<?php

declare(strict_types=1);

/**
 * @copyright   2020 Mautic Contributors. All rights reserved
 *
 * @author      Mautic
 *
 * @see        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\MauticTrelloBundle\Controller;

use Mautic\CoreBundle\Controller\FormController;
use Mautic\LeadBundle\Entity\Lead;
use MauticPlugin\MauticTrelloBundle\Form\NewCardType;
use MauticPlugin\MauticTrelloBundle\Openapi\lib\Model\Card;
use MauticPlugin\MauticTrelloBundle\Openapi\lib\Model\NewCard;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\Forms;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Setup a a form and send it to Trello to create a new card.
 */
class CardController extends FormController
{
    /**
     * Logger.
     *
     * @var Monolog\Logger
     */
    protected $logger;

    /**
     * @var MauticPlugin\MauticTrelloBundle\Service\TrelloApiService
     */
    private $apiService;

    /**
     * Show a new Trello card form with prefilled information from the Contact.
     */
    public function showNewCardAction(int $contactId): Response
    {
        $this->logger = $this->get('monolog.logger.mautic');
        $this->apiService = $this->get('mautic.trello.service.trello_api');

        // build the form
        $form = $this->getForm($contactId);

        // display empty form
        return $this->delegateView(
            [
                'viewParameters' => [
                    'form' => $form->createView(),
                ],
                'contentTemplate' => 'MauticTrelloBundle:Card:new.html.php',
            ]
        );
    }

    /**
     * Add a new card by POST.
     */
    public function addAction(): JsonResponse
    {
        $this->logger = $this->get('monolog.logger.mautic');
        $this->apiService = $this->get('mautic.trello.service.trello_api');

        $contactId =  0;
        $this->logger->warn('session', $this->request->request->all());
        $data = $this->request->request->get('new_card', false);
        if (is_array($data) && isset($data['contactId'])) {
            $contactId =  (int) $data['contactId'];
        }
        // @todo
        // $lead = $this->checkLeadAccess($contactId, 'view');
        // if ($lead instanceof Response) {
        //     return $lead;
        // }

        // Check for a submitted form and process it
        $form = $this->getForm();
        
        


        if ($this->isFormCancelled($form)) {
            return $this->closeModal();
        }

        // process form data from HTTP variables
        $form->handleRequest($this->request);
        
        // MauticPlugin\MauticTrelloBundle\Openapi\lib\Model\NewCard;
        $newCard = $form->getData();

        if (!$newCard->valid()) {
            $invalid = current($newCard->listInvalidProperties());
            $message = sprintf($this->translator->trans('mautic.trello.card_data_not_valid'), $invalid);
            $this->addFlash($message, [], 'error');

            return new JsonResponse(['error' => $message]);
        }

        // create an Array from the object (workaround)
        $cardArray = json_decode($newCard->__toString(), true);
        // remove other values from array, only leave id
        $cardArray['idList'] = $form->get('idList')->getData()->getId();
        $card = $this->apiService->addNewCard($cardArray);

        if ($card instanceof Card) {
            // successfully added
            $this->addFlash(
                'plugin.trello.card_added',
                ['%title%' => $card->getName()]
            );
        } else {
            // not successfully added
            $this->addFlash(
                'plugin.trello.card_not_added'
            );
        }

        // return $this->closeModal($card);
        // $session = $this->get('session');
        // $bundle = "MauticTrelloBundle";
        // $viewParameters = [
        //     'page'   => $session->get('mautic.category.page'),
        //     'bundle' => $bundle,
        // ];

        return $this->closeAndRedirect($contactId);
    }

    protected function closeAndRedirect(int $contactId)
    {
        if ($this->isInList()) {
            $route          = 'mautic_contact_index';
            $viewParameters = [
                'page' => $this->get('session')->get('mautic.lead.page', 1),
            ];
            $func = 'index';
        } else {
            $route          = 'mautic_contact_action';
            $viewParameters = [
                'objectAction' => 'view',
                'objectId'     => $contactId,
            ];
            $func = 'view';
        }

        return $this->postActionRedirect(
            [
                'returnUrl'       => $this->generateUrl($route, $viewParameters),
                'viewParameters'  => $viewParameters,
                'contentTemplate' => 'MauticLeadBundle:Lead:'.$func,
                'passthroughVars' => [
                    'mauticContent' => 'lead',
                    'closeModal'    => 1,
                ],
            ]
        );
    }

    protected function isInList()
    {
        return ('GET' === $this->request->getMethod())
        ? $this->request->get('list', 0)
        : $this->request->request->get(
            'lead_quickemail[list]',
            0,
            true
        );
    }
    /**
     * Build the form.
     *
     * @param int $contactId
     *
     * @return Forms
     */
    protected function getForm(int $contactId = null): Form
    {
        $card = new NewCard();

        if (!empty($contactId)) {
            $contact = $this->getExistingContact($contactId);
            if (empty($contact)) {
                $this->logger->warning('no contact found for id', [$contactId]);

                return null;
            }
            $card = $this->contactToCard($contact);
        }

        $action = $this->generateUrl('plugin_trello_card_add');

        return $form = $this->createForm(NewCardType::class, $card, ['action' => $action]);
    }

    /**
     * Just close the modal and return parameters.
     *
     * @param Card $card
     */
    protected function closeModal(Card $card = null): JsonResponse
    {
        $passthroughVars['closeModal'] = 1;

        if (!empty($card) && $card->valid()) {
            // $passthroughVars['noteHtml'] = $this->renderView(
            //     'MauticTrelloBundle:Card:test.html.php',
            // );
            $passthroughVars['cardId'] = $card->getId();
            $passthroughVars['cardUrl'] = $card->getUrl();
        }

        $passthroughVars['mauticContent'] = 'trelloCardAdded';

        return new JsonResponse($passthroughVars);
    }

    /**
     * Get existing contact.
     *
     * @param int $contactId
     *
     * @return Lead|null
     */
    protected function getExistingContact($contactId)
    {
        // maybe use Use $model->checkForDuplicateContact directly instead
        $leadModel = $this->getModel('lead');

        return $leadModel->getEntity($contactId);
    }

    /**
     * Set the default values for the new card.
     */
    protected function contactToCard(Lead $contact): NewCard
    {
        // $desc = array('Contact:', $contact->getEmail(), $contact->getPhone(), $contact->getMobile());

        return new NewCard(
            [
                'name' => $contact->getName(),
                'desc' => null,
                'idList' => $this->getListForContact($contact),
                'urlSource' => $this->coreParametersHelper->getParameter('site_url').'/s/contacts/view/'.$contact->getId(),
                'contactId' => $contact->getId(),
                // 'due' => new \DateTime('next week'),
            ]
        );
    }

    /**
     * Get the current list name the contact is on based on the stage name.
     *
     * @param Lead $contact Mautic Lead (aka Contact)
     */
    protected function getListForContact(Lead $contact): string
    {
        $stage = $contact->getStage();
        $lists = $this->apiService->getListsOnBoard();
        if (!empty($stage) && is_array($lists)) {
            foreach ($lists as $list) {
                if ($list->getName() === $stage->getName()) {
                    $this->logger->debug('contact is on list', [$list->getName()]);

                    return $list->getName();
                }
            }
        }
        $this->logger->debug('stage is not a list', [$stage]);

        return "";
    }
}
