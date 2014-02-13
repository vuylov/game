<div class="statistic">
    <div class="title">Статистика</div>
    <div>
        Calculate...
    </div>
</div>
<div class="activities">
    <div class="title">Список покупок:</div>
    <div>
        <?php $this->widget('ext.ActivitiesList.ActivitiesList', array(
            'step' => $step,
        )); ?>
    </div>
</div>
<div class="assets">
    <div class="my-assets title">Мои активы</div>
    <div>
        <?php $this->widget('ext.Assets.MyAssets', array('step'=> $step)); ?>
    </div>
</div>