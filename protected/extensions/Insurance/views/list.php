<?php if(count($insures) > 0):?>
    <?php foreach($insures as $insure): ?>
        <?php $remained = $insure->step_end-$progress->step;?>
        <div class="insure-item"><img src="<?php echo $insure->worth->image;?>"> застрахован(а) до <?php echo $insure->step_end;?> хода. До окончания действия страхового полиса осталось <?php echo $remained; ?> хода(ов)</div>
    <?php endforeach;?>
<?php else:?>
    <div>Застрахованных ценностей нет</div>
<?php endif; ?>


