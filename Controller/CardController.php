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

use FOS\RestBundle\Util\Codes;
use JMS\Serializer\SerializationContext;
use Mautic\ApiBundle\Controller\CommonApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CardController extends CommonApiController
{
    const MODEL_ID = 'lead.list';

    public function indexAction($page = 1)
    {
        return $this->delegateView(
            [
                'contentTemplate' => 'Idea2TrelloBundle:Hello:index.html.php',
            ]
        );
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function addCardAction()
    {
        // 71 = adrian@idea2.ch
        $data  = $this->getExistingLead(71);

        $view    = $this->view($data, Codes::HTTP_OK);
        $context = SerializationContext::create()->setGroups(['leadDetails']);
        $view->setSerializationContext($context);

        return $this->handleView($view);
    }

       /**
     * Get existing duplicated contact based on unique fields and the request data.
     *
     * @param null $leadId
     *
     * @return Lead|null
     *
     * @deprecated since 2.12.2, to be removed in 3.0.0. Use $model->checkForDuplicateContact directly instead
     */
    protected function getExistingLead($leadId = null)
    {
        $leadModel = $this->getModel('lead');
        $lead = $leadModel->getEntity($leadId);
        
        $contact = $lead->getId() ? $lead : null;

        return $contact;
    }
}
