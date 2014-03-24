<div class="worth">
    <span class="<?php echo $action->worth->css; ?>" style="float:left; margin-right: 5px"></span>
    <?php //echo $action->worth->name; ?>
    <?php echo $action->worth->description; ?>
    <?php if($action->worthInsures): ?>
        <?php 
            $insureRemains  = InsureRemainsCalculator::Calculate($progress, $action->worthInsures[0]);
            $totalPrice     = $action->worth->price_sell + $insureRemains;
            $title = 'Хотите продать за '.$totalPrice.'(в том числе, '.$action->worth->price_sell.' за '.$action->worth->name.', '.$insureRemains.' за страховку)?';
    ?>
    <?php else:?>
        <?php $title = 'Хотите продать за '.$action->worth->price_sell.'?';?>
    <?php endif;?>
    <div class="action-sell">
        <?php
            echo CHtml::ajaxLink($title,
                    $this->createUrl('game/sell', array('id' => $action->id)),
                    array('success'=>'function(response){$("#game-content").html(response);}'),
                    array('id'=>  mt_rand(1, 999))
                    );
        ?>
    </div> 
</div>