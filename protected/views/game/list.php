<h2 style="text-align: center">Мои игры</h2>
<table>
    <tr class="caption">
        <td>#</td><td>Дата начала</td><td>Статус</td><td>Набранные очки</td><td>Действие</td>
    </tr>
<?php $i =1;?>
<?php foreach ($games as $game):?>
    <tr>
        <td><?php echo $i;?></td>
        <td><?php echo $game->date_create; ?></td>
        <td>
            <?php echo ((int)$game->status === 1)?"В процессе":"Закончена";?>
        </td>
        <td>
            <?php if((int)$game->status === 0):?>
                <?php printf("%d", $game->scores)?>
            <?php endif;?>
        </td>
        <td>
            <?php if((int)$game->status === 1):?>
                <?php echo CHtml::link('Продолжить', array('game/play', 'id'=>$game->id)); ?> | <?php echo CHtml::link('Закончить', array('game/end', 'id'=>$game->id)); ?>
            <?php endif;?>
        </td>
    </tr>
    <?php $i++;?>
<?php endforeach; ?>
</table>
<div>
    <?php echo CHtml::link('Начать новую игру', array('game/create')); ?>
</div>