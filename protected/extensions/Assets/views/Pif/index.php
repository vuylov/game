<b>
<?php echo CHtml::ajaxLink(
                $asset->tool->name, 
                Yii::app()->createUrl('asset/view', array('id' => $asset->id)), 
                array('success' => 'function(response){$("#shopDialog").html(response).dialog("open"); return false;}'),
                array('id'=>mt_rand(1, 9999)));
?>
</b>
. Количество паев: <?php echo $asset->number; ?>. 
Текущая стоимость: <?php echo $asset->balance_end; ?>