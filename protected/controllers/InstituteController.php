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
        $step = Yii::app()->user->getState('lastStep'); 
        //fetch shop items not buying yield
        $worthes = Worth::model()->findAll(array(
            'condition' => 't.status = 1 AND t.id NOT IN (SELECT worth_id FROM action WHERE status="b" AND game_id='.$step->game_id.')',
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
    
    /*
     * Выбираем все инструменты банка и их пользовательские значения
     */
    public function actionBank()
    {
        $progress   = Yii::app()->user->getState('lastStep');
        $bank       = Institute::model()->with(array(
            'tools' => array(
                'with' => array(
                    'userConfig' => array(
                        'condition' => 'game_id = :game',
                        'params'    => array(':game' => $progress->game_id)
                    )
                )
            ) 
        ))->findByPk(1);
        
        $response = $this->renderPartial('show', array('tool' => $bank,'tools'=>$bank->tools, 'progress'=>$progress), true, true);
        echo $response;
    }
    
    public function actionInsure()
    {
        $progress   = Yii::app()->user->getState('lastStep');
        $insure      = Institute::model()->with(array(
            'tools' => array(
                'with' => array(
                    'userConfig' => array(
                        'condition' => 'game_id = :game',
                        'params'    => array(':game' => $progress->game_id)
                    )
                )
            )
        ))->findByPk(4);
        
        $response = $this->renderPartial('show', array('tool' => $insure,'tools'=>$insure->tools, 'progress'=>$progress), true, true);
        echo $response;
    }
    
    public function actionPif()
    {
        $progress = Yii::app()->user->getState('lastStep');
        $pif = Institute::model()->with(array(
            'tools' => array(
                'with' => array(
                    'userConfig' => array(
                        'condition' => 'game_id = :game',
                        'params'    => array(':game' => $progress->game_id)
                    )
                )
            )
        ))->findByPk(2);
        
        $response = $this->renderPartial('show', array('tool' => $pif, 'tools'=>$pif->tools, 'progress'=>$progress), true, true);
        echo $response;
    }
    
    public function actionFound()
    {
        $progress = Yii::app()->user->getState('lastStep');
        $found = Institute::model()->with(array(
            'tools' => array(
                'with' => array(
                    'userConfig' => array(
                        'condition' => 'game_id = :game',
                        'params'    => array(':game' => $progress->game_id)
                    )
                )
            )
        ))->findByPk(3);
        
        $response = $this->renderPartial('show', array('tool' => $found, 'tools'=>$found->tools, 'progress'=>$progress), true, true);
        echo $response;
    }
}
