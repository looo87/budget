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
            <?= $this->Html->link(__('Edit Cost'), ['action' => 'edit', $cost->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Cost'), ['action' => 'delete', $cost->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cost->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Costs'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Cost'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="costs view content">
            <h3><?= h($cost->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($cost->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Costs') ?></th>
                    <td><?= $this->Number->format($cost->costs) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date') ?></th>
                    <td><?= h($cost->date) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
