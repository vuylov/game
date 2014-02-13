<?php
class EventController extends SecureController{
    public function beforeAction($action) {
        Yii::app()->clientscript->scriptMap['jquery.js'] = false;
        Yii::app()->clientscript->scriptMap['jquery.ui.js'] = false;
        Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
        return parent::beforeAction($action);
    }
    
    public function actionShow($id)
    {
        $event = Event::model()->findByPk($id);
        if($event)
        {
            $this->renderPartial('show', array('event' => $event));
            Yii::app()->end();
        }   
        echo 'Такого события нет!';
    }
}
