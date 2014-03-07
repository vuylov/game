<div class="form-process">
<?php echo CHtml::beginForm('', 'post', array('id'=>'metal')); ?>
    <div class = "row">
        <?php echo $asset->tool->name; ?>
    </div>
    <div class = "row">
        Количество золота: <?php echo $asset->number; ?>
    </div>
    <div class="row">
        Текущая стоимость золота: <?php echo ShareRateManager::getLastRate($asset->tool_id, $progress); ?>
    </div>
    <div class="row">
        Обща стоимость: <?php echo $asset->balance_end; ?>
    </div>
    <div class="row">
        <?php echo CHtml::label('Укажите количество золота для продажи', 'amount_basic'); ?>
        <?php //echo CHtml::textField('Metal[number]', 0, array('id' => 'Metal')); ?>
    <input type="text" id="amount_basic" name="Metal[number]" class="game-form-textfield" readonly="readonly" />
    </div>
    <div>
         <?php $this->widget('zii.widgets.jui.CJuiSlider', array(
            'id'            => mt_rand(1, 9999), 
            'options'=>array(
                'min'=>1,
                'max'=>  $asset->number,
                'step'=>1,    
                'slide' => 'js:function( event, ui ) 
                    {$( "#amount_basic" ).val( ui.value );}',        
                ),
            'htmlOptions'=>array(
                'style'=>'height:12px; width:400px;'
            ),
        ));?>
    </div>
    <div class="row game-button-panel">
        <?php echo CHtml::ajaxLink('Продать золото',
                Yii::app()->createUrl('metal/sell'),
                array(
                    'type' => 'POST',
                    'data' => 'js:$("#metal").serialize()',
                    'beforeSend'=>'function(){var number = $("#amount_basic").val(); if(!number){return false;};}',
                    'success' => 'function(response){$("#game-popup-content").html(response); return false;}',
                ),
                array(
                    'id'    => mt_rand(1, 9999),
                    'class' => 'game-tool-button'
                    )); ?> 
    </div>
    <?php echo CHtml::hiddenField('Metal[id]', $asset->id); ?>
<?php echo CHtml::endForm(); ?>
</div>
