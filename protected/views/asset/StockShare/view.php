<div class="form-process">
<?php echo CHtml::beginForm('', 'post', array('id'=>'stocShare')); ?>
    <div class = "row">
        <?php echo $asset->tool->name; ?>
    </div>
    <div class = "row">
        Количество акций: <?php echo $asset->number; ?>
    </div>
    <div class="row">
        Текущая стоимость акции: <?php echo ShareRateManager::getLastRate($asset->tool_id, $progress); ?>
    </div>
    <div class="row">
        Обща стоимость: <?php echo $asset->balance_end; ?>
    </div>
    <div class="row">
        <?php echo CHtml::label('Укажите количество акций для продажи', 'credit'); ?>
        <?php echo CHtml::textField('StockShare[number]', 0, array('id' => 'stock')); ?>
    </div>
    <div class="row">
        <?php echo CHtml::ajaxLink('Продать акции',
                Yii::app()->createUrl('shareStock/sell'),
                array(
                    'type' => 'POST',
                    'data' => 'js:$("#stocShare").serialize()',
                    'success' => 'function(response){$("#shopDialog").html(response); return false;}',
                ),
                array('id' => mt_rand(1, 9999))); ?>
        <?php echo CHtml::link('Отмена', '#', array(
            'onclick'=>'$("#shopDialog").dialog("close");'
        )); ?>
    </div>
    <?php echo CHtml::hiddenField('StockShare[id]', $asset->id); ?>
<?php echo CHtml::endForm(); ?>
</div>
