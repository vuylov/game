<ul>
<?php foreach ($games as $game):?>
    <li><?php echo CHtml::link('Игра от '.$game->date_create, array('game/play', 'id'=>$game->id)); ?></li>
<?php endforeach; ?>
</ul>
<div>
    <?php echo CHtml::link('Начать новую игру', array('game/create')); ?>
</div>