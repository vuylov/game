<?php
class MyAssets extends CWidget{
    public $step;
    
    public function run() {
        $step       = $this->step;
        $assets     = Asset::model()->with('tool')->findAllByAttributes(array('game_id'=> $step->game_id));
        $this->render('list', array('assets' => $assets, 'step' => $step));
    }
}
