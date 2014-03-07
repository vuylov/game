<?php if(!CheckCredit::isUserHaveCredit($step)): ?>
<?php 
    $progressIncome = ProgressIncome::getStepProgressIncome($step, true) / 4;
    $endStep        = 36; //максимальное количество ходов, на которые можно взять кредит
?>
<div class="form-process">
    <div class="row tool-description">
        <?php echo $tool->description;?>
    </div>
    <hr>
<?php echo CHtml::beginForm('', 'post', array('id'=>'dep_')); ?>
    <div class="row">
        <?php echo CHtml::label('Укажите сумму кредита', 'amount_credit'); ?>
        <?php //echo CHtml::textField('Tool[money]', $tool->in_total_min, array('id' => 'credit')); ?>
        <input type="text" class="game-form-textfield" id="amount_credit" readonly="readonly" name="Tool[money]" value="1000" />
    </div>
    <div>
         <?php $this->widget('zii.widgets.jui.CJuiSlider', array(
            'id'            => mt_rand(1, 9999), 
            'options'=>array(
                'min'=>1000,
                'max'=>$progressIncome * $endStep,
                'step'=>1000,    
                'slide' => 'js:function( event, ui ) 
                    {$( "#amount_credit" ).val( ui.value );}',        
                ),
            'htmlOptions'=>array(
                'style'=>'height:12px; width:400px;'
            ),
        ));?>
    </div>
    <div class="row">
        <?php echo CHtml::label('Укажите срок кредита (минимальный срок 6 шагов)', 'step'); ?>
        <?php //echo CHtml::textField('Tool[steps]', $tool->step_min, array('id' => 'step')); ?>
        <input type="text" class="game-form-textfield" id="amount_steps" readonly="readonly" name="Tool[steps]" value="6" />
    </div>
    <div>
         <?php $this->widget('zii.widgets.jui.CJuiSlider', array(
            'id'            => mt_rand(1, 9999), 
            'options'=>array(
                'min'=>6,
                'max'=>$endStep,
                'step'=>1,    
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
        <?php echo CHtml::ajaxLink('Взять кредит',
                Yii::app()->createUrl('tool/process'),
                array(
                    'type' => 'POST',
                    'data' => 'js:$("#dep_").serialize()',
                    'beforeSend' => 'function(){}',
                    'success' => 'function(response){$("#shopDialog").dialog("close").dialog("destroy");$("#game-content").html(response);}',
                ),
                array(
                    'id'    => mt_rand(1, 9999),
                    'class' => 'game-tool-button',
                    )); ?>
    </div>
    <?php echo CHtml::hiddenField('Tool[id]', $tool->id); ?>
<?php echo CHtml::endForm(); ?>
</div>
<?php else:?>
    <div>У Вас есть действующий кредит</div>
    <div class="row game-button-panel">
    <?php 
        echo CHtml::ajaxLink('Закрыть',
         Yii::app()->createUrl('game/reload'), 
         array('success' => 'function(response){$("#game-popup-content").fadeOut("fast");$("#game-content").html(response);}'), 
         array(
             'id' => mt_rand(1, 9999),
             'class'=> 'game-tool-button'
             ));
    ?>
 </div>
<?endif;?>
    