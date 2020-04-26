<?php

// addons/Idea2TrelloBundle/Security/Permissions/HelloWorldPermissions.php

namespace MauticPlugin\Idea2TrelloBundle\Security\Permissions;

use Mautic\CoreBundle\Security\Permissions\AbstractPermissions;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class HelloWorldPermissions.
 */
class HelloWorldPermissions extends AbstractPermissions
{
    /**
     * Define available permissions.
     *
     * @param $params
     */
    public function __construct($params)
    {
        parent::__construct($params);

        $this->permissions = [
            // Custom level
            'worlds' => [
                // Custom permissions
                'use_telescope' => 1,
                'send_probe' => 2,
                'visit' => 4,
                // Full will almost always be included and should be significantly higher than the
                // others in case new permissions need to be added later
                'full' => 1024,
            ],
        ];

        // Add standard category permissions
        $this->addStandardPermissions('categories');
    }

    /**
     * Append the permission form fields to the Role form.
     */
    public function buildForm(FormBuilderInterface &$builder, array $options, array $data)
    {
        // Add standard category form fields
        $this->addStandardFormFields('helloWorld', 'categories', $builder, $data);

        // Add custom 'worlds' level form fields
        $builder->add(
            // Form element name should be bundleName:permissionLevel
            'helloWorld:worlds',

            // Should always be permissionlist type
            'permissionlist',
            [
                'choices' => [
                    'use_telescope' => 'plugin.helloworld.permissions.use_telescope',
                    'send_probe' => 'plugin.helloworld.permissions.send_probe',
                    'visit' => 'plugin.helloworld.permissions.visit',
                    'full' => 'mautic.core.permissions.full',
                ],
                'label' => 'plugin.helloworld.permissions',

                // Set existing data
                'data' => (!empty($data['worlds']) ? $data['worlds'] : []),

                // Bundle name (used to build frontend form)
                'bundle' => 'helloWorld',

                // Permission level (used to build frontend form)
                'level' => 'worlds',
            ]
        );
    }

    /**
     * Permission set identifier; should be bundleName.
     *
     * @return string
     */
    public function getName()
    {
        return 'helloworld';
    }
}
