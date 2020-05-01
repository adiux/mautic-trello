<?php

/*
 * @copyright  2014 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\Idea2TrelloBundle\Integration;

use Mautic\CoreBundle\Form\Type\YesNoButtonGroupType;
use Mautic\PluginBundle\Integration\AbstractIntegration;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Handle the setup and configuaration of the Mautic Trello integration
 */
class TrelloIntegration extends AbstractIntegration
{
    /**
     * Name of the integration, based on file name.
     *
     * @return void
     */
    public function getName()
    {
        return 'Trello';
    }

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
     * Return array of key => label elements that will be converted to inputs to
     * obtain from the user.
     *
     * @return array
     */
    public function getRequiredKeyFields()
    {
        // return [
        //     'apikey' => 'mautic.integration.clearbit.apikey',
        // ];
        return [
            'apikey' => 'mautic.integration.trello.appkey',
            'apitoken' => 'mautic.integration.trello.apitoken',
        ];
    }

    // /**
    //  * @param FormBuilder|Form $builder
    //  * @param array            $data
    //  * @param string           $formArea
    //  */
    // public function appendToForm(&$builder, $data, $formArea)
    // {
    //     if ('keys' === $formArea) {
    //         $builder->add(
    //             'auto_update',
    //             YesNoButtonGroupType::class,
    //             [
    //                 'label' => 'mautic.plugin.clearbit.auto_update',
    //                 'data'  => (isset($data['auto_update'])) ? (bool) $data['auto_update'] : false,
    //                 'attr'  => [
    //                     'tooltip' => 'mautic.plugin.clearbit.auto_update.tooltip',
    //                 ],
    //             ]
    //         );
    //     }
    // }


    // public function shouldAutoUpdate()
    // {
    //     $featureSettings = $this->getKeys();

    //     return (isset($featureSettings['auto_update'])) ? (bool) $featureSettings['auto_update'] : false;
    // }

    /**
     * {@inheritdoc}
     *
     * @param $section
     *
     * @return string|array
     */
    // public function getFormNotes($section)
    // {
    //     if ('custom' === $section) {
    //         return [
    //             'template'   => 'Idea2TrelloBundle:Integration:form.html.php',
    //             'parameters' => [
    //                 'mauticUrl' => $this->router->generate(
    //                     'mautic_plugin_clearbit_index', [], UrlGeneratorInterface::ABSOLUTE_URL
    //                 ),
    //             ],
    //         ];
    //     }

    //     return parent::getFormNotes($section);
    // }
}
