<div class="form-process">
    <div class="row tool-description">
        <?php echo $tool->description;?>
    </div>
    <hr>
<?php echo CHtml::beginForm('', 'post', array('id'=>'dep_')); ?>
    <div class="row">
        <?php 
            $limit = 30;
            $data = ShareRateManager::getToolRates($tool->id, $step, $limit);
            //CVarDumper::dump($data, 10, true);
            $this->widget('ext.highcharts.HighchartsWidget', array(
                'htmlOptions'=>array(
                    'id'    => 'chart-'.mt_rand(1, 9999),
                ),
                'options'=>array(
                   'chart' => array('width' => 400, 'height' => 300), 
                   'title' => array('text' => $tool->name),
                   'xAxis' => array(
                      'title' => array('text' => 'Ход'), 
                      'categories' => array_values($data[1]),
                   ),
                   'yAxis' => array(
                      'title' => array('text' => 'Цена')
                   ),
                   'series' => array(
                      array('name' => 'Текущий курс','data' => $data[0])
                   )
                )
             ));
        ?>
        <hr>
    </div>
    <div class="row">
        <?php $price = ShareRateManager::getLastRate($tool->id, $step); ?>
        Текущий курс: <?php echo $price; ?>
    </div>
    <div class="row">
        <?php echo CHtml::label('Укажите количество акций', 'amount_basic'); ?>
        <?php //echo CHtml::textField('Tool[number]', $tool->in_total_min, array('id' => 'stock')); ?>
        <input type="text" id="amount_basic" name="Tool[number]" class="game-form-textfield" readonly="readonly" />
    </div>
    <div>
         <?php $this->widget('zii.widgets.jui.CJuiSlider', array(
            'id'            => mt_rand(1, 9999), 
            'options'=>array(
                'min'=>10,
                'max'=>  floor($step->deposit / $price),
                'step'=>10,    
                'slide' => 'js:function( event, ui ) 
                    {$( "#amount_basic" ).val( ui.value );}',        
                ),
            'htmlOptions'=>array(
                'style'=>'height:12px; width:400px;'
            ),
        ));?>
    </div>
    <div class="row game-button-panel">
        <?php echo CHtml::ajaxLink('Купить акции',
                Yii::app()->createUrl('tool/process'),
                array(
                    'type' => 'POST',
                    'data' => 'js:$("#dep_").serialize()',
                    'beforeSend'=>'function(){var number = $("#amount_basic").val(); if(!number){return false;};}',
                    'success' => 'function(response){$("#game-content").html(response);}',
                ),
                array(
                    'id' => mt_rand(1, 9999),
                    'class' => 'game-tool-button'
                    )); ?>
    </div>
    <?php echo CHtml::hiddenField('Tool[id]', $tool->id); ?>
<?php echo CHtml::endForm(); ?>
</div>

    