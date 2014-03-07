<?php
class ShareRateManager {
    
    /*
     * Set new rates for all financinal tools (with type = 'a') for each step
     * @param Progress $progress current game step
     * @return Boolean TRUE/FALSE
     */
    static public function newRates(Progress $progress)
    {
        $toolRates = Tool::model()->with(array(
            'userConfig'    => array(
                'condition' => 'game_id = :game',
                'params'    => array(':game' => $progress->game_id)
            )
        ))->findAllByAttributes(array('type' => 'a'));
        if(count($toolRates > 0))
        {
            foreach ($toolRates as $tool)
            {
                
                $rate = new ShareRate;
                $rate->tool_id      = $tool->id;
                $rate->progress_id  = $progress->id;
                $rate->game_id      = $progress->game_id;
                $rate->value        = self::generateRate($tool);
                $rate->save();
            }
            return ($rate->getErrors() === NULL)?TRUE:FALSE;
        }
        else
        {
            return FALSE;
        }
    }
    /*
     * Get last rate of financinal tool
     * @param Tool $tool current financinal tool
     * @param Progress $progress current game step
     * @return int rate value
     */
    static public function getLastRate($toolId, Progress $progress)
    {
        $rate = ShareRate::model()->findAll(array(
            'select'    => 't.id, t.tool_id, t.progress_id, t.game_id, t.value',
            'condition' => 't.tool_id = :tool and t.game_id = :game',
            'order'     => 't.progress_id DESC',
            'limit'     => '1',
            'params'    => array('tool' => $toolId, 'game' => $progress->game_id)
        ));
        return $rate[0]->value;
    }
    
    static public function getToolRates($toolId, Progress $progress, $limit = 10)
    {
        $ratesAR = ShareRate::model()->with('progress')->findAll(array(
            'select'    => 't.id, t.tool_id, t.progress_id, t.game_id, t.value',
            'condition' => 't.tool_id = :tool and t.game_id = :game',
            'order'     => 't.progress_id DESC',
            'limit'     => $limit,
            'params'    => array('tool' => $toolId, 'game' => $progress->game_id)
        ));
        $rates = array(); 
        $steps = array();
        foreach ($ratesAR as $rate)
        {
            array_unshift($rates, (int)$rate->value);
            array_unshift($steps, (int)$rate->progress->step);
        }
        
        return array($rates, $steps);
    }
    
    /*
     * Generate new rate value.
     * Calculating based on base price + random
     * @param Tool $tool current financinal tool
     * @return int new rate value
     */
    static public function generateRate(Tool $tool)
    {
        return $tool->userConfig->base_price + round((mt_rand(1, $tool->userConfig->range) - ($tool->userConfig->range / 2)));
    }
}