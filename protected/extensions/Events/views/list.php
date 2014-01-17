<?php if(is_array($currents) & count($currents) > 0): ?>
    <ul class="current-event-list">
    <?php foreach($currents as $cEvent):?>
        <li><?php echo 'Ход: '.$cEvent->progress->step.'. '.$cEvent->event->description; ?></li>
    <?php endforeach; ?>
    </ul>
<?php else:?>
    <div>Событий нет</div>  
<?php endif; ?>
