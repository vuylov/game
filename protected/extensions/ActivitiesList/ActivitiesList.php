<?php

class ActivitiesList extends CWidget {
    public $step;
    
    public function init(){
    }
  
    public function run(){
        $step = $this->step;
        $activities = Action::model()->with('worth')->findAllByAttributes(array('game_id' => $step->game_id, 'status' => 'b'));
        $this->render('list', array('activities' => $activities));
    }
}
