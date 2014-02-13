<?php define('TOOL_ACTIVE_STATUS', 1);?>
<?php if(!$pif):?>
    <div>Все паевые фонды закрыты</div>
<?php else: ?>
    <ul class="game-pifs">
    <?php foreach($pif->tools as $tool): ?>
        <?php if($tool->levelPrestige <= $progress->prestige & $tool->status == TOOL_ACTIVE_STATUS): ?>
            <li>
                <?php echo CHtml::ajaxLink($tool->name,
                                Yii::app()->createUrl('tool/use', array('id'=>$tool->id)),    
                                array(
                                'success' => 'function(response){$("#game-popup-content").html(response); return false;}'
                                ),
                                array('id'=>mt_rand(1, 999)));  ?>
            </li>
        <?php elseif($tool->levelPrestige <= $progress->prestige & $tool->status !== TOOL_ACTIVE_STATUS):?>
            <li><?php echo $tool->name; ?> не активен и Вам не доступен.</li>
        <?php else: ?>
            <li><?php echo $tool->name; ?> Вам не доступен. Необходимо набрать <?php echo $tool->levelPrestige; ?> очков престижа</li>
        <?php endif; ?>
    <?php endforeach;?>
    </ul>
<?php endif; ?>