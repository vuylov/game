<?php
class InsuranceList extends CWidget{
    public $step;
    public function run() {
        
        $insures = WorthInsure::model()->with('action', 'worth')->findAll(array(
            'condition' => 't.game_id = :game AND t.status = 1',
            'params'    => array(':game' => $this->step->game_id)        
        ));
        //CVarDumper::dump($insures, 10, true);
        
        
        $response = $this->render('list', array('insures' => $insures, 'progress' => $this->step), true);
        echo $response;
    }
}
