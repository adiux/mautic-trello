<?php
// Extend the base content
$view->extend('MauticCoreBundle:Default:content.html.php');

// Get tmpl from sub-template
$tmpl = $view['slots']->get('tmpl', 'Details');

// Set the page and header title
$header = $view['translator']->trans('plugin.idea2trello.add_card_to_trello');
$view['slots']->set('headerTitle', $header);
?>

<div class="add-card-content">
    <?php
    echo $this->render('Idea2TrelloBundle:Card:new.html.twig', [
         'form' => $form->createView(),
    ]);
    ?>
</div>
