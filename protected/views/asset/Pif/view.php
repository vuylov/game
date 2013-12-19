<div class="form-process">
<?php echo CHtml::beginForm('', 'post', array('id'=>'pif')); ?>
    <div class = "row">
        <?php echo $asset->tool->name; ?>
    </div>
    <div class = "row">
        Количество паев: <?php echo $asset->number; ?>
    </div>
    <div class="row">
        Текущая стоимость пая: <?php echo ShareRateManager::getLastRate($asset->tool_id, $progress); ?>
    </div>
    <div class="row">
        Обща стоимость: <?php echo $asset->balance_end; ?>
    </div>
    <div class="row">
        <?php echo CHtml::label('Укажите количество паев для продажи', 'pif'); ?>
        <?php echo CHtml::textField('Pif[number]', 0, array('id' => 'pif')); ?>
    </div>
    <div class="row">
        <?php echo CHtml::ajaxLink('Продать паи',
                Yii::app()->createUrl('pif/sell'),
                array(
                    'type' => 'POST',
                    'data' => 'js:$("#pif").serialize()',
                    'success' => 'function(response){$("#shopDialog").html(response); return false;}',
                ),
                array('id' => mt_rand(1, 9999))); ?>
        <?php echo CHtml::link('Отмена', '#', array(
            'onclick'=>'$("#shopDialog").dialog("close");'
        )); ?>
    </div>
    <?php echo CHtml::hiddenField('Pif[id]', $asset->id); ?>
<?php echo CHtml::endForm(); ?>
</div>
