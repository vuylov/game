<h2>Ошибка приложения:</h2>
<div class="errorMessage">
    <?php if(isset($msg)):?>
        <?php echo $msg;?>
        <div>
            <?php echo CHtml::link('Вернуться к списку', array('game/list')); ?>
        </div>
    <?php else: ?>
        <?php  echo CHtml::errorSummary($model); ?>
    <?php endif; ?>
</div>
