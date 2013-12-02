<?php

class ConsumerCreditController extends SecureController {
   public function beforeAction($action) {
        Yii::app()->clientscript->scriptMap['jquery.js'] = false;
        Yii::app()->clientscript->scriptMap['jquery.ui.js'] = false;
        Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
        return parent::beforeAction($action);
    }
    
    public function actionClose($id)
    {
       $progress    = Yii::app()->user->getState('lastStep');
       $asset       = Asset::model()->findByPk($id);
       $credit      = ToolFactory::getTool($asset->tool_id);
       if($credit->closeCredit($progress, $asset))
       {
           $response= $this->renderPartial('success', array(), true, true);
           echo $response;
       }
       else
       {
           $response= $this->renderPartial('fail', array(), true, true);
           echo $response;
       }
    }
}
