<?php

declare(strict_types=1);
/**
 * @copyright 2020 Idea2 Collective GmbH. All rights reserved
 * @author    Idea2
 *
 * @see https://www.idea2.ch
 *
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\MauticTrelloBundle\Tests\Service;

use GuzzleHttp\Client as HttpClient;
use Mautic\CoreBundle\Helper\CoreParametersHelper;
use Mautic\PluginBundle\Helper\IntegrationHelper;
use MauticPlugin\MauticTrelloBundle\Openapi\lib\Api\DefaultApi;
use MauticPlugin\MauticTrelloBundle\Openapi\lib\Configuration;
use MauticPlugin\MauticTrelloBundle\Openapi\lib\Model\Card;
use MauticPlugin\MauticTrelloBundle\Openapi\lib\Model\TrelloList;
use MauticPlugin\MauticTrelloBundle\Service\TrelloApiService;
use Monolog\Logger;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Test the Mautic Trello API Services.
 */
class TrellApiServicePrismTest extends TestCase
{
    const MOCK_API_HOST  = 'http://127.0.0.1:4010';
    const MOCK_API_KEY   = 'KEY';
    const MOCK_API_TOKEN = 'TOKEN';
    const MOCK_FAV_BOARD = '6e5a1f9d35b240384adcddcq';

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

        // use with Prism mock server
        $config = new Configuration();
        $config->setHost(self::MOCK_API_HOST);
        $config->setApiKey('key', self::MOCK_API_KEY);
        $config->setApiKey('token', self::MOCK_API_TOKEN);

        $this->apiService->method('getApi')
            ->willReturn(new DefaultApi(
                new HttpClient(),
                $config
            ));

        // valid for both variants
        $this->apiService->method('getFavouriteBoard')
            ->willReturn(self::MOCK_FAV_BOARD);
    }

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
