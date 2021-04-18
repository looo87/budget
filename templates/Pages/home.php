<!DOCTYPE html>
<html>
<head>
    <?php $this->assign('title', 'Budget'); ?>
    <?= $this->Html->css(['home']) ?>
</head>
<body>
<div>
    <form class="budget-form" id="budgetForm" data-action="">
            <label for="budget">Set budget</label>
            <input type="number" id="budget"/>
            <button class="active">Set new budget</button>
            <button>Pause budget</button>
    </form>

    <p class="generate-costs-container">
        <label>Generated costs</label>
        <span class="generated-costs"></span>
        <button class="generate-costs-button">Generate costs</button>
    </p>

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

    <table>
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
