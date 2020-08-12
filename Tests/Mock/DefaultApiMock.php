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

namespace MauticPlugin\MauticTrelloBundle\Tests\Mock;
use MauticPlugin\MauticTrelloBundle\Openapi\lib\Model\TrelloList;

class DefaultApiMock
{
    public function getBoards()
    {
        
        $boards = file_get_contents($this->get('kernel')->getRootDir() . '/../web/assets/api/scientific-posters.json');
        // $boards = file_get_contents('/../Data/boards.json');
        $json = json_decode($boards, true);

        return $json;
    }
    public function getLists()
    {
        $lists = array();
        $file = dirname(__DIR__).'/Data/boards.json';
        $boards = file_get_contents($file, true);
        $json = json_decode($boards, true);
        foreach ($json as $list ){
            $lists[] = new TrelloList($list);
        }

        return $lists;
    }
    public function addCard()
    {
        // $boards = file_get_contents($this->get('kernel')->getRootDir() . '/../web/assets/api/scientific-posters.json');
        $boards = file_get_contents('/../Data/boards.json');
        $json = json_decode($boards, true);

        return $json;
    }
}
