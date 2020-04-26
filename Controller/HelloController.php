<?php
/**
 * @copyright   2014 Mautic Contributors. All rights reserved.
 * @author      Mautic
 *
 * @see        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\Idea2TrelloBundle\Controller;

use Mautic\CoreBundle\Controller\FormController;

class HelloController extends FormController
{
    public function indexAction($page = 1)
    {
        return $this->delegateView(
            [
                'contentTemplate' => 'Idea2TrelloBundle:Hello:index.html.php',
            ]
        );
    }
}
