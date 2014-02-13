<?php
class CharityMicrosoft implements IEvent{
    public function beforeEventHandler(\Progress $progress, \Event $event) {
        //echo '<div style="position: absolute; top: 0px; left: 0px;">start event CHARITY OF MICROSOFT</div>';
       //Yii::app()->user->setFlash('success', 'Наступило событие по Майкрософт.');
       $meCountTool = Tool::model()->findByPk(7);
       $meCountTool->status = 0;
      // CVarDumper::dump($meCountTool, 10, true);
       $meCountTool->save();
       
    }
    
    public function afterEventHandler(\Progress $progress, \EventInProgress $event) {
        //echo '<div style="position: absolute; top: 0px; left: 0px;">end event CHARITY OF MICROSOFT</div>';
        //Yii::app()->user->setFlash('success', 'Окончилось событие по Майкрософт.');
        $meCountTool = Tool::model()->findByPk(7);
        $meCountTool->status = 1;
        $meCountTool->save();
    }
}
