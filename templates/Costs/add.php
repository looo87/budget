<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cost $cost
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Costs'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="costs form content">
            <?= $this->Form->create($cost) ?>
            <fieldset>
                <legend><?= __('Add Cost') ?></legend>
                <?php
                    echo $this->Form->control('date');
                    echo $this->Form->control('costs');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
