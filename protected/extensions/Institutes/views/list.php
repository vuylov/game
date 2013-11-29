<?php //CVarDumper::dump($step, 10, true); ?>
<?php foreach($institutes as $institute):?>
<div>
    <img src ="<?php echo $institute->image; ?>"> 
    <?php if($institute->levelPrestige > $step->prestige): ?>
        Данный институт не доступен. Вам нужно набрать <?php echo $institute->levelPrestige ?> престижа
    <?php else: ?>
        <b><?php echo $institute->name.': '.$institute->description; ?></b>
        <ul class="tools">
            <?php foreach($institute->tools as $tool): ?>
                <?php if($tool->levelPrestige <= $step->prestige): ?>
            <li><a><?php echo CHtml::ajaxLink($tool->name.'. '.$tool->description,
                                        Yii::app()->createUrl('tool/view', array('id'=>$tool->id)),    
                                        array(
                                        'success' => 'function(response){$("#shopDialog").html(response).dialog("open"); return false;}'
                                        ),
                                        array('id'=>mt_rand(1, 999)));  ?>
                </a></li>
                <?php else: ?>
                    <li>Инструмент - <?php echo $tool->name; ?> Вам не доступен. Необходимо набрать <?php echo $tool->levelPrestige; ?> очков престижа</li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
   <?php endif; ?>
</div>
<?php endforeach;?>
