<?php
// plugins/Idea2TrelloBundle/Views/World/index.html.php

// Extend the base content
$view->extend('MauticCoreBundle:Default:content.html.php');

// Get tmpl from sub-template
$tmpl = $view['slots']->get('tmpl', 'Details');

// Tell Mautic to call JS onLoad method
//$view['slots']->set('mauticContent', 'helloWorld'.$tmpl);

// Set the page and header title
$header = $view['translator']->trans('plugin.idea2trello.add_card_to_trello');
$view['slots']->set('headerTitle', $header);
?>

<div class="helloworld-content">
    <?php

    echo $this->render('Idea2TrelloBundle:Card:new.html.twig', [
         'form' => $form->createView(),
    ]);
    ?>
</div>
