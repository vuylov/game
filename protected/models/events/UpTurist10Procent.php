<?php
class UpTurist10Procent implements IEvent{
     public function beforeEventHandler(\Progress $progress, \Event $event) {
         //change base price
         $tool = Tool::model()->findByPk(8);
         $tool->in_total_min = 95;
         $tool->save();
         //change 1 round price
         $rate          = ShareRate::model()->find('tool_id = :tool AND progress_id = :progress', array(':tool' => 8, ':progress'=>$progress->id));
         $rate->value   = 95;
         $rate->save();
     }
     public function afterEventHandler(\Progress $progress, \EventInProgress $event) {
         //return base price
         $tool = Tool::model()->findByPk(8);
         $tool->in_total_min = 85;
         if(!$tool->save())
         {
             $msg = $tool->getErrors();
             Yii::app()->user->setFlash('success', 'Наступило событие по Майкрософт.');
         }
     }
}
