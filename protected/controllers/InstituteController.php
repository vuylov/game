<?php
class InstituteController extends SecureController{
    public function beforeAction($action) {
        Yii::app()->clientscript->scriptMap['jquery.js'] = false;
        Yii::app()->clientscript->scriptMap['jquery.ui.js'] = false;
        Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
        return parent::beforeAction($action);
    }
    
    public function actionShop()
    {
        $worthes = Worth::model()->findAll(array(
            'condition' => 'status = 1',
            'order'     => 'price_buy'
        ));
        $response = $this->renderPartial('shop', array('worthes'=> $worthes), true, true);
        echo $response;
    }
    public function actionHome()
    {
        $step = Yii::app()->user->getState('lastStep'); 
        $response = $this->renderPartial('home', array('step'=>$step), true, true);
        echo $response;
    }
    
    public function actionBank()
    {
        $progress   = Yii::app()->user->getState('lastStep');
        $tools       = Institute::model()->with('tools')->findByPk(1);
        
        $response = $this->renderPartial('show', array('tools'=>$tools, 'progress'=>$progress), true, true);
        echo $response;
    }
    
    public function actionInsure()
    {
        $response = $this->renderPartial('insure', array(), true, true);
        echo $response;
    }
    
    public function actionPif()
    {
        $progress = Yii::app()->user->getState('lastStep');
        $tools = Institute::model()->with('tools')->findByPk(2);
        
        $response = $this->renderPartial('show', array('tools'=>$tools, 'progress'=>$progress), true, true);
        echo $response;
    }
    
    public function actionFound()
    {
        $progress = Yii::app()->user->getState('lastStep');
        $tools = Institute::model()->with('tools')->findByPk(3);
        
        $response = $this->renderPartial('show', array('tools'=>$tools, 'progress'=>$progress), true, true);
        echo $response;
    }
}
