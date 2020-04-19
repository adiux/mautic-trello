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
        print '<pre>';
        print '<h1>contactId</h1>';
        print_r( $contactId );
        print '</pre>'; exit;
        $logger = $this->get('monolog.logger.mautic');
        $request = $this->get('request_stack')->getCurrentRequest();
        // $_GET
        
        $logger->info('got request with id', array($contactId));
        $data = array();

        // Check if a parameter exists
        if (isset($contactId)) {
            // create a card for every contact
            // foreach ($post['ids'] as $id) {
                // $contact  = $this->getExistingContact($id);
                // $data     = $this->getTrelloData($contact);
                // $card = $this->postTrelloCard($data);
                // if (true !== $card) {
                //     $logger->info('could not add trello card for: '.$contact->getId().': '.$card);

                //     return $this->badRequest('Could not create card: '.$card);
                // } else {
                //     $logger->info('added trello card: '.$contact->getId());
                // }
            // }
        } else {
            $logger->warning('bad request');

            // return $this->badRequest();
        }

        return $this->delegateView(
            [
                'viewParameters' => [
                    'ids' => $contactId,
                ],
                'contentTemplate' => 'Idea2TrelloBundle:Card:addCard.html.php',
            ]
        );
        // return $this->delegateView(
        //     [
        //         'contentTemplate' => 'Idea2TrelloBundle:Hello:index.html.php',
        //     ]
        // );
    }


    protected function getTrelloData(Lead $contact)
    {
        $desc = array( $contact->getEmail(), $contact->getPhone(), $contact->getMobile(), $contact->getOwner()->getName());

        return array(
            'name' => $contact->getName(),
            'desc' => implode('\\n', $desc),
            'idList' => $this->getTrelloListId($contact->getStage()->getName()),
            'urlSource' => $this->coreParametersHelper->getParameter('site_url')."/s/contacts/view/".$contact->getId(),
            // 'idMembers' => ,
        );
    }

    protected function postTrelloCard($data = null)
    {
        $config = $this->getConfig();
        $postUrl    = $this->getPostUrl($data);
        $headers = $this->getHeaders();
        
        try {
            $client   = new Client(['timeout' => 15]);
            $response = $client->post(
                $postUrl,
                [
                    'headers'     => $headers,
                ]
            );
            
            return $this->parseResponse($response);
        } catch (ServerException $exception) {
            $this->parseResponse($exception->getResponse());
        } catch (\Exception $exception) {
             return $exception->getMessage();
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
    protected function getTrelloListId($listName)
    {
        $lists = $this->getListsOnBoard();
        foreach ($lists as $list) {
            if ($list['name'] === $listName) {
                return $list['id'];
            }
        }
        throw new \InvalidArgumentException($listName.' is not a valid list name.');
    }
    protected function getConfig()
    {
        $config['authorization_key']    =   "9ef17425c93fae626ad969e282ddb409";
        $config['authorization_token']  =   "eff37dda8691f4f9a96de5d4bf6283e42ebc3870a6fce6c181ebf94ce74303a6";
        $config['base_url'] = "https://api.trello.com/1/cards";
        
        return $config;
    }
    protected function getPostUrl($data)
    {
        $config = $this->getConfig();
        $params = array();
        foreach ($data as $key => $value) {
            $params[] = $key."=".urlencode($value);
        }
        $params[] = 'key='.$config['authorization_key'];
        $params[] = 'token='.$config['authorization_token'];
        $urlParams = \implode('&', $params);

        return $config['base_url'].'?'.$urlParams;
    }
    protected function getHeaders()
    {
        return array(
            // 'X-Forwarded-For' => $event->getSubmission()->getIpAddress()->getIpAddress(),
        );
    }
    protected function getListsOnBoard()
    {
        return array(
            array(
                "id" => "5e5c1f8f49c26f3ef8b6eba4",
                "name" => "1. Lead",
                "pos" => 65535,
            ),
            array(
                "id" => "5e5c1f9aa8fe55462a918ceb",
                "name" => "2. Lead Magnet",
                "pos" => 131071,
            ),
            array(
                "id" => "5e5c1f9e8ba0a9406069f3a8",
                "name" => "3. Trip Wire",
                "pos" => 196607,
            ),
            array(
                "id" => "5e5c1fa1c959c2221c1d9bc2",
                "name" => "4. Core",
                "pos" => 262143,
            ),
            array(
                "id" => "5e5c1fa6f8a36f344a4942fe",
                "name" => "5. High Margin",
                "pos" => 327679,
            ),
        );
    }
    protected function getBoards()
    {
        // return array(
        //     {
        //         "name"=> "Archiv Smolio",
        //         "id"=> "5afab32a2cac9d17c24f42e6"
        //     },
        //     {
        //         "name"=> "FIRE",
        //         "id"=> "5ca4fed602d6c1779e8c8329"
        //     },
        //     {
        //         "name"=> "Feedback zur App",
        //         "id"=> "57aa143cebcbc0d62c88252d"
        //     },
        //     {
        //         "name"=> "Haugan Bookings",
        //         "id"=> "5c665f0863d2856bbddbc909"
        //     },
        //     {
        //         "name"=> "Haugan Cruises ejecución",
        //         "id"=> "5ccfe30ee967973f586c0d57"
        //     },
        //     {
        //         "name"=> "Haugan Online Marketing",
        //         "id"=> "5d5beecc1e231d1833c25a8e"
        //     },
        //     {
        //         "name"=> "I2 Sales Funnel",
        //         "id"=> "5e5c1f7d35b240381adccdcb"
        //     },
        //     {
        //         "name"=> "Idea2 Funnel",
        //         "id"=> "5a7ecebb108924f49084b0a8"
        //     },
        //     {
        //         "name"=> "Müsli",
        //         "id"=> "58d011c09137aa8c10dc74d8"
        //     },
        //     {
        //         "name"=> "Palmazul",
        //         "id"=> "5ab210100d2c8db614576cf2"
        //     },
        //     {
        //         "name"=> "Rutishauser Antiquitäten",
        //         "id"=> "5c3ddda8c4de1c645f766db8"
        //     },
        //     {
        //         "name"=> "Salesfunnel CXwin",
        //         "id"=> "5b050a66d32db5d3e46d34a1"
        //     },
        //     {
        //         "name"=> "Smolio Customer Gains, Pains, VP",
        //         "id"=> "5858515cacc98cf4ebb41fcd"
        //     },
        //     {
        //         "name"=> "Smolio EPICs",
        //         "id"=> "5afaae8bec86a004a1702253"
        //     },
        //     {
        //         "name"=> "Smolio Stories",
        //         "id"=> "552d6c1b2e57998b345df391"
        //     },
        //     {
        //         "name"=> "Stakeholder",
        //         "id"=> "579b1fcb126b849d194f5fdb"
        //     },
        //     {
        //         "name"=> "Weekly",
        //         "id"=> "5afaaa1f72fd9ab940d19d22"
        //     },
        //     {
        //         "name"=> "Welcome Board",
        //         "id"=> "552d6bdb15755665d06cc4d5"
        //     }
        // );
    }
     /**
     * @return bool|mixed
     */
    private function parseResponse(Response $response): bool
    {
        $body       = (string) $response->getBody();
        $error      = false;

        if ($json = json_decode($body, true)) {
            $body = $json;
        } elseif ($params = parse_str($body)) {
            $body = $params;
        }

        if (is_array($body)) {
            if (isset($body['error'])) {
                $error = $body['error'];
            } elseif (isset($body['errors'])) {
                $error = implode(', ', $body['errors']);
            }
        }

        if (!$error && 200 !== $response->getStatusCode()) {
            $error = (string) $response->getBody();
        }

        if ($error) {
            throw new \InvalidArgumentException('Could not create Trello card: '.$error);
        }

        return true;
    }
}
