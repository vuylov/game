<?php if(count($worthes) > 0): ?>
    <table>
        <tr class="caption"><td>Ценность</td><td>Ставка страхования</td><td>Стоимость страховки</td><td>Период страхования</td><td>Действие</td>
        <?php foreach ($worthes as $worth):?>
        <tr>
            <td><span class="<?php echo $worth->worth->css; ?>"></span></td>
            <td><?php echo $worth->worth->insurance.'%';?></td>
            <td><?php echo round($worth->worth->price_buy * $worth->worth->insurance / 100);?></td>
            <td>12 ходов</td>
            <td><?php echo CHtml::ajaxLink(
                    'Застраховать',
                    Yii::app()->createUrl('insurance/insure', array('id'=>$worth->id)),
                    array(
                        'success'=>'function(response){$("#game-popup-content").html(response);}',
                        ),
                    array('id' => mt_rand(1, 10000))
                    ); ?></td>
        </tr>
        <?php endforeach;?>
    </table>
<?php else:?>
    <div>Вы либо все застраховали, либо нету собственности для страхования</div>
<?php endif; ?>
