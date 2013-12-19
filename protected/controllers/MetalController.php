<?php
class MetalController extends SecureController {
    public function beforeAction($action) {
        Yii::app()->clientscript->scriptMap['jquery.js'] = false;
        Yii::app()->clientscript->scriptMap['jquery.ui.js'] = false;
        Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
        return parent::beforeAction($action);
    }
    
    public function actionSell()
    {
        $progress    = Yii::app()->user->getState('lastStep');
        $formData = Yii::app()->request->getPost('Metal');
        
        //Check for validate tool and user
        $gameId   = Yii::app()->user->getState('currentGameId');
        $asset    = Asset::model()->findAllByAttributes(array('game_id' => $gameId, 'id' => $formData['id']));
        //CVarDumper::dump($asset, 10, true);
        //exit;
        if(count($asset)<1)
        {
            $msg = 'Не надо баловаться';
            $response = $this->renderPartial('msg', array('msg' =>$msg), true, true);
            echo $response;
            Yii::app()->end();
        }
        
        $asset = $asset[0];
        
        $stockShare = ToolFactory::getTool($asset->tool_id);
        if($asset->number < $formData['number'])
        {
            $msg = 'У вас нет столько золота';
            $response = $this->renderPartial('msg', array('msg' =>$msg), true, true);
            echo $response;
            Yii::app()->end();
        }
        elseif($asset->number == $formData['number'])
        {
            $stockShare->endProcess($progress, $asset);
            $msg = 'Все золото продано';
            $response = $this->renderPartial('msg', array('msg' =>$msg), true, true);
            echo $response;
            Yii::app()->end();
        }
        else
        {
            if($stockShare->sellShare($asset, $progress, $formData['number']))
            {
                $msg = $formData['number'].' золота продано';
                $response = $this->renderPartial('msg', array('msg' =>$msg), true, true);
                echo $response;
                Yii::app()->end();
            }
        }
    }
}
