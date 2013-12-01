<b><?php echo $asset->tool->name; ?></b>. Процентная ставка: 
	<?php
		$procent = $asset->tool->out_percent_total_max * 100;
		echo $procent.'%';
	?>
 Сумма вклада: <?php echo $asset->balance_start; ?>
 Капитализировано: <?php echo $asset->balance_end; ?>
 Вклад будет закрыт через: 
 	<?php
 		$elapsedSteps = $asset->step_end - $step->step;
 		echo $elapsedSteps;
 	 ?>