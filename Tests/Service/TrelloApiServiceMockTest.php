<?php

/**
 * @copyright 2022 Aivie. All rights reserved
 * @author    Aivie
 *
 * @see https://aivie.ch
 *
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

declare(strict_types=1);

namespace MauticPlugin\MauticTrelloBundle\Tests\Service;

use GuzzleHttp\Client as HttpClient;
use Mautic\CoreBundle\Helper\CoreParametersHelper;
use Mautic\PluginBundle\Helper\IntegrationHelper;
use MauticPlugin\MauticTrelloBundle\Openapi\lib\Api\DefaultApi;
use MauticPlugin\MauticTrelloBundle\Openapi\lib\Configuration;
use MauticPlugin\MauticTrelloBundle\Openapi\lib\Model\Card;
use MauticPlugin\MauticTrelloBundle\Openapi\lib\Model\TrelloList;
use MauticPlugin\MauticTrelloBundle\Service\TrelloApiService;
use MauticPlugin\MauticTrelloBundle\Tests\Mock\DefaultApiMock;
use Monolog\Logger;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Test the Mautic Trello API Services.
 */
class TrelloApiServiceMockTest extends TestCase
{
    private const MOCK_API_HOST  = 'http://127.0.0.1:4010';
    private const MOCK_API_KEY   = 'KEY';
    private const MOCK_API_TOKEN = 'TOKEN';
    private const MOCK_FAV_BOARD = '6e5a1f9d35b240384adcddcq';

    /**
     * @var MockObject
     */
    protected $apiService;

    /**
     * Set up tests to ether use static json files or the Prism mock server.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->apiService = $this->getMockBuilder(TrelloApiService::class)
            ->setMethods(['getApi', 'getFavouriteBoard'])
            ->setConstructorArgs(
                [
                $this->createMock(IntegrationHelper::class),
                $this->createMock(CoreParametersHelper::class),
                $this->createMock(Logger::class),
                ]
            )
            ->getMock();

        $this->apiService->method('getApi')
            ->willReturn(new DefaultApiMock());

        // valid for both variants
        $this->apiService->method('getFavouriteBoard')
            ->willReturn(self::MOCK_FAV_BOARD);
        $this->apiService->method('getListsOnBoard')
            ->willReturn('');
    }

    // public function getListsOnBoard(int $boardId = null): array

    /**
     * Get valid Trello lists from mocked API.
     */
    public function testGetListsOnBoard(): void
    {
        $lists = $this->apiService->getListsOnBoard();
        $this->assertGreaterThan(0, count($lists));
        foreach ($lists as $list) {
            $this->assertInstanceOf(TrelloList::class, $list);
            $this->assertTrue($list->valid());
        }
    }

    /**
     * Get a list of Trello boards from mocked API.
     */
    public function testGetBoardsArray(): void
    {
        $boards = $this->apiService->getBoardsArray();
        $this->assertGreaterThan(0, count($boards));

        foreach ($boards as $id => $name) {
            $this->assertIsString($id);
            $this->assertIsString($name);
            $this->assertNotEmpty($id);
            $this->assertNotEmpty($name);
        }
    }

    /**
     * Get valid Trello lists from mocked API.
     */
    public function testAddNewCard(): void
    {
        $newCard = [
            'name'           => 'this is a card name',
            'desc'           => "sample description with some special chars: %'ä.$&",
            'pos'            => 'top',
            'due'            => '2020-06-28T11:14:12.523Z',
            'urlSource'      => 'https://www.mautic.org',
            'keepFromSource' => 'all',
            'idList'         => '5e5c1f8f12326fasd8b6qba6',
        ];

        $card = $this->apiService->addNewCard($newCard);
        $this->assertInstanceOf(Card::class, $card);
        if ($card instanceof Card) {
            $this->assertTrue($card->valid());
        }
    }

    // public function testWithPrism(){

    //     // $this->testAddNewCard();
    //     $newCard = [
    //         'name'           => 'this is a card name',
    //         'desc'           => "sample description with some special chars: %'ä.$&",
    //         'pos'            => 'top',
    //         'due'            => '2020-06-28T11:14:12.523Z',
    //         'urlSource'      => 'https://www.mautic.org',
    //         'keepFromSource' => 'all',
    //         'idList'         => '5e5c1f8f12326fasd8b6qba6',
    //     ];

    //     $card = $this->apiService->addNewCard($newCard);
    //     $this->assertInstanceOf(Card::class, $card);
    //     if ($card instanceof Card) {
    //         $this->assertTrue($card->valid());
    //     }
    // }
}
