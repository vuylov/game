<?php
class ShareRateManager {
    
    /*
     * Set new rates for all financinal tools (with type = 'a') for each step
     * @param Progress $progress current game step
     * @return Boolean TRUE/FALSE
     */
    static public function newRates(Progress $progress)
    {
        $toolRates = Tool::model()->findAllByAttributes(array('type' => 'a'));
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
    /*
     * Generate new rate value.
     * Calculating based on base price + random
     * @param Tool $tool current financinal tool
     * @return int new rate value
     */
    static public function generateRate(Tool $tool)
    {
        return $tool->in_total_min + round((mt_rand(1, $tool->in_total_max) - ($tool->in_total_max / 2)));
    }
}