<?php
/**
 * @copyright   2020
 *
 * @author      Idea2
 *
 * @see        https://www.idea2.ch
 */

namespace MauticPlugin\Idea2TrelloBundle\Controller;

use MauticPlugin\Idea2TrelloBundle\Openapi\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\Constraints as Assert;
use Mautic\CoreBundle\Controller\FormController;
use FOS\RestBundle\Util\Codes;
use JMS\Serializer\SerializationContext;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;

use MauticPlugin\Idea2TrelloBundle\Openapi\Model\NewCard;
use MauticPlugin\Idea2TrelloBundle\Form\NewCardType;

class CardController extends Controller
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
     * Build and Handle a new card
     *
     * @param [type] $contactId
     *
     * @return void
     */
    public function addAction($contactId = null)
    {
        $logger = $this->get('monolog.logger.mautic');
        $request = $this->get('request_stack')->getCurrentRequest();
        $server = $this->get('open_api_server.api.api_server');
        print '<pre>';
        print '<h1>server</h1>';
        print_r($server);
        print '</pre>';
        exit;

        $logger->warning('got request with id', [$contactId]);
        // $logger->warning('request', );

        // creates a card and gives it some dummy data for this example
        $card = new NewCard();
        $card->setName('Write a blog post');
        $card->setDue(new \DateTime('tomorrow'));

        $form = $this->createForm(NewCardType::class, $card);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $newCard = $form->getData();

            $valid = $this->validateRequestData($newCard);
            if (true !== $valid) {
                return $valid;
            }
            
            // ... perform some action, such as saving the task to the database
            $card = $this->postTrelloCard($newCard);
            $logger->warn('posted card')

            // return $this->redirectToRoute('task_success');
        }

        return $this->delegateView(
            [
                'viewParameters' => [
                    'form' => $form->createView(),
                ],
                'contentTemplate' => 'Idea2TrelloBundle:Card:new.html.twig',
            ]
        );
        // return $this->render('Idea2TrelloBundle:Card:new.html.twig', [
        //     'form' => $form->createView(),
        // ]);
    }

    /**
     * Post a card to Trello
     * Return true or error message
     *
     * @param [type] $data
     * @return void
     */
    protected function postTrelloCard( NewCard $card = null)
    {
        $config = $this->getConfig();
        $postUrl    = $this->getPostUrl($card);
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

    /**
     * Validates to true or Returns an Error Response
     *
     * @param Request $request
     *
     * @return true || Response
     */
    protected function validateRequestData(NewCard $newCard)
    {
        // Validate the input values
        // $asserts = [];
        // $asserts[] = new Assert\NotNull();
        // $asserts[] = new Assert\Type('MauticPlugin\\Idea2TrelloBundle\\Openapi\\Model\\NewCard');
        // $asserts[] = new Assert\Valid();
        // $response = $this->validate($newCard, $asserts);
        // if ($response instanceof Response) {
        //     return $response;
        // }
        if (empty($newCard->getName())) {
            return $this->badRequest('Name not set');
            // return new Response('Name not set', 400);
        }

        return true;
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
