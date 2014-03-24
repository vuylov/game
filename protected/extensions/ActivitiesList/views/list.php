
<?php foreach ($activities as $action): ?>
<tr>
    <td>
        <?php if((int)$action->worth->status === 0)://аренда жилья?>
            <?php echo $action->worth->name; ?>
        <?php else:?>
            <?php $name =  '<span class="'.$action->worth->css.'"></span>';
                   if($action->worthInsures){
                       $name =  '<span class="'.$action->worth->css.'"><span class="lock"></span></span>';
                   }
            ?>
            <?php
            echo CHtml::ajaxLink($name,
                    Yii::app()->createAbsoluteUrl('game/worthView', array('id'=>$action->id)),
                    array(
                        'success' => 'function(response){$("#game-popup-content").html(response); return false;}'
                    ),
                    array('id'=>mt_rand(1, 999))); 
        ?>
        <?php endif;?>
    </td>
    <td>
        <?php if($action->worthInsures){
            $remains    = InsureRemainsCalculator::Calculate($progress, $action->worthInsures[0]);
            $totalPrice = $action->worth->price_sell + $remains;
            echo $totalPrice;
        }else{
            echo ($action->worth->price_sell)?$action->worth->price_sell:'';
        }?>
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
                <?php echo ((int)$cost->value < 0)?abs($cost->value):''?>
            <?php endforeach;?>
        <?php else: ?>
        <?php endif;?>
    </td>
    </tr>
<?php endforeach; ?>

<?php //CVarDumper::dump($activities, 10, true); ?>