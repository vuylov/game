<?php

class InstitutesList  extends CWidget{
    public $step;
    public function run(){
        $step = $this->step;
        $institutes = Institute::model()->with('tools')->findAll();
        
        $this->render('list', array('institutes'=>$institutes, 'step'=>$step));        
    }
}
