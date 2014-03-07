<tr>
    <td>
        <?php echo CHtml::ajaxLink(
                $asset->tool->name, 
                Yii::app()->createUrl('asset/view', array('id' => $asset->id)), 
                array('success' => 'function(response){$("#game-popup-content").html(response); return false;}'),
                array('id' => mt_rand(1, 9999)));
        ?>
        <p class="tool-note-detail">
            Количество купленного золота: <?php echo $asset->number; ?>. Текущая стоимость: <?php echo $asset->balance_end; ?>
        </p>
    </td>
    <td><?php echo $asset->balance_end; ?></td>
    <td></td>
    <td></td>
</tr>

</b>
Количество купленного золота: <?php echo $asset->number; ?>. 
Текущая стоимость: <?php echo $asset->balance_end; ?>