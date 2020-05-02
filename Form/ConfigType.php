<?php

/*
 * @copyright   2016 Mautic, Inc. All rights reserved
 * @author      Mautic, Inc
 *
 * @link        https://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\Idea2TrelloBundle\Form;

use Mautic\LeadBundle\Model\FieldModel;
use MauticPlugin\Idea2TrelloBundle\Service\TrelloApiService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Configure Trello integration in main Mautic Configiguration.
 */
class ConfigType extends AbstractType
{
    /**
     * @var TrelloApiService
     */
    private $apiService;

    protected $fieldModel;

    /**
     * ConfigType constructor.
     */
    public function __construct(FieldModel $fieldModel, TrelloApiService $trelloApiService)
    {
        $this->fieldModel = $fieldModel;
        $this->apiService = $trelloApiService;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $leadFields = $this->fieldModel->getFieldList(false, false);

        $builder->add(
            'favorite_board',
            ChoiceType::class,
            [
                'choices' => $this->getBoards(),
                'required' => false,
                'label_attr' => ['class' => 'control-label'],
                'attr' => ['class' => 'form-control'],
            ]
        );

        // $builder->add(
        //     '',
        //     ChoiceType::class,
        //     array(
        //         'choices' => ,
        //         'choice_value' => 'id',
        //         'choice_label' => 'name',
        //     )
        // );
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'trello_config';
    }

    /**
     * Get all Trello boards.
     *
     * @return void
     */
    protected function getBoards()
    {
        $api = $this->apiService->getApi();
        try {
            $fields = 'id,name';
            $filter = 'open';
            $boards = $api->getBoards($fields, $filter);
            $boardsArray = [];
            foreach ($boards as $board) {
                $boardsArray[$board->getName()] = $board->getId();
            }

            return $boardsArray;
        } catch (Exception $e) {
            echo 'Exception when calling DefaultApi->getBoards: ', $e->getMessage(), PHP_EOL;
        }
    }
}
