<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Budget $budget
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Budget'), ['action' => 'edit', $budget->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Budget'), ['action' => 'delete', $budget->id], ['confirm' => __('Are you sure you want to delete # {0}?', $budget->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Budget'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Budget'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="budget view content">
            <h3><?= h($budget->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($budget->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Budget') ?></th>
                    <td><?= $this->Number->format($budget->budget) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date') ?></th>
                    <td><?= h($budget->date) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
