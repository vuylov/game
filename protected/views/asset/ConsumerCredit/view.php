<div class = "row">
    <?php echo $tool->name; ?>
</div>
<div class="row">
    Процентная ставка: 
        <?php $procent = $tool->getProcent() * 100;
        echo $procent.'%';
        ?>
</div>
<div class="row">
    Сумма кредита: <?php echo $asset->balance_start; ?>
</div>
<div class="row">
    Остаток для погашения: <?php echo $asset->balance_end; ?>
</div>
<div class="row">
    Срок погашения: <?php $elapsedSteps =  $asset->step_end - $progress->step;
                    echo $elapsedSteps; ?>
</div>
<div class="row">
    Ежемесяный платеж: 
        <?php
            echo $tool->monthPayment($tool->getProcent(), $asset->step_end - $asset->step_start, $asset->balance_start);
        ?>
</div>
<div class="row">
    <?php
        echo CHtml::ajaxLink(
                'Погасить досрочно', 
                Yii::app()->createUrl('consumerCredit/close', array('id' => $asset->id)),
                array('success' => 'function(response){$("#shopDialog").html(response).dialog("open"); return false;}'), 
                array('id'=>mt_rand(1, 999)));
    ?>
    <?php echo CHtml::link('Закрыть', '#', array(
            'onclick'=>'$("#shopDialog").dialog("close");'
        )); ?>
</div>