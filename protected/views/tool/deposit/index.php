<div class="form-process">
<?php echo CHtml::beginForm('', 'post', array('id'=>'dep_')); ?>
    <div class="row">
        <?php echo CHtml::label('Укажите сумму для депозита', 'deposit'); ?>
        <?php echo CHtml::textField('deposit', $tool->in_total_min, array('id' => 'deposit')); ?>
    </div>
    <div class="row">
        <?php echo CHtml::label('Укажите срок депозита (минимальный срок 12 шагов)', 'step'); ?>
        <?php echo CHtml::textField('step', $tool->step_min, array('id' => 'step')); ?>
    </div>
    <div class="row">
        <?php echo CHtml::ajaxLink('Положить деньги',
                Yii::app()->createUrl('tool/process'),
                array(
                    'type' => 'POST',
                    'data' => 'js:$("#dep_").serialize()',
                    'success' => 'function(response){$("#shopDialog").html(response).dialog("open"); return false;}',
                ),
                array('id' => mt_rand(1, 9999))); ?>
        <?php echo CHtml::link('Отмена', '#', array(
            'onclick'=>'$("#shopDialog").dialog("close");'
        )); ?>
    </div>
    <?php echo CHtml::hiddenField('tool', $tool->id); ?>
<?php echo CHtml::endForm(); ?>
</div>

    