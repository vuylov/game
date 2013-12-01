<div class="form-process">
<?php echo CHtml::beginForm('', 'post', array('id'=>'dep_')); ?>
    <div class="row">
        <?php echo CHtml::label('Укажите сумму для депозита', 'deposit'); ?>
        <?php echo CHtml::textField('Tool[money]', $tool->in_total_min, array('id' => 'deposit')); ?>
    </div>
    <div class="row">
        <?php echo CHtml::label('Укажите срок депозита (минимальный срок 12 шагов)', 'step'); ?>
        <?php echo CHtml::textField('Tool[steps]', $tool->step_min, array('id' => 'step')); ?>
    </div>
    <div class="row">
        <?php echo CHtml::ajaxLink('Положить деньги',
                Yii::app()->createUrl('tool/process'),
                array(
                    'type' => 'POST',
                    'data' => 'js:$("#dep_").serialize()',
                    'success' => 'function(response){$("#shopDialog").dialog("close").dialog("destroy");$("#game-content").html(response);}',
                ),
                array('id' => mt_rand(1, 9999))); ?>
        <?php echo CHtml::link('Отмена', '#', array(
            'onclick'=>'$("#shopDialog").dialog("close");'
        )); ?>
    </div>
    <?php echo CHtml::hiddenField('Tool[id]', $tool->id); ?>
<?php echo CHtml::endForm(); ?>
</div>

    