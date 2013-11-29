<div class="worth">
    <img class="worth-img" src="<?php echo $action->worth->image; ?>" alt="<?php echo $worth->name; ?>">
    <?php echo $action->worth->name; ?>
    <?php echo $action->worth->description; ?>
    <div class="action-sell">
        <?php
            echo CHtml::ajaxLink('Хотите продать за '.$action->worth->price_sell.'?',
                    $this->createUrl('game/sell', array('id' => $action->id)),
                    array('success'=>'function(response){$("#shopDialog").dialog("destroy");$("#game-content").html(response);}'),
                    array(
                        'id'=>  mt_rand(1, 999),
                        'confirm' => 'Вы хорошо подумали?'
                        )
                    );
        ?>
    </div> 
</div>