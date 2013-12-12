<?php
class AssetController extends SecureController {
    public function beforeAction($action) {
        Yii::app()->clientscript->scriptMap['jquery.js'] = false;
        Yii::app()->clientscript->scriptMap['jquery.ui.js'] = false;
        Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
        return parent::beforeAction($action);
    }
    
    public function actionView($id)
    {
        $step   = Yii::app()->user->getState('lastStep');
        $asset  = Asset::model()->with('tool')->findByPk($id);
        $tool   = ToolFactory::getTool($asset->tool_id);
        $tool->setAsset($asset);
        $response = $this->renderPartial(get_class($tool).'/view', array('tool' => $tool, 'asset' => $asset, 'progress'=> $step), true, true);
        echo $response;
    }
}
