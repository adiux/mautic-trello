<?php

/**
 * @author    Aivie
 * @copyright 2022 Aivie. All rights reserved
 *
 * @see https://aivie.ch
 *
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
?>
<?php echo $view['form']->start($form); ?>
<div class="row">
    <div class="col-xs-12">
        <?php echo $view['form']->row($form['name']); ?>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <?php echo $view['form']->row($form['desc']); ?>
    </div>
</div>
<div class="row">
    <div class="col-xs-6">
        <?php echo $view['form']->row($form['idList']); ?>
    </div>
    <div class="col-xs-6">
        <?php echo $view['form']->row($form['due']); ?>
    </div>
</div>

<?php echo $view['form']->row($form['buttons']); ?>
<?php echo $view['form']->end($form);
