<?php
class InsuranceController extends SecureController{
     public function beforeAction($action) {
        Yii::app()->clientscript->scriptMap['jquery.js'] = false;
        Yii::app()->clientscript->scriptMap['jquery.ui.js'] = false;
        Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
        return parent::beforeAction($action);
    }
    
    public function actionInsure($id)
    {
        if(!$id && !is_int($id))
            echo 'Ошибка параметра';
        
        $action = Action::model()->with('worth')->findByPk($id);
        if(!$action){
            echo 'Такой ценности в игре не предусмотрено';
        }
        else{
            $delta  = round($action->worth->price_buy * $action->worth->insurance / 100);
            $progress = Yii::app()->user->getState('lastStep');
            
            if($progress->deposit < $delta){//not enough money
                echo 'У вас недостаточно денег для страхования данного вида собственности';
            }
            else{
            
            $progress->deposit = $progress->deposit - $delta;
            $progress->save();
            
            //save action in insure store
            $insure                 = new WorthInsure;
            $insure->game_id        = $progress->game_id;
            $insure->progress_id    = $progress->id;
            $insure->action_id      = $action->id;
            $insure->worth_id       = $action->worth_id;
            $insure->step_start     = $progress->step;
            $insure->step_end       = $progress->step + Yii::app()->params['insure_period'];
            $insure->value          = $delta;
            $insure->status         = 1;
            $insure->save();
            $response = $this->renderPartial('insure', array('worth' => $action->worth, 'progress' => $progress), true, true);
            echo $response;
            }
        }
    }
}
