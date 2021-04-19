<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Budget $budget
 */
?>

<!DOCTYPE html>
<html>
<head>
    <?php $this->assign('title', 'Budget'); ?>
    <?= $this->Html->css(['home']) ?>
</head>
<body>
<div>
    <div class="budget-forms">
        <?= $this->Form->create(null, ['class' => 'budget-form', 'url' => '/addBudget']) ?>
        <label for="budget">Set budget</label>
        <?= $this->Form->control('budget', ['label' => false, 'required' => true, 'type' => 'number']) ?>
        <?= $this->Form->button('Set new budget') ?>
        <?= $this->Form->end() ?>

        <?= $this->Form->create(null, ['class' => 'pause-budget-form', 'url' => '/addBudget']) ?>
        <?= $this->Form->control('budget', ['label' => false, 'required' => true, 'type' => 'hidden', 'value' => '0']) ?>
        <?= $this->Form->button('Pause budget') ?>
        <?= $this->Form->end() ?>

        <?= $this->Form->create(null, ['class' => 'generate-costs-form', 'url' => '/generateCosts']) ?>
        <?= $this->Form->button('Generate costs') ?>
        <?= $this->Form->end() ?>
    </div>

    <form class="data-form" id="dataForm" data-action="">
        <div>
            <label for="startDate">Start date</label>
            <input type="date" id="startDate">
            <span class="separator">&mdash;</span>
            <label for="endDate">End date</label>
            <input type="date" id="endDate">
        </div>
        <button>Get data</button>
    </form>

    <table class="data-table">
        <thead>
        <tr>
            <th>Date</th>
            <th>Max budget</th>
            <th>Costs</th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
</body>
</html>
