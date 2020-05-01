<?php

/*
 * @copyright   2014 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\Idea2TrelloBundle\Integration;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Mautic\PluginBundle\Integration\AbstractIntegration;

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
     * @return string
     */
    public function getDisplayName()
    {
        return 'Trello';
    }

    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public function getRequiredKeyFields()
    {
        return [
            'apikey'       => 'mautic.integration.trello.apikey',
            'apitoken'  => 'mautic.integration.trello.apitoken',
        ];
    }

    /**
     * The "username"
     * @return string
     */
    public function getClientIdKey()
    {
        return 'apikey';
    }

    /**
     * The "password"
     *
     * {@inheritdoc}
     *
     * @return array
     */
    public function getSecretKeys()
    {
        return [
            'apitoken',
        ];
    }

    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function isAuthorized()
    {
        $keys = $this->getKeys();
        
        return $keys;
    }

    /**
     * @return array
     */
    public function getFormSettings()
    {
        return [
            'requires_callback'      => false,
            'requires_authorization' => true,
        ];
    }
}
