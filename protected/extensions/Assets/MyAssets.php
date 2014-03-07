<?php
class MyAssets extends CWidget{
    public $step;
    
    public function run() {
        $step       = $this->step;
        $assets     = Asset::model()->with(array(
            'tool'  => array(
                'with'  => array(
                    'userConfig' => array(
                        'alias'     =>'u',
                        'condition' => 'u.game_id = :game',
                        'params'    => array(':game' => $step->game_id)
                    )
                )
            )
        ))->findAll('t.game_id = :game AND t.status=:status', array(':game'=> $step->game_id, ':status'=>'o'));
        $this->render('list', array('assets' => $assets, 'step' => $step));
    }
}
