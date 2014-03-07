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
            $step       = Yii::app()->user->getState('lastStep');
            $tool       = Tool::model()->with(array(
                'userConfig'=>array(
                    'condition' => 'game_id = :game',
                    'params'    => array(':game' => $step->game_id)
                )
            ))->findByPk($id);
            $response   = $this->renderPartial('view', array('tool' => $tool), true, true);
            echo $response;
        }
        
        public function actionUse($id)
        {
            $step       = Yii::app()->user->getState('lastStep');
            $tool       = Tool::model()->with(array(
                'userConfig' => array(
                    'condition' => 'game_id = :game',
                    'params'    => array(':game' => $step->game_id)
                )
            ))->findByPk($id);
            $response = $this->renderPartial($tool->class.'/index', array('tool' => $tool, 'step' => $step), true, true);
            echo $response;
        }
        
        public function actionProcess()
        {
            
            $step       = Yii::app()->user->getState('lastStep');
            $formData   = Yii::app()->request->getPost('Tool');
            
            //get proper tool class with class factory
            $tool           = ToolFactory::getTool($formData['id'], $step);
            //instantiate asset and save it
            $tool->instantiateAsset($step, $formData);
            //change deposit in current progress of user
            $tool->startProcess($step);

            $step->save();
            Yii::app()->user->setState('lastStep', $step);
            $response = $this->renderPartial('//game/play', array('step'=>$step), true, true);
            echo $response;
        }
}