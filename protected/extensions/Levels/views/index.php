<?php for($i = 1; $i <=5; $i++):?>
    <span class="<?php echo ($i<=$level)?'game-level-star':'game-little-star';?>"></span>
<?php endfor;?>
<?php //echo $level; ?>
<?php if($up):?>
    <script>
    $(document).ready(function(){
        $("#game-layout-overlay").fadeIn("fast");
        $("#game-popup").addClass("popup-level-up");
        $("#game-popup-content").html("<video controls='' autoplay='' name='media'><source src='<?php echo Yii::app()->baseUrl;?>/video/<?php echo $video; ?>' type='video/mp4'></video>");
        $("#game-popup").fadeIn("fast");
        });
    </script>
<?php endif; ?>