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
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Response;

use Mautic\LeadBundle\Entity\Lead;

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
     * @return View
     */
    public function addCardAction()
    {
        $request = $this->get('request_stack')->getCurrentRequest();
        // $_POST
        $post = $request->request->all();
        $data = array();
        $code = Codes::HTTP_BAD_REQUEST;

        // Check if a parameter exists
        if ( isset($post['ids']) && is_array($post['ids']) ) {
            // 71 = adrian@idea2.ch
            foreach( $post['ids'] as $id ){
                $contact  = $this->getExistingContact($id);
                $data[]     = $this->getTrelloData($contact);
            }
            $code = Codes::HTTP_OK;
        }

        $view    = $this->view($data, $code);
        $context = SerializationContext::create()->setGroups(['leadDetails']);
        $view->setSerializationContext($context);

        return $this->handleView($view);
    }


    protected function getTrelloData( Lead $contact ) {
        $desc = array( $contact->getEmail(), $contact->getPhone(), $contact->getMobile(), $contact->getOwner()->getName());

        return array(
            'name' => $contact->getName(),
            'desc' => implode('\\n', $desc),
            'urlSource' => $this->coreParametersHelper->getParameter('site_url')."/s/contacts/view/".$contact->getId(),
            // 'idMembers' => ,
        );
    }

    protected function postTrelloCard($data = NULL) {
        $config = $this->getConfig();
        
        try {
            $client   = new Client(['timeout' => 15]);
            $response = $client->post(
                $config['post_url'],
                [
                    'form_params' => $payload,
                    'headers'     => $headers,
                ]
            );

            if ($redirect = $this->parseResponse($response, $matchedFields)) {
                $event->setPostSubmitCallbackResponse('form.repost', new RedirectResponse($redirect));
            }
        } catch (ServerException $exception) {
            $this->parseResponse($exception->getResponse(), $matchedFields);
        } catch (\Exception $exception) {
            if ($exception instanceof ValidationException) {
                if ($violations = $exception->getViolations()) {
                    throw $exception;
                }
            }
        }
    }

    /**
     * Get existing contact
     *
     * @param null $leadId
     *
     * @return Lead|null
     */
    protected function getExistingContact($leadId = null)
    {
        // maybe use Use $model->checkForDuplicateContact directly instead
        $leadModel = $this->getModel('lead');
        $lead = $leadModel->getEntity($leadId);
        
        $contact = $lead->getId() ? $lead : null;

        return $contact;
    }
    private function getConfig(){
        $config['authorization_key']    =   "9ef17425c93fae626ad969e282ddb409";
        $config['authorization_token']  =   "eff37dda8691f4f9a96de5d4bf6283e42ebc3870a6fce6c181ebf94ce74303a6";
        $config['post_url'] = "https://api.trello.com/1/cards";
        
        return $config;
    }
}
