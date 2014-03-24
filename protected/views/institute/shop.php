<table>
        <tr class="caption">
            <td>Ценность</td>
            <!--<td>&nbsp;</td>-->
            <td>Цена покупки</td>
            <td>Цена продажи</td>
            <td>Уровень престижа</td>
            <td>Изменения</td>
            <td>Действие</td>
            
        </tr>
<?php foreach($worthes as $worth): ?>
        <tr>
            <td><span class="<?php echo $worth->css; ?>"></span></td>
            <!--<td><?php echo $worth->name; ?></td>-->
            <td><?php echo $worth->price_buy; ?></td>
            <td><?php echo $worth->price_sell; ?></td>
            <td><?php echo $worth->prestige; ?></td>
            <td>
                <?php if($worth->costs):?>
                    <?php foreach($worth->costs as $cost): ?>
                        <div class="cost <?php echo ($cost->value > 0)?"positive":"negative"; ?>">
                            <?php echo $cost->description.' ('.$cost->value.')'; ?>
                        </div>
                    <?php endforeach;?>
                <?php endif;?>
            </td>
            <td><?php echo CHtml::ajaxLink(
                    'Купить',
                    $this->createUrl('game/buy', array('id'=>$worth->id)),
                    array(
                        'success'=>'function(response){$("#game-popup-content").html(response);}',
                        ),
                    array(
                        'id'    => mt_rand(1, 10000),
                        'class' => 'game-green-button'
                        )
                    ); ?>
            </td>
        </tr>
<?php endforeach; ?>
    </table>