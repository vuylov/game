<?php if(is_array($news) & count($news) > 0): ?>
    <ul class="news-list">
    <?php foreach($news as $current):?>
        <li><?php echo CHtml::ajaxLink(
                            $current->news->name, 
                            Yii::app()->createUrl('news/show', array('id' => $current->news_id)), 
                            array(
                                'success'=>'function(response){
                                            $("#game-layout-overlay").fadeIn("fast");
                                            $("#game-popup").removeClass().addClass("popup-news");
                                            $("#game-popup-header").text("Новость");
                                            $("#game-popup-content").html(response);
                                            $("#game-popup").fadeIn("fast");}'),
                            array(
                                'id' => mt_rand(1, 10000)));?>
            <?php //echo '. Новость возникла на '.$current->progress->step.' ходе. Событие может возникнуть на '.$current->event_start.' ходе'; ?>
        </li>
    <?php endforeach; ?>
    </ul>
<?php else:?>
    <div>Новостей нет</div>  
<?php endif; ?>