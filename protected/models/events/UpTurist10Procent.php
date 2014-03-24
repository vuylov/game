<?php
class UpTurist10Procent implements IEvent{
     public function beforeEventHandler(\Progress $progress, \Event $event) {
         //change base price
         $tool = UserToolConfig::model()->find('game_id = :game AND tool_id = :tool', array(':game' => $progress->game_id, ':tool' => 8));
         $tool->base_price = 105;
         $tool->save();
     }
     public function afterEventHandler(\Progress $progress, \EventInProgress $event) {
         //return base price
         $tool = UserToolConfig::model()->find('game_id = :game AND tool_id = :tool', array(':game' => $progress->game_id, ':tool' => 8));
         $tool->base_price = 97;
         if(!$tool->save())
         {
             $msg = $tool->getErrors();
         }
     }
}
