<?php
/**
 * @var $lastBudget
 *
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
    <h3 class="current-cost">Current budget is set to <?= $lastBudget['budget'] ?></h3>
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

        <?= $this->Form->create(null, ['class' => 'history-data-form']) ?>
        <?= $this->Form->button('Get history', ['id' => 'getHistoryData']) ?>
        <?= $this->Form->end(); ?>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
            <tr>
                <th>Date</th>
                <th>Max budget</th>
                <th>Costs</th>
            </tr>
            </thead>
            <tbody id="setData">
            </tbody>
        </table>
    </div>
</div>

<script>
    let _setDataContainer = $("#setData");

    $("#getHistoryData").on("click", (e) => {
        e.preventDefault();

        _setDataContainer.html("");

        $.ajax('/showHistory.json').done((response) => {
            if (response.success) {
                response.data['finalData'].forEach((data, i) => {
                    let td_1 = document.createElement('td');
                    let td_2 = document.createElement('td');
                    let td_3 = document.createElement('td');
                    let tr = document.createElement('tr');

                    let dateTxtNode = document.createTextNode(data.date);
                    let maxBudgetTxtNode = document.createTextNode(data.maxBudget);
                    let costsTxtNode = document.createTextNode(data.dailyCosts);

                    td_1.appendChild(dateTxtNode);
                    td_2.appendChild(maxBudgetTxtNode);
                    td_3.appendChild(costsTxtNode);

                    tr.append(td_1, td_2, td_3);

                    _setDataContainer.append(tr);
                });
            }
        });
    });

</script>
</body>
</html>
