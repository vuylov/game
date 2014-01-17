<div class="news-container">
    <div class="news-header title">Новости</div>
<?php if(is_array($news) & count($news) > 0): ?>
    <ul class="news-list">
    <?php foreach($news as $current):?>
        <li><?php echo 'Ход: '.$current->progress->step.'. '.$current->news->description; ?></li>
    <?php endforeach; ?>
    </ul>
<?php else:?>
    <div>Новостей нет</div>  
<?php endif; ?>
</div>

