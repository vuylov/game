<?php if($assets): ?>
            <?php foreach ($assets as $asset): ?>
                <?php $this->render($asset->tool->class.'/index', array('asset' => $asset, 'step' =>$step));?>
            <?php endforeach; ?>
<?php endif; ?>
