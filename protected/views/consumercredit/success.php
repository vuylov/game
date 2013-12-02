<div class="row">
    Ваш кредит успешно закрыт
</div>
<div class="row">
    <?php 
        echo CHtml::ajaxLink('Закрыть',
         Yii::app()->createUrl('game/reload'), 
         array('success' => 'function(response){$("#shopDialog").dialog("close").dialog("destroy");$("#game-content").html(response);}'), 
         array('id' => mt_rand(1, 9999)));
    ?>
</div>


