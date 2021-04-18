<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cost[]|\Cake\Collection\CollectionInterface $costs
 */
?>
<div class="costs index content">
    <?= $this->Html->link(__('New Cost'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Costs') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('date') ?></th>
                    <th><?= $this->Paginator->sort('costs') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($costs as $cost): ?>
                <tr>
                    <td><?= $this->Number->format($cost->id) ?></td>
                    <td><?= h($cost->date) ?></td>
                    <td><?= $this->Number->format($cost->costs) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $cost->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $cost->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $cost->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cost->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
