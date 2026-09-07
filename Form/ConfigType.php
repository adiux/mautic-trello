<?php

declare(strict_types=1);

namespace MauticPlugin\AivieTrelloBundle\Form;

use MauticPlugin\AivieTrelloBundle\Service\TrelloApiService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Configure Trello integration in main Mautic Configuration.
 */
class ConfigType extends AbstractType
{
    public function __construct(private TrelloApiService $apiService)
    {
    }

    /**
     * Creates the Settings section for Trello.
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'favorite_board',
            ChoiceType::class,
            [
                'choices'    => $this->getBoards(),
                'required'   => false,
                'label_attr' => ['class' => 'control-label'],
                'attr'       => ['class' => 'form-control'],
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return 'trello_config';
    }

    /**
     * Get all Trello boards.
     *
     * @return array<string, string>
     */
    protected function getBoards(): array
    {
        return array_flip($this->apiService->getBoardsArray());
    }
}
