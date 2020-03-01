<?php
// plugins/Idea2TrelloBundle/Views/World/index.html.php

// Extend the base content
$view->extend('MauticCoreBundle:Default:content.html.php');

// Get tmpl from sub-template
$tmpl = $view['slots']->get('tmpl', 'Details');

// Tell Mautic to call JS onLoad method
//$view['slots']->set('mauticContent', 'helloWorld'.$tmpl);

// Set the page and header title
$header = ('World' == $tmpl)
    ? $view['translator']->trans(
        'plugin.helloworld.worlds',
        ['%world%' => ucfirst($world)]
    ) : $view['translator']->trans('plugin.helloworld.manage_worlds');
$view['slots']->set('headerTitle', $header);
?>

<div class="helloworld-content">
    <?php $view['slots']->output('_content'); ?>
    
    <form action="/create-trello-card.php" method="get">
        
        <label for="contact_ids">Contact Ids (comma separated): </label>
        <input type="text" id="contact_ids" name="contact_ids"><br>
        <input type="submit" class="btn btn-primary" value="Create Contact">

    </form>
    <a href="<?php echo $view['router']->generate('plugin_helloworld_world', ['world' => 'mars']); ?>" data-toggle="ajax" />Mars</a>
</div>
