<?php
/**
 * @copyright   2020
 *
 * @author      Idea2
 *
 * @see        https://www.idea2.ch
 */

namespace MauticPlugin\Idea2TrelloBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Mautic\CoreBundle\Controller\FormController;

use MauticPlugin\Idea2TrelloBundle\Openapi\Model\Card;
use MauticPlugin\Idea2TrelloBundle\Form\CardType;

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
     * Build and Handle a new card
     *
     * @param [type] $contactId
     *
     * @return void
     */
    public function newAction($contactId = null)
    {
        // creates a card and gives it some dummy data for this example
        $card = new Card();
        $card->setName('Write a blog post');
        $card->setDue(new \DateTime('tomorrow'));

        $form = $this->createForm(CardType::class, $card);
            
        $request = $this->get('request_stack')->getCurrentRequest();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $task = $form->getData();

            // ... perform some action, such as saving the task to the database

            // return $this->redirectToRoute('task_success');
        }


        return $this->render('Idea2TrelloBundle:Card:new.html.twig', [
            'form' => $form->createView(),
        ]);
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
