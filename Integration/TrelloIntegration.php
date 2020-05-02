<?php
declare(strict_types = 1);
/*
 * @copyright   2014 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\Idea2TrelloBundle\Integration;

// use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Mautic\PluginBundle\Integration\AbstractIntegration;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class TrelloIntegration.
 */
class TrelloIntegration extends AbstractIntegration
{
    private $authorzationError = '';

    /**
     * Return's authentication method such as oauth2, oauth1a, key, etc.
     *
     * @return string
     */
    public function getAuthenticationType()
    {
        return 'none';
    }
    /**
     * Returns the name of the social integration that must match the name of the file.
     *
     * @return string
     */
    public function getName()
    {
        return 'Trello';
    }

    /**
     * @return array
     */
    public function getFormSettings()
    {
        return [
            'requires_callback'      => true,
            'requires_authorization' => false,
        ];
    }

    /**
     * @param Form|FormBuilder $builder
     * @param array            $data
     * @param string           $formArea
     */
    public function appendToForm(&$builder, $data, $formArea)
    {
        // if ('keys' === $formArea) {
            $builder->add(
                'appkey',
                TextType::class,
                [
                    'label'    => 'mautic.integration.trello.appkey',
                    'attr'     => ['class'   => 'form-control'],
                    // 'data'     => empty($data['appkey']) ? '9aekadsf...' : $data['appkey'],
                    'required' => true,
                ]
            )->add(
                'apitoken',
                TextType::class,
                [
                    'label'    => 'mautic.integration.trello.apitoken',
                    'attr'     => ['class'   => 'form-control'],
                    // 'data'     => empty($data['apitoken']) ? '9aekadsf...' : $data['apitoken'],
                    'required' => true,
                ]
            );
        // }
    }
}
