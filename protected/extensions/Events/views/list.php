<?php if(is_array($currents) & count($currents) > 0): ?>
    <ul class="current-event-list">
    <?php foreach($currents as $cEvent):?>
        <li><?php echo 'Ход: '.$cEvent->progress->step.'. '; ?>
            <?php echo CHtml::ajaxLink(
                            $cEvent->event->name, 
                            Yii::app()->createUrl('event/show', array('id' => $cEvent->event_id)), 
                            array(
                                'success'=>'function(response){
                                            $("#game-layout-overlay").fadeIn("fast");
                                            $("#game-popup").removeClass().addClass("popup-news");
                                            $("#game-popup-header").text("Событие");
                                            $("#game-popup-content").html(response);
                                            $("#game-popup").fadeIn("fast");}'),
                            array(
                                'id' => mt_rand(1, 10000)));?>
        </li>
    <?php endforeach; ?>
    </ul>
<?php else:?>
    <div>Событий нет</div>  
<?php endif; ?>
