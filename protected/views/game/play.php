<div id="game-content">
    <?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="info">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
    <?php endif; ?>
    <div class="person-information">
        <img src="<?php echo Yii::app()->baseUrl.'/images/avatar.png' ?>" class="avatar">
        Текущий ход: <span id="step"><?php echo $step->step; ?><span>
        <span><b>Наличные</b>: <?php echo $step->deposit; ?></span>
        <span><b>Доход</b>: <?php echo Yii::app()->params['income']; ?></span>
        <span><b>Престиж</b>: <?php echo $step->prestige; ?></span>
        <span><b>Уровень</b>:<?php $this->widget('ext.Levels.GameLevel', array(
                'step' => $step,
            )); ?>
    </div>
    <?php $this->widget('ext.GameField.GameField', array(
                'step' => $step,
            )); ?>
    <div class="next-step">
        <?php echo CHtml::ajaxLink('Следующий ход',
                    array('game/next'),
                    array(
                        'type'          => 'POST',
                        'beforeSend'    => 'function(){$(".next").attr("active", "diabled");}',//TODO ADD LOADER
                        'success'       => 'function(response){$("#game-content").html(response);}',
                        'complete'      => 'function(){$(".next").attr("active", "enabled");}'
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
        <div class="popup-buttons">
            <div id="popup-close-button">Закрыть</div>
        </div>
        <div id="game-popup-content"></div>
    </div>
    <div id="game-layout-overlay"></div>
</div>