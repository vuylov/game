<?php

class ToolFactory {
    //put your code here
    public static function getTool($toolId, Progress $progress)
    {
        $tool = Tool::model()->with(array(
            'userConfig'=>array(
                'condition' => 'game_id = :game',
                'params'    => array(':game' => $progress->game_id)
            )
        ))->findByPk($toolId);
        return new $tool->class($tool);
    }
}
