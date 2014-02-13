<?php echo $level; ?>
<?php if($up):?>
    <script>
    $(document).ready(function(){
        $("#game-layout-overlay").fadeIn("fast");
        $("#game-popup").addClass("popup-level-up");
        $("#game-popup-content").html("<?php echo $video;?>");
        $("#game-popup").fadeIn("fast");
        });
    </script>
<?php endif; ?>
