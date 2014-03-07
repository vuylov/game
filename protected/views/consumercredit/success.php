<div class="row">
    Ваш кредит успешно закрыт
</div>
<div class="row game-button-panel">
    <?php 
        echo CHtml::ajaxLink('Закрыть',
         Yii::app()->createUrl('game/reload'), 
         array('success' => 'function(response){$("#game-content").html(response);}'), 
         array(
             'id'   => mt_rand(1, 9999),
             'class'=> 'game-tool-button'
             ));
    ?>
</div>


