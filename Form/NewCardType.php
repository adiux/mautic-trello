<?php

declare(strict_types=1);
/**
 * @copyright   2020
 *
 * @author      Idea2
 *
 * @see        https://www.idea2.ch
 */

namespace MauticPlugin\Idea2TrelloBundle\Form;

use MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\NewCard;
use MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model\TrelloList;
use MauticPlugin\Idea2TrelloBundle\Service\TrelloApiService;
use Mautic\CoreBundle\Form\Type\FormButtonsType;
use Monolog\Logger;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewCardType extends AbstractType
{
    /**
     * @var TrelloApiService
     */
    private $apiService;
    /**
     * @var Logger
     */
    protected $logger;

    /**
     * Setup NewCard Form.
     */
    public function __construct(TrelloApiService $trelloApiService, Logger $logger)
    {
        $this->apiService = $trelloApiService;
        $this->logger = $logger;
    }

    /**
     * Define fields to display.
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label'      => 'mautic.core.title',
                'label_attr' => ['class' => 'control-label'],
                'attr'       => ['class' => 'form-control'],
            ))
            ->add(
                'desc',
                TextareaType::class,
                array(
                    'label'      => 'mautic.idea2trello.description',
                    'label_attr' => ['class' => 'control-label sr-only'],
                    'attr'       => ['class' => 'form-control', 'rows' => 5],
                )
            )
            ->add(
                'idList',
                ChoiceType::class,
                array(
                    'label'         => 'mautic.idea2trello.list',
                    'choices'       => $this->apiService->getListsOnBoard(),
                    'choice_value'  => 'id',
                    'choice_label'  => 'name',
                    'label_attr'    => ['class' => 'control-label'],
                    'attr'          => ['class' => 'form-control'],
                )
            )
            ->add(
                'due',
                DateTimeType::class,
                [
                    'label'      => 'mautic.idea2trello.duedate',
                    'label_attr' => ['class' => 'control-label'],
                    'widget'     => 'single_text',
                    'required'    => false,
                    'attr'       => [
                        'class'       => 'form-control',
                        'data-toggle' => 'datetime',
                        'preaddon'    => 'fa fa-calendar',
                    ],
                    'format' => 'yyyy-MM-dd HH:mm',
                    // 'data'   => $data,
                ]
            )
            ->add('buttons', FormButtonsType::class, [
                'apply_text' => false,
                'save_text'  => 'mautic.core.form.save',
            ]);
        if (!empty($options['action'])) {
            $builder->setAction($options['action']);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => NewCard::class,
        ]);
    }
}
