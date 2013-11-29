<?php if($assets): ?>
    <div class="msg">
        У нас есть активы:<br>
        <ul>
            <?php foreach ($assets as $asset): ?>
            <li>
                <?php
                    $elpsedSteps = $asset->step_end - $step->step;
                    $procent = ($asset->tool->out_percent_total_min)*100;
                    echo $asset->tool->name.'. Процентная ставка: '.$procent.'%. Баланс: '.$asset->balance.' Осталось ходов: '.$elpsedSteps;
                ?>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php else: ?>
    <div class="msg">У нас нету ничего кроме зарплаты в <?php echo Yii::app()->params["income"]; ?> рублей</div>
<?php endif; ?>
