<?php
/**
 * @author    Idea2
 * @copyright 2020 Idea2 Collective GmbH. All rights reserved
 *
 * @see https://www.idea2.ch
 *
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
?>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo $view['translator']->trans('mautic.trello.config.tab.trello'); ?></h3>
    </div>
    <div class="panel-body">
        <?php foreach ($form->children as $f): ?>
            <div class="row">
                <div class="col-md-6">
                    <?php echo $view['form']->row($f); ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>