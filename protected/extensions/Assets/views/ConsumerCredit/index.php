<b><?php echo $asset->tool->name; ?></b>. Процетная ставка: 
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
