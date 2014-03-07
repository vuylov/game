
<?php foreach ($activities as $action): ?>
<tr>
    <td>
        <?php if((int)$action->worth->status === 0)://аренда жилья?>
            <?php echo $action->worth->name; ?>
        <?php else:?>
            <?php
            echo CHtml::ajaxLink('<img src="'.$action->worth->image.'">',
                    Yii::app()->createAbsoluteUrl('game/worthView', array('id'=>$action->id)),
                    array(
                        'success' => 'function(response){$("#game-popup-content").html(response); return false;}'
                    ),
                    array('id'=>mt_rand(1, 999))); 
        ?>
        <?php endif;?>
    </td>
    <td>
        <?php echo ($action->worth->price_sell)?$action->worth->price_sell:''; ?>
    </td>
    <td>
        <?php if($action->worth->costs):?>
            <?php foreach($action->worth->costs as $cost): ?>
                <?php echo ((int)$cost->value > 0)?$cost->value:''?>
            <?php endforeach;?>
        <?php else: ?>
        
        <?php endif;?>
    </td>
    <td>
         <?php if($action->worth->costs):?>
            <?php foreach($action->worth->costs as $cost): ?>
                <?php echo ((int)$cost->value < 0)?$cost->value:''?>
            <?php endforeach;?>
        <?php else: ?>
        <?php endif;?>
    </td>
    </tr>
<?php endforeach; ?>

<?php //CVarDumper::dump($activities, 10, true); ?>