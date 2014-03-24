<?php
class InsuranceForm extends CWidget {
    public $step;
    public $tool;
    public function run()
    {       
        $worthes = Action::model()->with(array(
            'worth' => array(
                'alias' => 'w',
                'order' => 'w.price_buy'
            )
        ))->findAll(array(
            'condition' => 't.status = "b" '
            . 'AND t.game_id = '.$this->step->game_id.' '
            . 'AND t.worth_id IN (SELECT id FROM worth WHERE insurance > 0 AND status =1)'
            . 'AND t.id NOT IN (SELECT action_id FROM worthInsure WHERE game_id = '.$this->step->game_id.' AND status = 1)'
        ));
        
        //CVarDumper::dump($worthes, 10, true);
        
        $response = $this->render('form', array('progress'=> $this->step, 'tool' => $this->tool, 'worthes'=>$worthes), true);
        echo $response;
    }
}
