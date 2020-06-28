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
namespace MauticPlugin\Idea2TrelloBundle\Tests\Service;

use MauticPlugin\Idea2TrelloBundle\Service\TrelloApiService;
use MauticPlugin\Idea2TrelloBundle\Openapi\lib\Api\DefaultApi;
use MauticPlugin\Idea2TrelloBundle\Openapi\lib\Configuration;
use MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\TrelloList;

use Mautic\CoreBundle\Helper\CoreParametersHelper;
use Mautic\PluginBundle\Helper\IntegrationHelper;
use Mautic\PluginBundle\Entity\Integration;
use Mautic\PluginBundle\Entity\Plugin;

use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client as HttpClient;

class TrellApiServiceTest extends TestCase
{
    const MOCK_API_HOST     = 'http://127.0.0.1:4010';
    const MOCK_API_KEY      = 'KEY';
    const MOCK_API_TOKEN    = 'TOKEN';
    const MOCK_FAV_BOARD    = 'testboard';

    /**
     * @var TrelloApiService
     */
    protected $apiService;

    protected function setUp() :void
    {
        parent::setUp();

        $monolog = new Logger('test');
        $this->apiService = $this->getMockBuilder(TrelloApiService::class)
            ->setMethods(['getApi', 'getFavouriteBoard'])
            ->setConstructorArgs([
                $this->createMock(IntegrationHelper::class),
                $this->createMock(CoreParametersHelper::class),
                $monolog,
            ])
            ->getMock();

        $config = new Configuration();
        $config->setHost(self::MOCK_API_HOST);
        $config->setApiKey('key', self::MOCK_API_KEY);
        $config->setApiKey('token', self::MOCK_API_TOKEN);

        $this->apiService->method('getApi')
            ->willReturn(new DefaultApi(
                new HttpClient(),
                $config
            ));
        $this->apiService->method('getFavouriteBoard')
            ->willReturn(self::MOCK_FAV_BOARD);
    }

    /**
     * Get valid Trello lists from mocked API
     */
    public function testGetListsOnBoard() :void
    {
        $lists = $this->apiService->getListsOnBoard();
        $this->assertGreaterThan(0, count($lists));
        foreach ($lists as $list) {
            $this->assertInstanceOf(TrelloList::class, $list);
            $this->assertTrue($list->valid());
        }
    }
}
