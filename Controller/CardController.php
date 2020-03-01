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
        $data  = ['html' => '', 'style' => ''];
        // $focus = $request->request->all();
        // $channelId = (int) $this->request->request->get('channelId');

        // if (isset($focus['focus'])) {
        //     $focusArray = InputHelper::_($focus['focus']);

        //     if (!empty($focusArray['style']) && !empty($focusArray['type'])) {
        //         /** @var \MauticPlugin\MauticFocusBundle\Model\FocusModel $model */
        //         $model            = $this->getModel('focus');
        //         $focusArray['id'] = 'preview';
        //         $data['html']     = $model->getContent($focusArray, true);
        //     }
        // }
        $view    = $this->view($data, Codes::HTTP_OK);
        $context = SerializationContext::create()->setGroups(['userList']);
        $view->setSerializationContext($context);
        return $this->handleView($view);
    }
    protected function getContacts(){
        $model   = $this->getModel('lead.list');
        $items = $model->getEntities(
            [
                'start'      => $start,
                'limit'      => $limit,
                'filter'     => $filter,
                'orderBy'    => $orderBy,
                'orderByDir' => $orderByDir,
            ]);
    }
}
