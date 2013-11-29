<div>
    <table>
        <tr>
            <td>Изображение</td>
            <td>Наименование</td>
            <td>Цена покупки</td>
            <td>Цена продажи</td>
            <td>Уровень престижа</td>
            <td>Действие</td>
        </tr>
<?php foreach($worthes as $worth): ?>
        <tr>
            <td><img src="<?php echo $worth->image; ?>"</td>
            <td><?php echo $worth->name; ?></td>
            <td><?php echo $worth->price_buy; ?></td>
            <td><?php echo $worth->price_sell; ?></td>
            <td><?php echo $worth->prestige; ?></td>
            <td><?php echo CHtml::ajaxLink(
                    'Купить',
                    $this->createUrl('game/buy', array('id'=>$worth->id)),
                    array('success'=>'function(response){$("#shopDialog").dialog("destroy");$("#game-content").html(response);}'),
                    //array('class'=>'buy'),
                    array('id' => mt_rand(1, 10000))
                    ); ?>
            </td>
        </tr>
    </div>
<?php endforeach; ?>
</table>
