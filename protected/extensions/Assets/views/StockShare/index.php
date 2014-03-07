<tr>
    <td>
        <?php echo CHtml::ajaxLink(
                $asset->tool->name, 
                Yii::app()->createUrl('asset/view', array('id' => $asset->id)), 
                array('success' => 'function(response){$("#game-popup-content").html(response); return false;}'),
                array('id'=>mt_rand(1, 9999)));
        ?>
    <p class="tool-note-detail">Количество акций: <?php echo $asset->number; ?></p>
    </td>
    <td><?php echo $asset->balance_end; ?></td>
    <td></td>
    <td></td>
</tr>

