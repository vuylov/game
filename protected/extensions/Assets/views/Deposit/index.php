<?php
    $procent    = $asset->tool->userConfig->procent * 100;
    $close      = $asset->step_end - $step->step;
?>
<tr>
    <td>
        <?php echo $asset->tool->name; ?>
        <p class="tool-note-detail">Сумма вклада: <?php echo $asset->balance_start; ?>. Процентная ставка: <?php echo $procent; ?>%
            Вклад будет закрыт через: <?php echo $close; ?> хода(ов)</p>
    </td>
    <td><?php echo $asset->balance_end; ?></td>
    <td>-</td>
    <td>-</td>
</tr>
 	