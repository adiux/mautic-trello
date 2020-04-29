<?php
/**
 * @copyright   2020
 *
 * @author      Idea2
 *
 * @see        https://www.idea2.ch
 */

namespace MauticPlugin\Idea2TrelloBundle\Controller;

use Symfony\Component\Form\Forms;
use Symfony\Component\HttpFoundation\Request;

use Mautic\CoreBundle\Controller\FormController;

use MauticPlugin\Idea2TrelloBundle\Openapi\Configuration;
use MauticPlugin\Idea2TrelloBundle\Openapi\Model\NewCard;
use MauticPlugin\Idea2TrelloBundle\Form\NewCardType;

/**
 * Setup a a form and send it to Trello to create a new card
 */
class CardController extends FormController
{
    /**
     * Fallback
     *
     * @param integer $page
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

        $logger->warning('got request with id', [$contactId]);
        // $logger->warning('request', );

        // creates a card and gives it some dummy data for this example
        $this->getForm();

        // process form data from HTTP variables
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->handleSubmitted();
        }

        return $this->handleReturn();
        // return $this->render('Idea2TrelloBundle:Card:new.html.twig', [
        //     'form' => $form->createView(),
        // ]);
    }

    /**
     * Build a form
     *
     * @return Forms
     */
    protected function getForm():Forms
    {
        $card = new NewCard();
        $card->setName('Write a blog post');
        $card->setDue(new \DateTime('tomorrow'));

        return $form = $this->createForm(NewCardType::class, $card);
    }
    /**
     * All the business logic for a submitted form
     *
     * @param Forms $form
     *
     * @return void
     */
    protected function handleSubmitted(Forms $form)
    {
        // $form->getData() holds the submitted values
        // but, the original `$task` variable has also been updated
        $newCard = $form->getData();

        $valid = $this->validateRequestData($newCard);
        if (true !== $valid) {
            return $valid;
        }
        $api = $this->getApi();
        // ... perform some action, such as saving the task to the database
        $card = $api->addCard($newCard);
        $logger->warn('posted card');

        // return $this->redirectToRoute('task_success');
    }

    /**
     * Return a view
     *
     * @return void
     */
    protected function handleReturn()
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
    /**
     * Return the Api for the Orders
     *
     * @return \GboOrder\Api\DefaultApi $api
     */
    protected function getApi()
    {
        $config = Configuration::getDefaultConfiguration()
                    ->setHost('https://api.trello.com')
                    ->setUsername('9ef17425c93fae626ad969e282ddb409')
                    ->setPassword('eff37dda8691f4f9a96de5d4bf6283e42ebc3870a6fce6c181ebf94ce74303a6');

        $api = new DefaultApi(
            new HttpClient(),
            $config,
            null,
            2
        );

        return $api;
    }
}
