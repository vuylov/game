<?php

class ToolFactory {
    //put your code here
    public static function getTool($toolId)
    {
        $tool = Tool::model()->findByPk($toolId);
        return new $tool->class($tool);
    }
}
