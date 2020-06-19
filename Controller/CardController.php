<?php

// declare(strict_types=1);

/**
 * @copyright   2020
 *
 * @author      Idea2
 *
 * @see        https://www.idea2.ch
 */

namespace MauticPlugin\Idea2TrelloBundle\Controller;

use Mautic\CoreBundle\Controller\FormController;
use MauticPlugin\Idea2TrelloBundle\Form\NewCardType;
use MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\NewCard;
use MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\Card;
use Mautic\LeadBundle\Entity\Lead;
use Symfony\Component\Asset\Exception\InvalidArgumentException;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\Forms;
use Symfony\Component\HttpFoundation\Request;
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
     * @var MauticPlugin\Idea2TrelloBundle\Service\TrelloApiService
     */
    private $apiService;

    /**
     * Fallback.
     *
     * @param int $page
     *
     * @return void
     */
    public function indexAction($page = 1)
    {
        return $this->delegateView(
            [
                'contentTemplate' => 'Idea2TrelloBundle:Hello:index.html.php',
            ]
        );
    }

    /**
     * Show a new Trello card form with prefilled information from the Contact.
     *
     * @param int $contactId
     *
     * @return Response
     */
    public function showNewCardAction(int $contactId)
    {
        $this->logger = $this->get('monolog.logger.mautic');
        $this->apiService = $this->get('mautic.idea2trello.service.trello_api');

        $this->logger->warning('got request with id', [$contactId]);

        // build the form
        $form = $this->getForm($contactId);

        // display empty form
        return $this->delegateView(
            [
                'viewParameters' => [
                    'form'        => $form->createView(),
                ],
                'contentTemplate' => 'Idea2TrelloBundle:Card:new.html.php',
            ]
        );
    }

    /**
     * Add a new card by POST
     *
     * @return void
     */
    public function addAction()
    {
        $this->logger = $this->get('monolog.logger.mautic');
        $this->apiService = $this->get('mautic.idea2trello.service.trello_api');
        // @todo
        // $lead = $this->checkLeadAccess($contactId, 'view');
        // if ($lead instanceof Response) {
        //     return $lead;
        // }

         // Check for a submitted form and process it

        $form = $this->getForm();

        if ($this->isFormCancelled($form)) {
            $this->logger->warning('form cancelled');

            return $this->closeModal();
        }

        // process form data from HTTP variables
        $form->handleRequest($this->request);
        $newCard = $form->getData();

        if (!$newCard->valid()) {
            $invalid = current($newCard->listInvalidProperties());
            $message = sprintf('New card data not valid: %s', $invalid);
            // $this->addFlash($message, array(), 'error');
            $this->logger->warning($message);

            return new JsonResponse(array( 'error' => $message));
        }

        // create an Array from the object (workaround)
        $cardArray = json_decode($newCard->__toString(), true);
        // remove other values from array, only leave id
        $cardArray['idList'] = $form->get('idList')->getData()->getId();
        $this->logger->warning('cardArray', $cardArray);

        return $this->postNewCard($cardArray);
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
                $this->logger->warning('no contact found for id', array($contactId));

                return null;
            }
            $card = $this->getTrelloData($contact);
        }

        $action = $this->generateUrl(
            'plugin_trello_card_add',
            // [
            //     'objectAction' => 'new',
            //     'leadId'       => $leadId,
            // ]
        );
        $this->logger->warning('action', array($action));

        return $form = $this->createForm(NewCardType::class, $card, ['action' => $action]);
    }

    /**
     * All the business logic for a submitted form.
     *
     * @param array $card
     *
     * @return void
     */
    protected function postNewCard(array $card)
    {
        $api = $this->apiService->getApi();
        $this->logger->warning('writing valid card to api', $card);

        try {
            $card = $api->addCard($card);
            $this->logger->warning('Successfully posted card to Trello', [$card->getId(), $card->getName()]);

            return $this->closeModal($card);
        } catch (InvalidArgumentException $e) {
            $this->logger->warning($e->getMessage(), $e->getTrace());
            $error = new Error();
            $error->setCode('InvalidArgument');
            $error->setMessage($e->getMessage());

            return new Exception($error);
        } catch (Exception $e) {
            $this->logger->error($e->getMessage(), $e->getTrace());

            return new Exception($e);
        }

        // return $this->redirectToRoute('task_success');
    }

    /**
     * Just close the modal and return parameters
     *
     * @return JsonResponse
     */
    protected function closeModal(Card $card = null)
    {
         $passthroughVars['closeModal'] = 1;

        if (!empty($card) && $card->valid()) {
            // $passthroughVars['noteHtml'] = $this->renderView(
            //     'Idea2TrelloBundle:Card:test.html.php',
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
     *
     * @param Lead $contact
     *
     * @return NewCard
     */
    protected function getTrelloData(Lead $contact)
    {
        // $desc = array('Contact:', $contact->getEmail(), $contact->getPhone(), $contact->getMobile());

        return new NewCard(
            array(
                'name' => $contact->getName(),
                'desc' => null,
                'idList' => $this->getListForContact($contact),
                'urlSource' => $this->coreParametersHelper->getParameter('site_url').'/s/contacts/view/'.$contact->getId(),
                // 'due' => new \DateTime('next week'),
            )
        );
    }

    /**
     * Get the current list name the contact is on based on the stage name
     *
     * @param Lead $contact
     *
     * @return string | null
     */
    protected function getListForContact(Lead $contact)
    {
        $stage = $contact->getStage();
        $lists = $this->apiService->getListsOnBoard();
        if (!empty($stage) && is_array($lists)) {
            foreach ($lists as $list) {
                if ($list->getName() === $stage->getName()) {
                    $this->logger->debug('contact is on list', array($list->getName()));

                    return $list->getName();
                }
            }
        }
        $this->logger->debug('stage is not a list', array($stage));

        return null;
    }
}
