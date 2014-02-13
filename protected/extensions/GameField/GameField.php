<?php
class GameField extends CWidget{
    public $step;
    
    public function init(){
    }
    public function run(){
        $step = $this->step;
        $institutes = Institute::model()->findAll('levelPrestige <= :prestige', array(':prestige'=>$step->prestige));
        $this->render('field', array('institutes' => $institutes, 'step' => $step));
    }
}
