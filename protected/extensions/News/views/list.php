<?php if(is_array($news) & count($news) > 0): ?>
    <ul class="news-list">
    <?php foreach($news as $current):?>
        <li><?php echo $current->news->description.'. Новость возникла на '.$current->progress->step.' ходе. Событие может возникнуть на '.$current->event_start.' ходе'; ?></li>
    <?php endforeach; ?>
    </ul>
<?php else:?>
    <div>Новостей нет</div>  
<?php endif; ?>

