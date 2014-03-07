<div class="game-tips">
    <div>
        <img src="<?php echo Yii::app()->baseUrl.'/images/lamp_100.jpg';?>" style="float:left;">
        <div class="game-tip-description"><?php echo $tip->description; ?></div>
    </div>
    <div class="row game-button-panel">
        <?php echo CHtml::ajaxLink(
                'Еще...', 
                Yii::app()->createUrl('game/tip'), 
                array(
                    'success'=>'function(response){$("#game-popup-content").html(response);}'
                    ),
                array(
                    'id'    => mt_rand(1, 10000),
                    'class' => 'game-tool-button',
                    ));?>
    </div>
</div>