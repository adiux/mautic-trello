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

use Mautic\CoreBundle\Helper\CoreParametersHelper;
use Mautic\PluginBundle\Helper\IntegrationHelper;
use Mautic\PluginBundle\Entity\Integration;
use Mautic\PluginBundle\Entity\Plugin;

use Monolog\Logger;
use PHPUnit\Framework\TestCase;

class TrellApiServiceTest extends TestCase
{
    public function testGetListsOnBoard()
    {

        $monolog = new Logger('test');
        $monolog->info("test");
        $apiService = $this->getMockBuilder(TrelloApiService::class)
            ->setMethods(['getAuthParams'])
            // ->disableOriginalConstructor()
            ->setConstructorArgs([
                $this->createMock(IntegrationHelper::class),
                $this->createMock(CoreParametersHelper::class),
                $monolog,
            ])
            ->getMock();

        $apiService->method('getAuthParams')
            ->willReturn(array(
                'key' => 'test',
                'token' => 'test',
            ));


        $api = $apiService->getApi();
        $this->assertInstanceOf(DefaultApi::class, $api);
    }
    // protected function setupIntegration()
    // {
    //     $plugin = new Plugin();
    //     $plugin->setName('Trello');
    //     $plugin->setDescription('Get Trello');
    //     $plugin->setBundle('Idea2TrelloBundle');
    //     $plugin->setVersion('1.0');
    //     $plugin->setAuthor('Mautic');

    //     $integration = new Integration();
    //     $integration->setName('Trello');
    //     $integration->setIsPublished(true);
    //     // $settings = array_merge(
    //     //     [
    //     //         'import' => [
    //     //             'enabled',
    //     //         ],
    //     //     ],
    //     //     $settings
    //     // );
    //     // $integration->setFeatureSettings($settings);
    //     // $integration->setSupportedFeatures($features);
    //     $integration->setPlugin($plugin);

    //     return $integration;
    // }
}
