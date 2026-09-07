<?php

declare(strict_types=1);

namespace MauticPlugin\AivieTrelloBundle\Tests\Unit\Controller\Api;

use Mautic\LeadBundle\Entity\Lead;
use MauticPlugin\AivieTrelloBundle\Controller\Api\CardApiController;
use MauticPlugin\AivieTrelloBundle\Openapi\lib\Model\Card;
use MauticPlugin\AivieTrelloBundle\Openapi\lib\Model\NewCard;
use MauticPlugin\AivieTrelloBundle\Service\TrelloApiService;
use MauticPlugin\AivieTrelloBundle\Tests\Mock\DefaultApiMock;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CardApiControllerTest extends TestCase
{
    private LoggerInterface&MockObject $logger;

    private TrelloApiService&MockObject $trelloApiService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->logger           = $this->createMock(LoggerInterface::class);
        $this->trelloApiService = $this->createMock(TrelloApiService::class);
    }

    /**
     * @param array<string, mixed> $options
     */
    private function createController(array $options = []): CardApiController
    {
        $apiMock = $options['api'] ?? new DefaultApiMock();
        $this->trelloApiService->method('getApi')->willReturn($apiMock);
        $this->trelloApiService->method('getFavouriteBoard')->willReturn($options['favouriteBoard'] ?? 'board123');
        $this->trelloApiService->method('getBoardMemberForUser')->willReturn(null);

        $controller = new CardApiController(
            $this->logger,
            $this->trelloApiService,
            $this->createMock(\Doctrine\Persistence\ManagerRegistry::class),
            $this->createMock(\Mautic\CoreBundle\Factory\ModelFactory::class),
            $this->createMock(\Mautic\CoreBundle\Helper\UserHelper::class),
            $this->createMock(\Mautic\CoreBundle\Helper\CoreParametersHelper::class),
            $this->createMock(\Symfony\Component\EventDispatcher\EventDispatcherInterface::class),
            $this->createMock(\Mautic\CoreBundle\Translation\Translator::class),
            $this->createMock(\Mautic\CoreBundle\Service\FlashBag::class),
            $this->createMock(\Symfony\Component\HttpFoundation\RequestStack::class),
            $this->createMock(\Mautic\CoreBundle\Security\Permissions\CorePermissions::class),
        );

        $container = new \Symfony\Component\DependencyInjection\Container();
        $container->set('serializer', new \Symfony\Component\Serializer\Serializer(
            [new \Symfony\Component\Serializer\Normalizer\ObjectNormalizer()],
            [new \Symfony\Component\Serializer\Encoder\JsonEncoder()]
        ));
        $controller->setContainer($container);

        return $controller;
    }

    /**
     * @param array<string, mixed> $data
     */
    private function createRequest(array $data): Request
    {
        $request = new Request([], $data, [], [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($data));
        $request->request->replace($data);

        return $request;
    }

    public function testAddChecklistItemWithEmptyItemNameReturnsBadRequest(): void
    {
        $controller = $this->createController();
        $request    = $this->createRequest(['contactId' => 1, 'itemName' => '']);

        $response = $controller->addChecklistItemToCardAction($request);

        $this->assertSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('error', $content);
        $this->assertSame('invalid request', $content['error']);
    }

    public function testAddChecklistItemWithZeroContactIdReturnsBadRequest(): void
    {
        $controller = $this->createController();
        $request    = $this->createRequest(['contactId' => 0, 'itemName' => 'Call back']);

        $response = $controller->addChecklistItemToCardAction($request);

        $this->assertSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('error', $content);
        $this->assertSame('invalid request', $content['error']);
    }

    public function testAddChecklistItemWithNoBoardConfiguredReturnsBadRequest(): void
    {
        $controller = $this->createController(['favouriteBoard' => '']);
        $request    = $this->createRequest(['contactId' => 1, 'itemName' => 'Call back']);

        $response = $controller->addChecklistItemToCardAction($request);

        $this->assertSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('error', $content);
        $this->assertSame('no board configured', $content['error']);
    }

    public function testAddChecklistItemWhenAddCardReturnsNonCardReturnsBadRequest(): void
    {
        $lead = $this->createMock(Lead::class);
        $lead->method('getId')->willReturn(1);
        $lead->method('getName')->willReturn('Test Contact');
        $lead->method('getEmail')->willReturn('test@example.com');

        $this->trelloApiService->method('getFavouriteBoard')->willReturn('board123');
        $this->trelloApiService->method('getBoardMemberForUser')->willReturn(null);
        $this->trelloApiService->method('findCardForLead')->willReturn(null);
        $this->trelloApiService->method('addNewCard')->willReturn(new \Exception('API error'));

        $controller = $this->getMockBuilder(CardApiController::class)
            ->setConstructorArgs([
                $this->logger,
                $this->trelloApiService,
                $this->createMock(\Doctrine\Persistence\ManagerRegistry::class),
                $this->createMock(\Mautic\CoreBundle\Factory\ModelFactory::class),
                $this->createMock(\Mautic\CoreBundle\Helper\UserHelper::class),
                $this->createMock(\Mautic\CoreBundle\Helper\CoreParametersHelper::class),
                $this->createMock(\Symfony\Component\EventDispatcher\EventDispatcherInterface::class),
                $this->createMock(\Mautic\CoreBundle\Translation\Translator::class),
                $this->createMock(\Mautic\CoreBundle\Service\FlashBag::class),
                $this->createMock(\Symfony\Component\HttpFoundation\RequestStack::class),
                $this->createMock(\Mautic\CoreBundle\Security\Permissions\CorePermissions::class),
            ])
            ->onlyMethods(['getExistingContact', 'contactToCard', 'getUser'])
            ->getMock();

        $controller->method('getExistingContact')->with(1)->willReturn($lead);
        $controller->method('contactToCard')->willReturn(new NewCard(['name' => 'Test', 'idList' => 'list1']));
        $controller->method('getUser')->willReturn($this->createMock(\Mautic\UserBundle\Entity\User::class));

        $container = new \Symfony\Component\DependencyInjection\Container();
        $container->set('serializer', new \Symfony\Component\Serializer\Serializer(
            [new \Symfony\Component\Serializer\Normalizer\ObjectNormalizer()],
            [new \Symfony\Component\Serializer\Encoder\JsonEncoder()]
        ));
        $controller->setContainer($container);

        $request = $this->createRequest(['contactId' => 1, 'itemName' => 'Call back', 'boardId' => 'board123']);

        $response = $controller->addChecklistItemToCardAction($request);

        $this->assertSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $content = json_decode($response->getContent(), true);
        $this->assertIsArray($content);
        $this->assertArrayHasKey('errors', $content);
        $this->assertContains('Invalid card returned', $content['errors']);
    }

    public function testAddChecklistItemWhenCardFoundOnBoardReturnsSuccess(): void
    {
        $cardJson = [
            'id'           => 'card-id-123',
            'name'         => 'Test Card',
            'url'          => 'https://trello.com/c/abc',
            'due'          => null,
            'idChecklists' => ['checklist-id-1'],
        ];
        $card = new Card($cardJson);

        $this->trelloApiService->method('findCardForLead')->with('board123', 1)->willReturn($card);
        $this->trelloApiService->method('addChecklistItemToCard')->willReturnCallback(function (): void {});
        $this->trelloApiService->method('updateCardDueDate')->willReturn($card);

        $controller = $this->getMockBuilder(CardApiController::class)
            ->setConstructorArgs([
                $this->logger,
                $this->trelloApiService,
                $this->createMock(\Doctrine\Persistence\ManagerRegistry::class),
                $this->createMock(\Mautic\CoreBundle\Factory\ModelFactory::class),
                $this->createMock(\Mautic\CoreBundle\Helper\UserHelper::class),
                $this->createMock(\Mautic\CoreBundle\Helper\CoreParametersHelper::class),
                $this->createMock(\Symfony\Component\EventDispatcher\EventDispatcherInterface::class),
                $this->createMock(\Mautic\CoreBundle\Translation\Translator::class),
                $this->createMock(\Mautic\CoreBundle\Service\FlashBag::class),
                $this->createMock(\Symfony\Component\HttpFoundation\RequestStack::class),
                $this->createMock(\Mautic\CoreBundle\Security\Permissions\CorePermissions::class),
            ])
            ->onlyMethods(['getUser'])
            ->getMock();
        $controller->method('getUser')->willReturn($this->createMock(\Mautic\UserBundle\Entity\User::class));

        $container = new \Symfony\Component\DependencyInjection\Container();
        $container->set('serializer', new \Symfony\Component\Serializer\Serializer(
            [new \Symfony\Component\Serializer\Normalizer\ObjectNormalizer()],
            [new \Symfony\Component\Serializer\Encoder\JsonEncoder()]
        ));
        $controller->setContainer($container);

        $request = $this->createRequest(['contactId' => 1, 'itemName' => 'Call back', 'boardId' => 'board123']);

        $response = $controller->addChecklistItemToCardAction($request);

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('card', $content);
        $this->assertSame('card-id-123', $content['card']['id']);
        $this->assertSame('Call back', $content['card']['itemName']);
        $this->assertSame('Test Card', $content['card']['name']);
    }
}
