<script>
    $(document).ready(function(){
        $("#popup-close-button").remove();//remove standard close button with his click handler
        $("<div class='alt-close-button'></div>").appendTo($("#game-popup"));
        $("#game-layout-overlay").fadeIn("fast");
		$("#game-popup-header").remove();
		$("#game-popup").css({
				"left"		: "35px",
				"top"		: "3%",
				"max-width"	: "100%",
				"max-height": "100%"
			});
			$("#game-popup-content").css({
				"max-width"	: "100%",
				"max-height": "100%"
			});
        $("#game-popup-content").html("<video controls='' autoplay='' name='media' id='evideo'><source src='<?php echo Yii::app()->baseUrl;?>/video/<?php echo $video; ?>' type='video/mp4'></video>");
		$("#evideo").on("ended", function(){
				window.location.href = "<?php echo Yii::app()->createAbsoluteUrl('site/ranking'); ?>";
			});
        $("#game-popup").fadeIn("fast");
		
        $(".alt-close-button").on('click', function(){
            window.location.href = "<?php echo Yii::app()->createAbsoluteUrl('site/ranking'); ?>";
            })
        });
</script>