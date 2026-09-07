<?php

namespace MauticPlugin\AivieTrelloBundle\Controller\Api;

use Doctrine\Persistence\ManagerRegistry;
use Mautic\CoreBundle\Factory\ModelFactory;
use Mautic\CoreBundle\Helper\CoreParametersHelper;
use Mautic\CoreBundle\Helper\InputHelper;
use Mautic\CoreBundle\Helper\UserHelper;
use Mautic\CoreBundle\Security\Permissions\CorePermissions;
use Mautic\CoreBundle\Service\FlashBag;
use Mautic\CoreBundle\Translation\Translator;
use Mautic\UserBundle\Entity\User;
use MauticPlugin\AivieTrelloBundle\Controller\CardController;
use MauticPlugin\AivieTrelloBundle\Openapi\lib\Model\Card;
use MauticPlugin\AivieTrelloBundle\Service\TrelloApiService;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class CardApiController extends CardController
{
    public function __construct(
        private LoggerInterface $logger,
        private TrelloApiService $apiService,
        ManagerRegistry $doctrine,
        ModelFactory $modelFactory,
        UserHelper $userHelper,
        CoreParametersHelper $coreParametersHelper,
        EventDispatcherInterface $dispatcher,
        Translator $translator,
        FlashBag $flashBag,
        RequestStack $requestStack,
        CorePermissions $security,
    ) {
        parent::__construct($logger, $apiService, $doctrine, $modelFactory, $userHelper, $coreParametersHelper, $dispatcher, $translator, $flashBag, $requestStack, $security);
    }

    public function addChecklistItemToCardAction(Request $request): JsonResponse
    {
        $data      = $request->request->all();
        $itemName  = InputHelper::string($data['itemName'] ?? '');
        $boardId   = InputHelper::string($data['boardId'] ?? '');
        $contactId = (int) ($data['contactId'] ?? 0);
        $dueDate   = InputHelper::string($data['dueDate'] ?? '');
        $card      = null;

        if (empty($itemName) || empty($contactId)) {
            $this->logger->warning('Trello: Invalid request', ['data' => $data]);

            return $this->json(['error' => 'invalid request'], Response::HTTP_BAD_REQUEST);
        }

        if ('' === $boardId) {
            $boardId = $this->apiService->getFavouriteBoard();
            if (empty($boardId)) {
                $this->logger->warning('Trello: No board configured');

                return $this->json(['error' => 'no board configured'], Response::HTTP_BAD_REQUEST);
            }
        }

        $card = $this->apiService->findCardForLead($boardId, $contactId);

        // get the Trello Board Member for the current logged in user
        $user   = $this->getUser();
        $member = $user instanceof User
            ? $this->apiService->getBoardMemberForUser($this->apiService->getFavouriteBoard(), $user)
            : null;

        // Card for lead not found on board, so create a new card
        if (null === $card) {
            $this->logger->debug('Trello: Card not found for contact. Creating a new card.', ['contactId' => $contactId]);
            $contact = $this->getExistingContact($contactId);
            if (empty($contact)) {
                $this->logger->warning('Trello: no contact found for id', [$contactId]);

                return $this->json(['error' => 'no contact found for id '.$contactId], Response::HTTP_BAD_REQUEST);
            }

            $newCard             = $this->contactToCard($contact);

            $newCard->setIdMembers($member ? [$member->getId()] : []);

            $cardArray           = json_decode($newCard->__toString(), true);
            $cardArray['idList'] = $newCard->getIdList();
            $card                = $this->apiService->addNewCard($cardArray);
        }

        // check if we have a valid Card instance (e.g. addCard may return CardError or Exception)
        if (!$card instanceof Card) {
            $this->logger->warning('Trello: Invalid card', ['card' => $card]);

            return $this->json(['errors' => ['Invalid card returned']], Response::HTTP_BAD_REQUEST);
        }

        $this->apiService->addChecklistItemToCard($card, $itemName);

        $updatedCard = $this->apiService->updateCardDueDate($card->getId(), $dueDate, $member ? [$member->getId()] : null);
        $card        = $updatedCard ?? $card;

        $this->logger->info('Trello: Checklist item added to card', ['cardId' => $card->getId(), 'contactId' => $contactId]);

        return $this->json(['card' => [
            'id'       => $card->getId(),
            'url'      => $card->getUrl(),
            'name'     => $card->getName(),
            'itemName' => $itemName,
            'dueDate'  => $card->getDue(),
        ]]);
    }
}
