<?php
    $credit  = ToolFactory::getTool($asset->tool->id, $step);
    $credit->setAsset($asset);
    $procent = $credit->getProcent() * 100;
    $payment = $credit->monthPayment($credit->getProcent(), $asset->step_end - $asset->step_start, $asset->balance_start);
    $remainsCredit  = round($asset->balance_end);
    $elapsedSteps   = $asset->step_end - $step->step;
?>
<tr>
    <td>
    <?php 
        echo CHtml::ajaxLink(
                $asset->tool->name, 
                Yii::app()->createUrl('asset/view', array('id' => $asset->id)), 
                array('success' => 'function(response){$("#game-popup-content").html(response); return false;}'),
                array('id'=>mt_rand(1, 9999)));
    ?>
    <p class="tool-note-detail">Сумма кредита: <?php echo $asset->balance_start; ?>. Процетная ставка: <?php echo $procent;?>%. 
        Осталось погасить: <?php echo round($asset->balance_end); ?> за <?php echo $elapsedSteps;  ?> хода(ов)</p>
    </td>
    <td> - </td>
    <td> -  </td>
    <td> <?php echo $payment; ?> </td>
</tr>