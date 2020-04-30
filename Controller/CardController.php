<?php
/**
 * @copyright   2020
 *
 * @author      Idea2
 *
 * @see        https://www.idea2.ch
 */

namespace MauticPlugin\Idea2TrelloBundle\Controller;

use GuzzleHttp\Client as HttpClient;
use Mautic\CoreBundle\Controller\FormController;
use MauticPlugin\Idea2TrelloBundle\Form\NewCardType;
use MauticPlugin\Idea2TrelloBundle\Openapi\lib\Api\DefaultApi;
use MauticPlugin\Idea2TrelloBundle\Openapi\lib\Configuration;
use MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\NewCard;
use Symfony\Component\Asset\Exception\InvalidArgumentException;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\Forms;
use Symfony\Component\HttpFoundation\Request;

/**
 * Setup a a form and send it to Trello to create a new card.
 */
class CardController extends FormController
{
    /**
     * Logger.
     *
     * @var Monolog\Logger
     */
    protected $logger;

    /**
     * Fallback.
     *
     * @param int $page
     *
     * @return void
     */
    public function indexAction($page = 1)
    {
        return $this->delegateView(
            [
                'contentTemplate' => 'Idea2TrelloBundle:Hello:index.html.php',
            ]
        );
    }

    /**
     * Build and Handle a new card.
     *
     * @param [type] $contactId
     *
     * @return void
     */
    public function addAction($contactId = null)
    {
        $this->logger = $this->get('monolog.logger.mautic');
        $request = $this->get('request_stack')->getCurrentRequest();

        $this->logger->warning('got request with id', [$contactId]);
        // $this->logger->warning('request', );

        // creates a card and gives it some dummy data for this example
        $form = $this->getForm();

        // process form data from HTTP variables
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->handleSubmitted($form);
        }

        return $this->handleReturn($form);
        // return $this->render('Idea2TrelloBundle:Card:new.html.twig', [
        //     'form' => $form->createView(),
        // ]);
    }

    /**
     * Build a form.
     *
     * @return Forms
     */
    protected function getForm(): Form
    {
        $card = new NewCard();
        $card->setName('Write a blog post');
        $card->setDue(new \DateTime('tomorrow'));

        return $form = $this->createForm(NewCardType::class, $card);
    }

    /**
     * All the business logic for a submitted form.
     *
     * @param Forms $form
     *
     * @return void
     */
    protected function handleSubmitted(Form $form)
    {
        // $flashBag = $this->get('session')->getFlashBag();
        $newCard = $form->getData();

        if (!$newCard->valid()) {
            $invalid = current($newCard->listInvalidProperties());
            $message = sprintf('New card data not valid: %s', $invalid);
            // $this->addFlash($message, array(), 'error');
            throw new InvalidArgumentException($message);
            $this->logger->warning($message);

            return false;
        }

        $api = $this->getApi();

        
        //merge data with auth
        $cardArray = json_decode( $newCard->__toString(), true );
        // get only id of list
        $cardArray['idList'] = $form->get('idList')->getData()->getId();
        
        $requestData = array_merge($cardArray, $this->getAuthParams());

        try {
            $card = $api->addCard($requestData);
            $this->logger->warning('posted card with data', $requestData);
        } catch (InvalidArgumentException $e) {
            $this->logger->warning($e->getMessage(), $e->getTrace());
            $error = new Error();
            $error->setCode('InvalidArgument');
            $error->setMessage($e->getMessage());

            return new WP_REST_Response(\Idea2\Plugin\to_json($error), 500);
        } catch (Exception $e) {
            $this->logger->error($e->getMessage(), $e->getTrace());
        }

        // return $this->redirectToRoute('task_success');
    }

    /**
     * Return a view.
     *
     * @return void
     */
    protected function handleReturn(Form $form)
    {
        return $this->delegateView(
            [
                'viewParameters' => [
                    'form' => $form->createView(),
                ],
                'contentTemplate' => 'Idea2TrelloBundle:Card:new.html.twig',
            ]
        );
    }

    // protected function getTrelloData(Lead $contact)
    // {
    //     $desc = [$contact->getEmail(), $contact->getPhone(), $contact->getMobile(), $contact->getOwner()->getName()];

    //     $stage = $contact->getStage();
    //     if (empty($stage) || empty($stage->getName())) {
    //         return null;
    //     }

    //     return [
    //         'name' => $contact->getName(),
    //         'desc' => implode('\\n', $desc),
    //         'idList' => $this->getTrelloListId($stage->getName()),
    //         'urlSource' => $this->coreParametersHelper->getParameter('site_url').'/s/contacts/view/'.$contact->getId(),
    //         // 'idMembers' => ,
    //     ];
    // }

    /**
     * Return the Api for the Orders.
     *
     * @return \Openapi\lib\Api\DefaultApi $api
     */
    protected function getApi()
    {
        $config = Configuration::getDefaultConfiguration()
                    ->setHost('https://api.trello.com/1');

        $api = new DefaultApi(
            new HttpClient(),
            $config,
            null,
            2
        );

        return $api;
    }
    /**
     * Get the user specific auth params of the Trello API to add to the post part
     *
     * @return void
     */
    protected function getAuthParams()
    {
        return array(
        "key" => '9ef17425c93fae626ad969e282ddb409',
        "token" => 'eff37dda8691f4f9a96de5d4bf6283e42ebc3870a6fce6c181ebf94ce74303a6', );
    }
}
