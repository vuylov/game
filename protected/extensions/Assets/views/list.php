<?php if($assets): ?>
    <div class="msg">
        <ul>
            <?php foreach ($assets as $asset): ?>
            <li>
                <?php $this->render($asset->tool->class.'/index', array('asset' => $asset, 'step' =>$step));?>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php else: ?>
    <div class="msg">У нас нету ничего кроме зарплаты в <?php echo Yii::app()->params["income"]; ?> рублей</div>
<?php endif; ?>
