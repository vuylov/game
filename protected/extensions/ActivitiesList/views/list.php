<div class="activities-list">
    <?php foreach ($activities as $action): ?>
    <span class="activity-item">
        <?php
            echo CHtml::ajaxLink('<img src="'.$action->worth->image.'">',
                    Yii::app()->createAbsoluteUrl('game/worthView', array('id'=>$action->id)),
                    array(
                        'success' => 'function(response){$("#shopDialog").html(response).dialog("open"); return false;}'
                    ),
                    array('id'=>mt_rand(1, 999))); 
        ?>
    </span>
    <?php endforeach; ?>
</div>
