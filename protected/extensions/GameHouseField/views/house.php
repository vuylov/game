<div id="game-house-field">
    <?php foreach($worthes as $worth):?>
        <div id="game-<?php echo $worth->worth->css; ?>" class="has-tooltip">
            <div class="game-link">
                <a href="#"><?php echo $worth->worth->name; ?></a>
            </div>
            <div class="tooltip">
                <?php echo $worth->worth->description;?>
            </div>
        </div>
    <?php endforeach;?>
</div>