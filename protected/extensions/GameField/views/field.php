<div id="game-field">
    <div id="game-shop" class="has-tooltip">
        <div class="game-link">
            <?php echo CHtml::ajaxLink('Магазин', 
                        Yii::app()->createAbsoluteUrl('institute/shop'),
                        array(
                            'success'=>'function(response){'
                            .'$("#game-layout-overlay").fadeIn("fast");'
                            . '$("#game-popup").addClass("popup-shop");'
                            . '$("#game-popup-content").html(response);'
                            . '$("#game-popup").fadeIn("fast"); return false;}'
                        ),
                        array('id'=> mt_rand(1, 9999), 'class'=>'ajax')
                    );?>
        </div>
        <div class="tooltip">
            Универсам
        </div>
    </div>
    <?php if(is_array($institutes)): ?>
        <?php foreach ($institutes as $institute): ?>
            <div id="<?php echo $institute->css; ?>" class="has-tooltip">
                <div class="game-link">
                    <a href="#"><img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"></a>
                </div>
                <div class="tooltip">
                    <?php echo $institute->name;?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif;?>
    <?php $this->widget('ext.GameHouseField.GameHouse', array(
                'step' => $step,
            )); 
    ?>
    <div id="game-panel">
        <div id="game-manual">
            <a href="#" target="_blank">Руководство</a>
        </div>
        <div id="game-tips">
            <a href="#">Подсказки</a>
        </div>
        <div id="game-news">
            <div class="game-news-header">Новости</div>
            <div class="game-news-body">
                <?php $this->widget('ext.News.NewsList', array('step' => $step)); ?>
            </div>    
        </div>
        <div id="game-events">
            <div class="game-event-header">События</div>
            <div class="game-event-body">
                <?php $this->widget('ext.Events.CurrentEventsList', array('step' => $step)); ?>
            </div>    
        </div>
    </div>
</div>
<?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/game.js');?>
<?php
    $script = '$(document).ready(function(){
        $(".tooltip").hide();
        $(".has-tooltip").hover(
                function(){
                    var tooltip = $(this).children(".tooltip").stop();
                    var hTip    = tooltip.outerHeight();
                    var wTip    = tooltip.outerWidth();
                    var wPar    = $(this).outerWidth();
                    var lPos    = (wTip > wPar)? 0 : (wPar - wTip)/2;
                    tooltip.css({left:0 + lPos, top:-10 - hTip});
                    tooltip.fadeIn("fast");
                }, 
                function(){
                    var tooltip = $(this).children(".tooltip").stop();
                    tooltip.fadeOut("fast");
                });
        $("#game-manual, #game-tips, #game-news, #game-events").hover(
                function(){
                    $(this).stop().animate({opacity:"1"}, "fast");
                },
                function(){
                    $(this).stop().animate({opacity:"0.5"}, "fast");
                });
     //disable sclicking
     $(".next").on("click", function(){
        var status = $(this).attr("active"); 
        if(status === "enabled")
            return;
        return false;
    });
    //register controllers for home
        $("#game-house .game-link a, #game-trailer .game-link a, #game-cottage .game-link a").on("click", function(){
            $.ajax({
                type: "POST",
                url: "'.Yii::app()->createUrl('institute/home').'",
                success: function(response){
                        $("#game-layout-overlay").fadeIn("fast");
                        $("#game-popup").removeClass().addClass("popup-home");
                        $("#game-popup-content").html(response);
                        $("#game-popup").fadeIn("fast");},
                error: function(xhr){alert("failure"+xhr.readyState+this.url)}
            });
            return false;
        });
     //register controller for tips
     $("#game-tips").on("click", "a", function(){
        $.ajax({
                type: "POST",
                url: "'.Yii::app()->createUrl('game/tip').'",
                success: function(response){
                        $("#game-layout-overlay").fadeIn("fast");
                        $("#game-popup").removeClass().addClass("popup-tip");
                        $("#game-popup-content").html(response);
                        $("#game-popup").fadeIn("fast");},
                error: function(xhr){alert("failure"+xhr.readyState+this.url)}
            });
            return false;
    }); 
     //register controller gor bank
     $("#game-bank .game-link a").on("click", function(){
        $.ajax({
                type: "POST",
                url: "'.Yii::app()->createUrl('institute/bank').'",
                success: function(response){
                        $("#game-layout-overlay").fadeIn("fast");
                        $("#game-popup").removeClass().addClass("popup-bank");
                        $("#game-popup-content").html(response);
                        $("#game-popup").fadeIn("fast");},
                error: function(xhr){alert("failure"+xhr.readyState+this.url)}
            });
            return false;
    });
    //register controller for insure company
    $("#game-insure .game-link a").on("click", function(){
        $.ajax({
                type: "POST",
                url: "'.Yii::app()->createUrl('institute/insure').'",
                success: function(response){
                        $("#game-layout-overlay").fadeIn("fast");
                        $("#game-popup").removeClass().addClass("popup-insure");
                        $("#game-popup-content").html(response);
                        $("#game-popup").fadeIn("fast");},
                error: function(xhr){alert("failure"+xhr.readyState+this.url)}
            });
            return false;
    });
    //register conntroller fot pif company
    $("#game-pif .game-link a").on("click", function(){
        $.ajax({
                type: "POST",
                url: "'.Yii::app()->createUrl('institute/pif').'",
                success: function(response){
                        $("#game-layout-overlay").fadeIn("fast");
                        $("#game-popup").removeClass().addClass("popup-pif");
                        $("#game-popup-content").html(response);
                        $("#game-popup").fadeIn("fast");},
                error: function(xhr){alert("failure"+xhr.readyState+this.url)}
            });
            return false;
    });
    //register cpntroller for found 
    $("#game-found .game-link a").on("click", function(){
        $.ajax({
                type: "POST",
                url: "'.Yii::app()->createUrl('institute/found').'",
                success: function(response){
                        $("#game-layout-overlay").fadeIn("fast");
                        $("#game-popup").removeClass().addClass("popup-found");
                        $("#game-popup-content").html(response);
                        $("#game-popup").fadeIn("fast");},
                error: function(xhr){alert("failure"+xhr.readyState+this.url)}
            });
            return false;
    });
     //handle for close button
     $("#popup-close-button").on("click", function(){
            $.ajax({
                type: "POST",
                url: "'.Yii::app()->createUrl('game/reload').'",
                success: function(response){$("#game-content").html(response);},
                error: function(xhr){alert("failure"+xhr.readyState+this.url)}
            });
            $("#game-popup").fadeOut("slow");
            $("#game-layout-overlay").fadeOut("slow");
        });
    });';
?>
<?php Yii::app()->clientScript->registerScript('game', $script, CClientScript::POS_END);?>