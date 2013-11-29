<?php

class ToolController extends SecureController
{
    
        public function beforeAction($action) {
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.ui.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            return parent::beforeAction($action);
        }
        
        public function actionView($id)
        {
            //echo 100;
            $tool       = Tool::model()->findByPk($id);
            $response   = $this->renderPartial('view', array('tool' => $tool), true, true);
            echo $response;
        }
        
        public function actionUse($id)
        {
            $tool       = Tool::model()->findByPk($id);
            $step       = Yii::app()->user->getState('lastStep');
            switch ($tool->type) {
                case 'd':
                    $response = $this->renderPartial('deposit/index', array('tool' => $tool, 'step' => $step), true, true);
                    echo $response;
                    break;
                case 'c':
                    echo 'Это занимаем денюфки';
                    break;
                default:
                    echo 'Хз xnj это';
                    break;
            }
        }
        
        public function actionProcess()
        {
            
            $step       = Yii::app()->user->getState('lastStep');
            $toolId     = Yii::app()->request->getPost('tool');
            $quanStep        = Yii::app()->request->getPost('step');
            $deposit    = Yii::app()->request->getPost('deposit');
            
            $asset      = new Asset;
            $asset->progress_id = $step->id;
            $asset->game_id     = $step->game_id;
            $asset->tool_id     = $toolId;
            $asset->step_start  = $step->step;
            $asset->step_end    = (int)$step->step + (int)$quanStep;
            $asset->balance     = $deposit;
            
            if(!$asset->save())
            {
                echo CVarDumper::dump($asset->getErrors(), 10, true);
            }
            else
            {
                echo 'Модель сохранена';
            }
            //echo $toolId;
        }

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}