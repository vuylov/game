<div class="form-process">
<?php echo CHtml::beginForm('', 'post', array('id'=>'dep_')); ?>
    <div class="row">
        <?php $price = ShareRateManager::getLastRate($tool->id, $step); ?>
        Текущий курс: <?php echo $price; ?>
    </div>
    <div class="row">
        <?php echo CHtml::label('Укажите количество акций', 'credit'); ?>
        <?php echo CHtml::textField('Tool[number]', $tool->in_total_min, array('id' => 'stock')); ?>
    </div>
    <div class="row">
        <?php echo CHtml::ajaxLink('Купить акции',
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

    