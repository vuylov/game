<?php if((int)$step->deposit === 0): ?>
<div>
    У вас недостаточно средств для использования инструмента "Депозит"
</div>
<?php else:?>
<div class="form-process">
<?php echo CHtml::beginForm('', 'post', array('id'=>'dep_')); ?>
    <div class="row tool-description">
        <?php echo $tool->description;?>
    </div>
    <hr>
    <div class="row">
        <?php echo CHtml::label('Укажите сумму для депозита', 'amount_deposit'); ?>
        <?php //echo CHtml::textField('Tool[money]', $tool->in_total_min, array('id' => 'deposit')); ?>
        <input type="text" id="amount_deposit" name="Tool[money]" readonly="readonly" class="game-form-textfield" value="<?php echo $tool->userConfig->base_price; ?>" />
    </div>
    <div>
         <?php $this->widget('zii.widgets.jui.CJuiSlider', array(
            'id'            => mt_rand(1, 9999), 
            'options'=>array(
                'min'=> (int)$tool->userConfig->base_price,
                'max'=> (int)$step->deposit,
                'step'=>((int)$step->deposit > 100000)?10000:(int)$tool->userConfig->base_price,    
                'slide' => 'js:function( event, ui ) 
                    {$( "#amount_deposit" ).val( ui.value );}',        
                ),
                'htmlOptions'=>array(
                    'style'=>'height:12px; width:400px;'
            ),
        ));?>
    </div>
    <div class="row">
        <?php echo CHtml::label('Укажите срок депозита (минимальный срок 1 шаг)', 'amount_steps'); ?>
        <?php //echo CHtml::textField('Tool[steps]', $tool->step_min, array('id' => 'step')); ?>
        <input type="text" id="amount_steps" name="Tool[steps]" readonly="readonly" class="game-form-textfield" value="<?php echo 1; ?>" />
    </div>
    <div>
         <?php $this->widget('zii.widgets.jui.CJuiSlider', array(
            'id'            => mt_rand(1, 9999), 
            'options'=>array(
                'min'=> (int)$tool->userConfig->step_min,
                'max'=> (int)$tool->userConfig->step_max,
                'step'=> 1,    
                'slide' => 'js:function( event, ui ) 
                    {$( "#amount_steps" ).val( ui.value );}',        
                ),
                'htmlOptions'=>array(
                    'style'=>'height:12px; width:400px;'
            ),
        ));?>
    </div>
    <br>
    <div class="row game-button-panel">
        <?php echo CHtml::ajaxLink('Положить деньги',
                Yii::app()->createUrl('tool/process'),
                array(
                    'type' => 'POST',
                    'data' => 'js:$("#dep_").serialize()',
                    'success' => 'function(response){$("#game-content").html(response);}',
                ),
                array(
                    'id'    => mt_rand(1, 9999),
                    'class' => 'game-tool-button'
                    )); ?>
    </div>
    <?php echo CHtml::hiddenField('Tool[id]', $tool->id); ?>
<?php echo CHtml::endForm(); ?>
</div>
<?php endif;?>

    