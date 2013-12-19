<div class="form-process">
<?php echo CHtml::beginForm('', 'post', array('id'=>'dep_')); ?>
    <div class="row">
        <?php 
            $this->widget('ext.highcharts.HighchartsWidget', array(
                'htmlOptions'=>array(
                    'id'    => 'chart-'.mt_rand(1, 9999),
                ),
                'options'=>array(
                   'title' => array('text' => $tool->name),
                   'xAxis' => array(
                      'Ходы' => array('1', '2', '3')
                   ),
                   'yAxis' => array(
                      'title' => array('text' => 'Цена')
                   ),
                   'series' => array(
                      array('name' => 'Уровень цен','data' => array(1, 0, 4))
                   )
                )
             ));
        ?>
        <?php $price = ShareRateManager::getLastRate($tool->id, $step); ?>
        Текущий курс: <?php echo $price; ?>
    </div>
    <div class="row">
        <?php //echo CHtml::label('Укажите количество паев', 'credit'); ?>
        <?php //echo CHtml::textField('Tool[number]', 0, array('id' => 'pif')); ?>
    </div>
    <div class="row">
        <label for="amount">Количество паев:</label>
        <input type="text" id="amount_basic" style="border:0; color:#f6931f; font-weight:bold;" value="1" />
        <?php 
            $this->widget('zii.widgets.jui.CJuiSliderInput', array(
                'id'            => mt_rand(1, 9999),
                'name'          => 'Tool[number]',
                //'value'         => '1',
                'event'         => 'change',
                'options'       => array(
                    'min'   => 1,
                    'max'   => 100,
                    'step'          => '1',
                    'slide' => 'js:function(event,ui){$("#amount_basic").val(ui.value);}',
                ),
                ));
        ?>
    </div>
    <div class="row">
        <?php echo CHtml::ajaxLink('Купить',
                Yii::app()->createUrl('tool/process'),
                array(
                    'type' => 'POST',
                    'data' => 'js:$("#dep_").serialize()',
                    'success' => 'function(response){$("#shopDialog").dialog("close").dialog("destroy");$("#game-content").html(response);}',
                ),
                array('id' => mt_rand(1, 9999))); ?>
        <?php echo CHtml::link('Отмена', '#', array(
            'id'        => $close = mt_rand(1, 1000),
            'onclick'   => '$("#shopDialog").dialog("close");',
        )); ?>
    </div>
    <?php echo CHtml::hiddenField('Tool[id]', $tool->id); ?>
<?php echo CHtml::endForm(); ?>
</div>

    