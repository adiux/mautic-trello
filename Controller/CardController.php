<?php
/**
 * @copyright   2020
 * @author      Idea2
 *
 * @see        https://www.idea2.ch
 */

namespace MauticPlugin\Idea2TrelloBundle\Controller;

use MauticPlugin\Idea2TrelloBundle\Openapi\Model\Card;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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

    public function newAction($contactId = null)
    {
        // creates a card and gives it some dummy data for this example
        $card = new Card();
        $card->setName('Write a blog post');
        // $card->setDueDate(new \DateTime('tomorrow'));

        $form = $this->createFormBuilder($card)
            ->add('name', TextType::class)
            // ->add('dueDate', DateType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Task'])
            ->getForm();
            // HelloWorldBundle:Contact:form.html.php
            // Idea2TrelloBundle:Card:addCard.html.php
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
