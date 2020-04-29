<?php
// https://symfony.com/doc/current/service_container.html#services-explicitly-configure-wire-services
// namespace Symfony\Component\DependencyInjection\Loader\Configurator;

// use App\Service\MessageGenerator;
// use App\Updates\SiteUpdateManager;

// return function(ContainerConfigurator $configurator) {
//     // ...

//     // site_update_manager.superadmin is the service's id
//     $services->set('site_update_manager.superadmin', SiteUpdateManager::class)
//         // you CAN still use autowiring: we just want to show what it looks like without
//         ->autowire(false)
//         // manually wire all arguments
//         ->args([
//             ref(MessageGenerator::class),
//             ref('mailer'),
//             'superadmin@example.com',
//         ]);

//     $services->set('site_update_manager.normal_users', SiteUpdateManager::class)
//         ->autowire(false)
//         ->args([
//             ref(MessageGenerator::class),
//             ref('mailer'),
//             'contact@example.com',
//         ]);

//     // Create an alias, so that - by default - if you type-hint SiteUpdateManager,
//     // the site_update_manager.superadmin will be used
//     $services->alias(SiteUpdateManager::class, 'site_update_manager.superadmin');
// };
