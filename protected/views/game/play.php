<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="info">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>
<div id="game-content">
    <div class="person-information">
        <img src="<?php echo Yii::app()->baseUrl.'/images/default_person_page_resize.png' ?>" class="avatar">
        Текущий ход: <span id="step"><?php echo $step->step; ?><span>
        <div>Наличные: <?php echo $step->deposit; ?></div>
        <div>Доход: <?php echo Yii::app()->params['income']; ?></div>
        <div>Престиж: <?php echo $step->prestige; ?></div>
    </div>
    <div style="clear:both;"></div>
    <hr>
    <div class="activities"><div class="title">Список покупок:</div>
            <?php $this->widget('ext.ActivitiesList.ActivitiesList', array(
                'step' => $step,
            )); ?>
    </div>
    <div class="shop">
        <?php
            echo CHtml::ajaxLink('Зайти в магазин', 
                        $this->createUrl('game/shop'),
                        array(
                            'success'=>'function(response){$("#shopDialog").html(response).dialog("open"); return false;}'
                        ),
                        array('id'=> mt_rand(1, 9999), 'class'=>'ajax')
                    );
        ?>
    </div>
    <div class="institutes">
        <div class="institute-label title">
            Институты:
        </div>
        <div>
            <?php $this->widget('ext.Institutes.InstitutesList', array('step' => $step));?>
        </div>
    </div>
    <div class="next-step">
        <?php echo CHtml::ajaxLink('Следующий ход',
                    array('game/next'),
                    array(
                        'type'          => 'POST',
                       // 'beforeSend'    =>'function(){alert(1);}',
                        'success'        => 'function(response){$("#shopDialog").dialog("destroy");$("#game-content").html(response);}'
                    ),
                array('id' => mt_rand(1, 9999))
                ); ?>
    </div>
    <div class="assets">
        <div class="my-assets title">Мои активы</div>
        <div>
            <?php $this->widget('ext.Assets.MyAssets', array('step'=> $step)); ?>
        </div>
    </div>
    <div class="news-container">
        <div class="news-header title">Новости</div>
        <?php $this->widget('ext.News.NewsList', array('step' => $step)); ?>
    </div>
    <div>
        <div class="event-header title">События</div>
        <?php $this->widget('ext.Events.CurrentEventsList', array('step' => $step)); ?>
    </div>
    <div id="beforeEndContent"></div>    
<?php
/** Start Widget **/
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'shopDialog',
    'options'=>array(
        'autoOpen'=>false,
        
        'width' => 750,
        'appendTo' => '#beforeEndContent',
        'show'=>array(
                'effect'=>'blind',
                'duration'=>1000,
            ),
        'hide'=>array(
                'effect'=>'explode',
                'duration'=>500,
            ),
        'modal' => true,
        'position' => 'center top',
    ),
)); ?>

<?php $this->endWidget('zii.widgets.jui.CJuiDialog');
?>
</div>

