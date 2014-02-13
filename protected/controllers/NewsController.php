<?php
class NewsController extends SecureController{
    public function beforeAction($action) {
        Yii::app()->clientscript->scriptMap['jquery.js'] = false;
        Yii::app()->clientscript->scriptMap['jquery.ui.js'] = false;
        Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
        return parent::beforeAction($action);
    }
    
    public function actionShow($id)
    {
        $news = News::model()->findByPk($id);
        if($news)
        {
            $this->renderPartial('show', array('news' => $news));
            Yii::app()->end();
        }   
        echo 'Такой новости нет!';
    }
}
