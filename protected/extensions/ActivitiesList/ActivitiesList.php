<?php

class ActivitiesList extends CWidget {
    public $step;
    
    public function init(){
    }
  
    public function run(){
        $step = $this->step;
        $activities = Action::model()->with(array(
            'worthInsures',
            'worth' => array(
                'alias'=> 'w',
                'with' => array('costs'),
                'order'=>'w.price_buy'
            )
        ))->findAllByAttributes(array('game_id' => $step->game_id, 'status' => 'b'));
        $this->render('list', array('activities' => $activities, 'progress' => $this->step));
    }
}
