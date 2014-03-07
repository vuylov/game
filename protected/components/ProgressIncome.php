<?php
class ProgressIncome {
    public static function getStepProgressIncome(Progress $progress, $withCredit = false){
        $output = Yii::app()->params['income'];
        $activities = Action::model()->with(array(
            'worth' => array(
                'with' => array('costs')
            )
        ))->findAllByAttributes(array('game_id' => $progress->game_id, 'status' => 'b'));
        
        foreach ($activities as $activity)
        {
            foreach($activity->worth->costs as $cost)
            {
                $output += (int)$cost->value;
            }
        }
        
        if($withCredit)
        {
            $credits     = Asset::model()->with('tool')->findAll('t.game_id = :game AND t.status=:status AND t.tool_id = :credit', array(':game'=> $progress->game_id, ':status'=>'o', ':credit' => 4));
            //CVarDumper::dump($credits, 10, true);
            if(count($credits) > 0)
            {
                foreach ($credits as $credit)
                {
                    $tool = ToolFactory::getTool($credit->tool_id, $progress);
                    $tool->setAsset($credit);
                    $payment = $tool->monthPayment($tool->getProcent(), $credit->step_end - $credit->step_start, $credit->balance_start);
                    $output -=$payment;
                }
            }
        }
        return $output;
    }
}
