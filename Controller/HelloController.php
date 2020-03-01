<?php
/**
 * @package     Mautic
 * @copyright   2014 Mautic Contributors. All rights reserved.
 * @author      Mautic
 * @link        http://mautic.org
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\Idea2TrelloBundle\Controller;

use Mautic\CoreBundle\Controller\FormController;
use Mautic\CampaignBundle\Entity\Campaign;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class HelloController extends FormController
{
	public function indexAction($page = 1)
    {
    	return $this->delegateView(
            array(
                'contentTemplate' => 'Idea2TrelloBundle:Hello:index.html.php',
            )
        );
    }
}