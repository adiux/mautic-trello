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
    <?php // echo $view['router']->generate('plugin_helloworld_world', ['world' => 'mars']); ?>
    <form action="/api/trello/card" method="post">
        
        <label for="contact_ids">Contact Ids (comma separated): </label>
        <input type="text" id="contactIds" name="contactIds" value="<?php echo $contactIds; ?>"><br>
        <input type="submit" class="btn btn-primary" value="Create Contact in Trello">

    </form>
</div>
