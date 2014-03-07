<?php
class CheckCredit {
    public static function isUserHaveCredit(Progress $progress)
    {
        $assets = Asset::model()->findAll(array(
            'condition' => 'game_id = :game AND tool_id = 4 AND status = "o"',
            'params'    => array(
                ':game' => $progress->game_id
            ),
        ));
        
        if(count($assets) > 0)
            return TRUE;
        return FALSE;
    }
}
