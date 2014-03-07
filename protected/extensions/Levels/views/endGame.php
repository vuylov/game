<script>
    $(document).ready(function(){
        $("#popup-close-button").remove();//remove standard close button with his click handler
        $("<div class='alt-close-button'></div>").appendTo($("#game-popup"));
        $("#game-layout-overlay").fadeIn("fast");
        $("#game-popup").addClass("popup-level-up");
        $("#game-popup-content").html("<video controls='' autoplay='' name='media'><source src='<?php echo Yii::app()->baseUrl;?>/video/<?php echo $video; ?>' type='video/mp4'></video>");
        $("#game-popup").fadeIn("fast");

        $(".alt-close-button").on('click', function(){
            window.location.href = "<?php echo Yii::app()->createAbsoluteUrl('site/ranking'); ?>";
            })
        });
</script>