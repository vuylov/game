<div id="game-content">
    <div class="person-information">
        <div class="game-panel-block game-panel-block-avatar">
            <img src="<?php echo Yii::app()->baseUrl.'/images/avatar.png' ?>">
        </div>
        <div class="game-panel-block"><span class="game-panel-block-name">ХОД</span><br><?php echo $step->step; ?></div>
        <div class="game-panel-block"><span class="game-panel-block-name">НАЛИЧНЫЕ</span><br><?php echo $step->deposit; ?></div>
        <div class="game-panel-block"><span class="game-panel-block-name">ЕЖЕХОДНЫЙ ДОХОД</span><br><?php echo ProgressIncome::getStepProgressIncome($step, true);?></div>
        <div class="game-panel-block"><span class="game-panel-block-name">
            ПРЕСТИЖ</span><br><?php echo $step->prestige; ?>
        </div>
        <div class="game-panel-block game-panel-block-stars"><span class="game-panel-block-name">
            УРОВЕНЬ<br></span><?php $this->widget('ext.Levels.GameLevel', array(
                'step' => $step,
            )); ?>
        </div>
    </div>
            <?php $this->widget('ext.GameField.GameField', array(
                'step' => $step,
            )); ?>
    <div class="next-step">
        <?php echo CHtml::ajaxLink('Следующий ход',
                    array('game/next'),
                    array(
                        'type'          => 'POST',
                        'beforeSend'    => 'function(){$(".next").attr("active", "diabled");$("#game-layout-overlay").fadeIn("fast"); $("#game-loader").fadeIn("fast");}',//TODO ADD LOADER
                        'success'       => 'function(response){$("#game-content").html(response);}',
                        'complete'      => 'function(){$(".next").attr("active", "enabled");$("#game-layout-overlay").fadeOut("fast");$("#game-loader").fadeOut("fast");}'
                    ),
                    array(
                        'id'        => mt_rand(1, 9999),
                        'class'     => 'next',
                        'active'    => 'enabled',  
                        )
                ); ?>
    </div>
    
    <div id="beforeEndContent"></div>    
<?php
/** Start Widget **/
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'shopDialog',
    'options'=>array(
        'autoOpen'=>false,
        
        'width' => 750,
        'appendTo' => '#beforeEndContent',
        'show'=>array(
                'effect'=>'blind',
                'duration'=>1000,
            ),
        'hide'=>array(
                'effect'=>'explode',
                'duration'=>500,
            ),
        'modal' => true,
        'position' => 'center top',
    ),
)); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog');
?>
    <div id="game-popup">
            <div id="popup-close-button">Закрыть</div>
        <div id="game-popup-content"></div>
    </div>
    <div id="game-layout-overlay"></div>
    <div id="game-loader"></div>
</div>