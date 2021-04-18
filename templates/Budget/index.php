<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Budget[]|\Cake\Collection\CollectionInterface $budget
 */
?>
<div class="budget index content">
    <?= $this->Html->link(__('New Budget'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Budget') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('date') ?></th>
                    <th><?= $this->Paginator->sort('budget') ?></th>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($budget as $budget): ?>
                <tr>
                    <td><?= h($budget->date) ?></td>
                    <td><?= $this->Number->format($budget->budget) ?></td>
                    <td><?= $this->Number->format($budget->id) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $budget->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $budget->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $budget->id], ['confirm' => __('Are you sure you want to delete # {0}?', $budget->id)]) ?>
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
