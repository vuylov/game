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
        <?php echo CHtml::label('Укажите количество золота для продажи', 'Metal'); ?>
        <?php echo CHtml::textField('Metal[number]', 0, array('id' => 'Metal')); ?>
    </div>
    <div class="row">
        <?php echo CHtml::ajaxLink('Продать золото',
                Yii::app()->createUrl('metal/sell'),
                array(
                    'type' => 'POST',
                    'data' => 'js:$("#metal").serialize()',
                    'success' => 'function(response){$("#shopDialog").html(response); return false;}',
                ),
                array('id' => mt_rand(1, 9999))); ?>
        <?php echo CHtml::link('Отмена', '#', array(
            'onclick'=>'$("#shopDialog").dialog("close");'
        )); ?>
    </div>
    <?php echo CHtml::hiddenField('Metal[id]', $asset->id); ?>
<?php echo CHtml::endForm(); ?>
</div>
