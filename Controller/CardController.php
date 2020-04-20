<?php
/**
 * @copyright   2020
 *
 * @author      Idea2
 *
 * @see        https://www.idea2.ch
 */

namespace MauticPlugin\Idea2TrelloBundle\Controller;

// namespace MauticPlugin\Idea2TrelloBundle;
// namespace Mautic\LeadBundle\Controller\Api;

use FOS\RestBundle\Util\Codes;
use JMS\Serializer\SerializationContext;
use Mautic\CoreBundle\Controller\FormController;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Response;

use Mautic\LeadBundle\Entity\Lead;

class CardController extends FormController
{
    public function indexAction($page = 1)
    {
        return $this->delegateView(
            [
                'contentTemplate' => 'Idea2TrelloBundle:Hello:index.html.php',
            ]
        );
    }

    /**
     * @return JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction($contactId = null)
    {
        
        $logger = $this->get('monolog.logger.mautic');
        $request = $this->get('request_stack')->getCurrentRequest();
        // $_GET
        
        $logger->info('got request with id', array($contactId));
        $data = array();

        // Check if a parameter exists
        if (isset($contactId)) {
            
        } else {
            $logger->warning('bad request');

            // return $this->badRequest();
        }

        return $this->delegateView(
            [
                'viewParameters' => [
                    'contactIds' => $contactId,
                ],
                'contentTemplate' => 'Idea2TrelloBundle:Card:addCard.html.php',
            ]
        );
    }

}
