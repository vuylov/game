<b>
    <?php 
        echo CHtml::ajaxLink(
                $asset->tool->name, 
                Yii::app()->createUrl('asset/view', array('id' => $asset->id)), 
                array('success' => 'function(response){$("#shopDialog").html(response).dialog("open"); return false;}'),
                array('id'=>mt_rand(1, 9999)));
    ?>
</b>
. Процетная ставка: 
	<?php 
		$procent = $asset->tool->in_step_min*100; 
		echo $procent.'%';
	?>
 Сумма кредита: <?php echo $asset->balance_start; ?>
 Осталось погасить: <?php echo $asset->balance_end; ?> за 
 <?php
 	$elapsedSteps = $asset->step_end - $step->step;
 		echo $elapsedSteps;
  ?>
