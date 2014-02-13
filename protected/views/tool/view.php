<div class="tool-description">
    <?php echo $tool->name.' '.$tool->description; ?>
</div>
<div class="tool-control">
    <?php echo CHtml::ajaxLink('Продолжить оформление',
            Yii::app()->createUrl('tool/use', array('id' => $tool->id)),
            array('success' => 'function(response){$("#game-popup-content").html(response); return false;}'), 
            array('id' => mt_rand(1, 9999))); ?>
</div>
