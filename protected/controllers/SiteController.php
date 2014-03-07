<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
        
        public function actionRanking()
        {
            $gameDataProvider  = new CActiveDataProvider('Game', array(
                'criteria' => array(
                    'condition' => 'status = 0',
                    'order'     => 'scores DESC',
                    'with'      => array('user')
                ),
                'pagination' => array(
                    'pageSize'  => 10,
                ),
            ));
            $this->render('ranking', array('dataProvider' => $gameDataProvider));
        }

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
            $this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
        
        public function actionRegistration()
        {
            $user = new User('register');
            
            if(isset($_POST['User']))
            {
                $user->attributes = $_POST['User'];
                if($user->validate())
                {
                    $uncryptPassword = $user->password;
                    if($user->save())
                    {
                        //var_dump($user->email.' '.$uncryptPassword);                    
                        $identity = new UserIdentity($user->email, $uncryptPassword);
                        if($identity->authenticate())
                        {
                            Yii::app()->user->login($identity);
                            $this->redirect(array('game/list'), true);
                        }
                        else
                        {
                            $this->redirect(array('site/login'), true);
                        }
                    }
                }
                
            }
            $this->render('registration', array('user'=>$user));
        }
        
        public function actionForgetPassword()
        {
            
        }
}