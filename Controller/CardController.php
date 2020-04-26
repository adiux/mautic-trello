<?php
/**
 * @copyright   2020
 * @author      Idea2
 *
 * @see        https://www.idea2.ch
 */

namespace MauticPlugin\Idea2TrelloBundle\Controller;

// namespace MauticPlugin\Idea2TrelloBundle;
// namespace Mautic\LeadBundle\Controller\Api;

use Mautic\CoreBundle\Controller\FormController;

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
     * @param mixed|null $contactId
     *
     * @return JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction($contactId = null)
    {
        $logger = $this->get('monolog.logger.mautic');
        $request = $this->get('request_stack')->getCurrentRequest();
        // $_GET

        $logger->info('got request with id', [$contactId]);
        $data = [];

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
