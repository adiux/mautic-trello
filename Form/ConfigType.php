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
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ConfigType extends AbstractType
{
    protected $fieldModel;

    /**
     * ConfigType constructor.
     */
    public function __construct(FieldModel $fieldModel)
    {
        $this->fieldModel = $fieldModel;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $leadFields = $this->fieldModel->getFieldList(false, false);

        $builder->add(
            'favorite_board',
            TextType::class
        );
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'trello_config';
    }
}
